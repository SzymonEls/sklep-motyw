"""Renders product photos for the local demo store (not part of the theme).

Usage: python3 render-products.py <output-dir>
"""
import os
import sys

sys.path.insert(0, os.path.dirname(__file__))
from render import Scene, draw, mug, lamp, flame, leaves, sticks, handle  # noqa: E402

W, H = 1200, 1500
BACKGROUNDS = {
    'warm': (('#EFE7DC', '#E8DED0'), ('#DED1BF', '#E6DACA')),
    'sand': (('#ECE3D3', '#E3D8C5'), ('#D8C9B2', '#E1D4C0')),
    'sage': (('#E3E6DC', '#D9DDD0'), ('#C9CEBE', '#D3D8C9')),
    'blush': (('#F0E1D8', '#E8D5CA'), ('#DCC3B4', '#E5D0C3')),
    'stone': (('#E6E4DF', '#DCD9D2'), ('#CCC8BF', '#D6D2CA')),
    'dusk': (('#2B303B', '#323845'), ('#252A34', '#2D333F')),
}


def shot(out, name, bg, fn, horizon=0.68):
    wall, floor = BACKGROUNDS[bg]
    s = Scene(W, H, wall, floor, int(H * horizon), beam_strength=0.15 if bg != 'dusk' else 0.0, beams=bg != 'dusk', vignette=0.14)
    fn(s)
    s.save(os.path.join(out, name + '.jpg'), quality=82)
    print('rendered', name, flush=True)


def pitcher(s, cx, base, size, color, glaze):
    handle(s, cx + size * 0.5, base - size * 1.25 * 0.55, size * 0.24, size * 0.34, size * 0.09, glaze, side=1)
    draw(s, 'pitcher', cx, base, size, color, height_ratio=1.25, open_top=True, gloss=0.45, glaze_split=0.18, glaze_color=glaze, speck=0.003)


def main(out):
    os.makedirs(out, exist_ok=True)
    B = 1150  # base line of objects in product shots

    shot(out, 'amfora', 'warm', lambda s: draw(s, 'amphora', 600, B, 538, '#C9714A', height_ratio=1.45, gloss=0.35, speck=0.004, open_top=True, glaze_split=0.35, glaze_color='#D8875E'))
    shot(out, 'amfora-2', 'sage', lambda s: draw(s, 'amphora', 600, B, 538, '#B9A88F', height_ratio=1.45, gloss=0.45, speck=0.004, open_top=True, glaze_split=0.3, glaze_color='#6F7F5C'))

    shot(out, 'smukly', 'stone', lambda s: draw(s, 'bottle', 600, B, 422, '#F1EBE2', height_ratio=2.25, gloss=0.55, shininess=50, open_top=True, speck=0.002))
    shot(out, 'smukly-2', 'blush', lambda s: draw(s, 'bottle', 600, B, 422, '#3F4E43', height_ratio=2.25, gloss=0.6, shininess=50, open_top=True))

    shot(out, 'kula', 'sand', lambda s: draw(s, 'globe_vase', 600, B, 550, '#E7DCCB', height_ratio=1.2, gloss=0.3, speck=0.006, open_top=True))
    shot(out, 'kula-2', 'warm', lambda s: (draw(s, 'globe_vase', 420, B, 390, '#E7DCCB', height_ratio=1.2, gloss=0.3, speck=0.006, open_top=True),
                                           draw(s, 'globe_vase', 900, B + 50, 250, '#B66A45', height_ratio=1.2, gloss=0.4, open_top=True)))

    for slug, glaze, bg in (('kubek-szalwia', '#7C8F78', 'sage'), ('kubek-piasek', '#D9C7A8', 'sand'), ('kubek-ocean', '#3F5A73', 'stone')):
        shot(out, slug, bg, lambda s, glaze=glaze: mug(s, 560, B, 486, '#ECE5D8', glaze=glaze))
    shot(out, 'kubek-zestaw', 'warm', lambda s: (mug(s, 290, B - 60, 300, '#ECE5D8', glaze='#7C8F78'),
                                                 mug(s, 900, B - 40, 290, '#ECE5D8', glaze='#D9C7A8', side=-1),
                                                 mug(s, 600, B + 40, 320, '#ECE5D8', glaze='#3F5A73')))

    shot(out, 'espresso', 'blush', lambda s: (draw(s, 'plate', 600, B + 20, 384, '#F4EEE6', height_ratio=0.1, open_top=True, rim_ratio=0.3, gloss=0.5),
                                              draw(s, 'cup', 600, B - 10, 294, '#F4EEE6', height_ratio=0.75, open_top=True, gloss=0.55, glaze_split=0.12, glaze_color='#C9714A')))

    shot(out, 'misa', 'stone', lambda s: draw(s, 'bowl', 600, B, 538, '#F1EAE0', height_ratio=0.58, open_top=True, rim_ratio=0.34, glaze_split=0.25, glaze_color='#3F5A73', gloss=0.5))
    shot(out, 'misa-2', 'sand', lambda s: (draw(s, 'bowl', 600, B, 538, '#F1EAE0', height_ratio=0.58, open_top=True, rim_ratio=0.34, glaze_split=0.25, glaze_color='#3F5A73', gloss=0.5),
                                           draw(s, 'bowl', 600, B - 140, 384, '#F1EAE0', height_ratio=0.58, open_top=True, rim_ratio=0.34, glaze_split=0.25, glaze_color='#7C8F78', gloss=0.5, shadow=False)))

    def plates(s):
        y = B + 30
        for size, col in ((470, '#F3EDE4'), (460, '#E3D6C5'), (450, '#F3EDE4')):
            draw(s, 'plate', 600, y, size, col, height_ratio=0.09, gloss=0.5, open_top=True, rim_ratio=0.32)
            y -= size * 0.09 * 0.92
    shot(out, 'talerz', 'warm', plates)

    shot(out, 'dzbanek', 'sage', lambda s: pitcher(s, 560, B, 435, '#ECE5D8', '#E9E2D4'))
    shot(out, 'dzbanek-2', 'blush', lambda s: pitcher(s, 560, B, 435, '#ECE5D8', '#C9714A'))

    shot(out, 'lampa', 'dusk', lambda s: lamp(s, 600, B, 717))
    shot(out, 'lampa-2', 'stone', lambda s: lamp(s, 600, B, 717, lit=False, shade_color='#F4EFE6', base_color='#B08A5B'))

    shot(out, 'swieca', 'dusk', lambda s: (draw(s, 'candle_jar', 600, B, 422, '#C9B79A', height_ratio=1.0, open_top=True, inner='#F0DFC0', gloss=0.4), flame(s, 600, B - 422 - 16, 96)))
    shot(out, 'swieca-2', 'warm', lambda s: draw(s, 'candle_jar', 600, B, 422, '#C9B79A', height_ratio=1.0, open_top=True, inner='#F0DFC0', gloss=0.4))

    shot(out, 'dyfuzor', 'sand', lambda s: (draw(s, 'diffuser', 600, B, 422, '#5C4632', height_ratio=1.3, gloss=0.6, shininess=60), sticks(s, 600, B - 422 * 1.3 + 10, n=6, length=560)))

    shot(out, 'doniczka', 'sage', lambda s: (draw(s, 'pot', 600, B, 486, '#E8DFD2', height_ratio=0.85, open_top=True, gloss=0.2, speck=0.004, inner='#3A2E25'),
                                             leaves(s, 600, B - 486 * 0.85 + 26, 500, n=13, spread=82, color='#3F6B45', seed=5)))
    shot(out, 'doniczka-2', 'warm', lambda s: draw(s, 'pot', 600, B, 486, '#C9714A', height_ratio=0.85, open_top=True, gloss=0.25, speck=0.004, inner='#3A2E25'))


if __name__ == '__main__':
    main(sys.argv[1] if len(sys.argv) > 1 else 'images')
