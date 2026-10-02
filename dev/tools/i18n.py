"""Translation tooling for the Witryna theme (no gettext/WP-CLI required).

  python3 dev/tools/i18n.py pot        regenerate languages/witryna.pot
  python3 dev/tools/i18n.py update     merge the POT into languages/*.po (keeps translations)
  python3 dev/tools/i18n.py compile    build .mo and .l10n.php files from languages/*.po

Strings are collected from PHP gettext calls (with translator comments),
pattern headers, theme.json, style variations and the style.css header,
using the same contexts WordPress applies when translating them.
"""
import glob
import json
import os
import re
import struct
import sys
from collections import OrderedDict

ROOT = os.path.abspath(os.path.join(os.path.dirname(__file__), '..', '..'))
THEME_PHP = ('functions.php', 'inc', 'patterns', 'templates', 'parts')
LANG = os.path.join(ROOT, 'languages')
DOMAIN = 'witryna'

# ---------------------------------------------------------------------------
# Extraction
# ---------------------------------------------------------------------------

PHP_STRING = r"'((?:[^'\\]|\\.)*)'"
FUNCS = {
    # name: (argument roles)
    '__': ('s',), '_e': ('s',), 'esc_html__': ('s',), 'esc_html_e': ('s',), 'esc_attr__': ('s',), 'esc_attr_e': ('s',),
    '_x': ('s', 'c'), '_ex': ('s', 'c'), 'esc_html_x': ('s', 'c'), 'esc_attr_x': ('s', 'c'),
    '_n': ('s', 'p'), '_nx': ('s', 'p', 'c'),
}
CALL = re.compile(r"\b(" + '|'.join(sorted(FUNCS, key=len, reverse=True)) + r")\(\s*")
TRANSLATORS = re.compile(r"/\*\s*translators:(.*?)\*/", re.S)


def unescape_php(s):
    return s.replace("\\'", "'").replace('\\\\', '\\')


def parse_args(src, pos):
    """Parses comma separated arguments starting at pos; returns list of literals or None."""
    args, depth, cur = [], 0, ''
    i = pos
    while i < len(src):
        ch = src[i]
        if ch == "'":
            m = re.match(PHP_STRING, src[i:], re.S)
            cur += m.group(0)
            i += len(m.group(0))
            continue
        if ch in '([':
            depth += 1
        elif ch in ')]':
            if depth == 0:
                args.append(cur.strip())
                return args
            depth -= 1
        elif ch == ',' and depth == 0:
            args.append(cur.strip())
            cur = ''
            i += 1
            continue
        cur += ch
        i += 1
    return None


class Catalog:
    def __init__(self):
        self.entries = OrderedDict()

    def add(self, msgid, ref, context=None, plural=None, comment=None):
        if not msgid:
            return
        key = (context, msgid)
        e = self.entries.setdefault(key, {'msgid': msgid, 'context': context, 'plural': plural, 'refs': [], 'comments': []})
        if ref not in e['refs']:
            e['refs'].append(ref)
        if comment and comment not in e['comments']:
            e['comments'].append(comment)
        if plural:
            e['plural'] = plural


def extract_php(cat):
    paths = []
    for entry in THEME_PHP:
        full = os.path.join(ROOT, entry)
        paths += [full] if full.endswith('.php') else glob.glob(os.path.join(full, '**', '*.php'), recursive=True)
    for path in sorted(paths):
        rel = os.path.relpath(path, ROOT)
        src = open(path, encoding='utf-8').read()
        # Pattern headers.
        if rel.startswith('patterns' + os.sep):
            head = src[:1500]
            for field, ctx in (('Title', 'Pattern title'), ('Description', 'Pattern description')):
                m = re.search(r"^\s*\*\s*" + field + r":\s*(.+)$", head, re.M)
                if m:
                    cat.add(m.group(1).strip(), rel, ctx)
        for m in CALL.finditer(src):
            fn = m.group(1)
            args = parse_args(src, m.end())
            if not args:
                continue
            roles = FUNCS[fn]
            values = {}
            ok = True
            for role, arg in zip(roles, args):
                lit = re.fullmatch(PHP_STRING, arg, re.S)
                if not lit:
                    ok = False
                    break
                values[role] = unescape_php(lit.group(1))
            domain_arg = args[len(roles)] if fn not in ('_n', '_nx') else args[len(roles) + 1] if len(args) > len(roles) + 1 else ''
            if not ok or DOMAIN not in domain_arg:
                continue
            line = src.count('\n', 0, m.start()) + 1
            before = src[max(0, m.start() - 300):m.start()]
            tc = TRANSLATORS.findall(before)
            comment = None
            if tc and before.rfind('*/') > before.rfind(';') and before.rfind('*/') > before.rfind('?>'):
                comment = 'translators:' + tc[-1].rstrip()
            cat.add(values['s'], f'{rel}:{line}', values.get('c'), values.get('p'), comment)


def extract_json(cat):
    schema = {
        'settings.typography.fontSizes.name': 'Font size name',
        'settings.typography.fontFamilies.name': 'Font family name',
        'settings.color.palette.name': 'Color name',
        'settings.color.gradients.name': 'Gradient name',
        'settings.color.duotone.name': 'Duotone name',
        'settings.spacing.spacingSizes.name': 'Space size name',
        'settings.dimensions.aspectRatios.name': 'Aspect ratio name',
        'settings.shadow.presets.name': 'Shadow name',
        'settings.border.radiusSizes.name': 'Border radius size name',
        'customTemplates.title': 'Custom template name',
        'templateParts.title': 'Template part name',
    }
    files = [os.path.join(ROOT, 'theme.json')] + sorted(glob.glob(os.path.join(ROOT, 'styles', '**', '*.json'), recursive=True))
    for path in files:
        rel = os.path.relpath(path, ROOT)
        data = json.load(open(path, encoding='utf-8'))
        if 'title' in data and rel != 'theme.json':
            cat.add(data['title'], rel, 'Style variation name')
        for dotted, ctx in schema.items():
            parts = dotted.split('.')
            node = data
            for p in parts[:-2]:
                node = node.get(p, {}) if isinstance(node, dict) else {}
            items = node.get(parts[-2], []) if isinstance(node, dict) else []
            for item in items if isinstance(items, list) else []:
                if isinstance(item, dict) and parts[-1] in item:
                    cat.add(item[parts[-1]], rel, ctx)


def extract_style_css(cat):
    head = open(os.path.join(ROOT, 'style.css'), encoding='utf-8').read()[:4000]
    for field, ctx in (('Theme Name', 'Theme Name of the theme'), ('Description', 'Description of the theme')):
        m = re.search(r"^" + field + r":\s*(.+)$", head, re.M)
        if m:
            cat.add(m.group(1).strip(), 'style.css', ctx)


def build_catalog():
    cat = Catalog()
    extract_style_css(cat)
    extract_json(cat)
    extract_php(cat)
    return cat


# ---------------------------------------------------------------------------
# PO handling
# ---------------------------------------------------------------------------

def po_quote(s):
    s = s.replace('\\', '\\\\').replace('"', '\\"').replace('\n', '\\n').replace('\t', '\\t')
    return '"' + s + '"'


def write_po(path, entries, header):
    out = [header.rstrip() + '\n']
    for e in entries:
        out.append('')
        for c in e.get('comments', []):
            out.append('#. ' + c.strip())
        if e.get('refs'):
            out.append('#: ' + ' '.join(e['refs']))
        if e.get('context') is not None:
            out.append('msgctxt ' + po_quote(e['context']))
        out.append('msgid ' + po_quote(e['msgid']))
        if e.get('plural'):
            out.append('msgid_plural ' + po_quote(e['plural']))
            tr = e.get('msgstr_plural') or ['', '', '']
            for i, t in enumerate(tr):
                out.append(f'msgstr[{i}] ' + po_quote(t))
        else:
            out.append('msgstr ' + po_quote(e.get('msgstr', '')))
    open(path, 'w', encoding='utf-8').write('\n'.join(out) + '\n')


def po_unquote(s):
    s = s.strip()[1:-1]
    return s.replace('\\n', '\n').replace('\\t', '\t').replace('\\"', '"').replace('\\\\', '\\')


def read_po(path):
    entries, header, cur, last = [], None, {}, None
    for raw in open(path, encoding='utf-8').read().split('\n') + ['']:
        line = raw.strip()
        if not line:
            if 'msgid' in cur:
                if cur['msgid'] == '' and header is None:
                    header = cur
                else:
                    entries.append(cur)
            cur, last = {}, None
            continue
        if line.startswith('#'):
            continue
        m = re.match(r'^(msgctxt|msgid_plural|msgid|msgstr(?:\[\d+\])?)\s+(".*")$', line)
        if m:
            key, val = m.group(1), po_unquote(m.group(2))
            if key.startswith('msgstr['):
                cur.setdefault('msgstr_plural', []).append(val)
                last = ('msgstr_plural', len(cur['msgstr_plural']) - 1)
            else:
                cur[{'msgctxt': 'context', 'msgid_plural': 'plural'}.get(key, key)] = val
                last = ({'msgctxt': 'context', 'msgid_plural': 'plural'}.get(key, key), None)
        elif line.startswith('"') and last:
            if last[1] is None:
                cur[last[0]] += po_unquote(line)
            else:
                cur[last[0]][last[1]] += po_unquote(line)
    return header, entries


POT_HEADER = r'''# Copyright (C) 2026 Witryna
# This file is distributed under the GNU General Public License v2 or later.
msgid ""
msgstr ""
"Project-Id-Version: Witryna 1.1.0\n"
"MIME-Version: 1.0\n"
"Content-Type: text/plain; charset=UTF-8\n"
"Content-Transfer-Encoding: 8bit\n"
"X-Domain: witryna\n"'''


def po_header(lang):
    forms = {
        'pl_PL': 'nplurals=3; plural=(n==1 ? 0 : n%10>=2 && n%10<=4 && (n%100<12 || n%100>14) ? 1 : 2);',
    }.get(lang, 'nplurals=2; plural=(n != 1);')
    return POT_HEADER.replace('"X-Domain: witryna\\n"', f'"Language: {lang}\\n"\n"Plural-Forms: {forms}\\n"\n"X-Domain: witryna\\n"')


def cmd_pot():
    cat = build_catalog()
    os.makedirs(LANG, exist_ok=True)
    write_po(os.path.join(LANG, DOMAIN + '.pot'), list(cat.entries.values()), POT_HEADER)
    print(f'{len(cat.entries)} strings -> languages/{DOMAIN}.pot')
    return cat


def cmd_update():
    cat = cmd_pot()
    for path in glob.glob(os.path.join(LANG, '*.po')):
        lang = os.path.basename(path)[:-3]
        _, old = read_po(path)
        known = {(e.get('context'), e['msgid']): e for e in old}
        merged, missing = [], 0
        for key, e in cat.entries.items():
            n = dict(e)
            if key in known:
                n['msgstr'] = known[key].get('msgstr', '')
                n['msgstr_plural'] = known[key].get('msgstr_plural')
            if not (n.get('msgstr') or (n.get('msgstr_plural') and all(n['msgstr_plural']))):
                missing += 1
            merged.append(n)
        write_po(path, merged, po_header(lang))
        print(f'{lang}: {len(merged)} strings, {missing} untranslated')


def cmd_compile():
    for path in glob.glob(os.path.join(LANG, '*.po')):
        lang = os.path.basename(path)[:-3]
        header, entries = read_po(path)
        messages = {}
        php = {}
        for e in entries:
            key = (e['context'] + '\x04' if e.get('context') is not None else '') + e['msgid']
            if e.get('plural'):
                if not e.get('msgstr_plural') or not all(e['msgstr_plural']):
                    continue
                messages[key + '\x00' + e['plural']] = '\x00'.join(e['msgstr_plural'])
                php[key] = '\x00'.join(e['msgstr_plural'])
            elif e.get('msgstr'):
                messages[key] = e['msgstr']
                php[key] = e['msgstr']
        head = header.get('msgstr', '') if header else ''
        messages[''] = head
        write_mo(os.path.join(LANG, lang + '.mo'), messages)
        write_l10n_php(os.path.join(LANG, lang + '.l10n.php'), php, head)
        print(f'{lang}: compiled {len(php)} translations')


def write_mo(path, messages):
    keys = sorted(messages.keys())
    ids = [k.encode('utf-8') for k in keys]
    strs = [messages[k].encode('utf-8') for k in keys]
    n = len(keys)
    o_ids = 7 * 4
    o_strs = o_ids + n * 8
    o_data = o_strs + n * 8
    id_table, str_table, data = [], [], b''
    for b in ids:
        id_table.append((len(b), o_data + len(data)))
        data += b + b'\x00'
    for b in strs:
        str_table.append((len(b), o_data + len(data)))
        data += b + b'\x00'
    out = struct.pack('<7I', 0x950412de, 0, n, o_ids, o_strs, 0, 0)
    out += b''.join(struct.pack('<2I', *t) for t in id_table)
    out += b''.join(struct.pack('<2I', *t) for t in str_table)
    out += data
    open(path, 'wb').write(out)


def php_str(s):
    """PHP string literal. Context (\\x04) and plural (\\x00) separators are written
    as "\\4" and "\\0", so the file stays plain text."""
    out, buf = [], ''
    for ch in s:
        if ch in '\x00\x04':
            out.append("'" + buf.replace('\\', '\\\\').replace("'", "\\'") + "'")
            out.append('"\\0"' if ch == '\x00' else '"\\4"')
            buf = ''
        else:
            buf += ch
    out.append("'" + buf.replace('\\', '\\\\').replace("'", "\\'") + "'")
    return ' . '.join(out)


def write_l10n_php(path, messages, header):
    meta = {}
    for line in header.split('\n'):
        if ':' in line:
            k, v = line.split(':', 1)
            meta[k.strip()] = v.strip()
    out = ['<?php', 'return array(',
           "\t'domain' => 'witryna',",
           f"\t'plural-forms' => {php_str(meta.get('Plural-Forms', ''))},",
           f"\t'language' => {php_str(meta.get('Language', ''))},",
           "\t'project-id-version' => 'Witryna 1.1.0',",
           "\t'messages' => array("]
    for k in sorted(messages):
        out.append(f"\t\t{php_str(k)} => {php_str(messages[k])},")
    out += ['\t),', ');', '']
    open(path, 'w', encoding='utf-8').write('\n'.join(out))


if __name__ == '__main__':
    cmd = sys.argv[1] if len(sys.argv) > 1 else 'pot'
    {'pot': cmd_pot, 'update': cmd_update, 'compile': cmd_compile}[cmd]()
