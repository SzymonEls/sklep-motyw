"""Procedural still-life renderer for Witryna demo and pattern images.

Objects are surfaces of revolution (vases, mugs, bowls...) shaded analytically
in 2.5D: an orthographic body, an elliptical rim seen slightly from above,
soft cast shadows on the floor and window light on the wall. Everything is
computed with numpy in linear light and encoded to sRGB at the end.

Usage: python3 render.py <output-dir> [--only name,name]
"""
import math
import os
import sys

import numpy as np
from PIL import Image

RNG = np.random.default_rng(7)


# ----------------------------------------------------------------------------
# Colour helpers
# ----------------------------------------------------------------------------

def hex2lin(h):
    h = h.lstrip('#')
    c = np.array([int(h[i:i + 2], 16) / 255 for i in (0, 2, 4)], dtype=np.float32)
    return np.where(c <= 0.04045, c / 12.92, ((c + 0.055) / 1.055) ** 2.4)


def lin2srgb(img):
    img = np.clip(img, 0, 1)
    return np.where(img <= 0.0031308, img * 12.92, 1.055 * np.power(img, 1 / 2.4) - 0.055)


def smoothstep(e0, e1, x):
    t = np.clip((x - e0) / (e1 - e0), 0, 1)
    return t * t * (3 - 2 * t)


def _box_1d(a, r, axis):
    """Box filter of half-width r along an axis using cumulative sums."""
    if r < 1:
        return a
    a = np.swapaxes(a, 0, axis)
    pad = np.concatenate([np.repeat(a[:1], r + 1, axis=0), a, np.repeat(a[-1:], r, axis=0)], axis=0)
    c = np.cumsum(pad, axis=0, dtype=np.float64)
    out = (c[2 * r + 1:] - c[:-(2 * r + 1)]) / (2 * r + 1)
    return np.swapaxes(out.astype(np.float32), 0, axis)


def blur(arr, radius):
    """Approximate Gaussian blur (three box passes) for a 2D float array."""
    if radius <= 0.3:
        return arr
    r = max(1, int(round(radius * 0.87)))
    out = arr.astype(np.float32)
    for _ in range(3):
        out = _box_1d(out, r, 0)
        out = _box_1d(out, r, 1)
    return out


# ----------------------------------------------------------------------------
# Scene
# ----------------------------------------------------------------------------

LIGHT = np.array([-0.55, -0.55, 0.63], dtype=np.float32)
LIGHT /= np.linalg.norm(LIGHT)
HALF = LIGHT + np.array([0, 0, 1], dtype=np.float32)
HALF /= np.linalg.norm(HALF)


class Scene:
    def __init__(self, w, h, wall, floor, horizon, beams=True, beam_color='#FFE9C7', beam_strength=0.22, vignette=0.18):
        self.w, self.h = w, h
        self.horizon = horizon
        yy = np.linspace(0, 1, h, dtype=np.float32)[:, None]
        xx = np.linspace(0, 1, w, dtype=np.float32)[None, :]
        wall_top, wall_bot = hex2lin(wall[0]), hex2lin(wall[1])
        floor_near, floor_far = hex2lin(floor[0]), hex2lin(floor[1])
        hy = horizon / h
        t_wall = np.clip(yy / max(hy, 1e-3), 0, 1)
        img = wall_top * (1 - t_wall[..., None]) + wall_bot * t_wall[..., None]
        t_floor = np.clip((yy - hy) / max(1 - hy, 1e-3), 0, 1)
        floor_img = floor_far * (1 - t_floor[..., None]) + floor_near * t_floor[..., None]
        is_floor = smoothstep(hy - 0.002, hy + 0.004, yy)[..., None]
        img = img * (1 - is_floor) + floor_img * is_floor
        img = np.broadcast_to(img, (h, w, 3)).copy()
        # Contact line where the wall meets the floor.
        img *= (1 - 0.08 * np.exp(-((yy - hy) * h / 5.0) ** 2))[..., None]
        if beams:
            # Window light: two soft slanted beams across wall and floor.
            beam = np.zeros((h, w), dtype=np.float32)
            for x0, width in ((0.12, 0.17), (0.38, 0.09)):
                u = xx - x0 - (yy * 0.55)
                beam += smoothstep(0, 0.02, u) * (1 - smoothstep(width - 0.02, width, u))
            beam = blur(beam, w * 0.006)
            img += beam[..., None] * hex2lin(beam_color) * beam_strength
        self.img = img
        self.vignette = vignette
        self.depth_shadow = np.zeros((h, w), dtype=np.float32)

    def add_shadow(self, mask, base_y, shear=0.62, squash=0.3, strength=0.5, soft=0.018):
        """Projects a silhouette onto the floor and darkens the scene."""
        ys, xs = np.nonzero(mask > 0.5)
        if len(xs) == 0:
            return
        hgt = base_y - ys
        sx = (xs + hgt * shear).astype(np.int32)
        sy = (base_y - hgt * squash).astype(np.int32)
        ok = (sx >= 0) & (sx < self.w) & (sy >= 0) & (sy < self.h)
        sh = np.zeros((self.h, self.w), dtype=np.float32)
        sh[sy[ok], sx[ok]] = 1
        sh = blur(sh, 1.5)
        sh = np.clip(sh * 3, 0, 1)
        sh = blur(sh, self.w * soft) * 0.8 + blur(sh, self.w * soft * 0.3) * 0.2
        # Contact shadow right under the object.
        cols = np.nonzero(mask[int(base_y) - 3:int(base_y), :].max(axis=0) > 0.5)[0] if base_y > 3 else []
        if len(cols):
            cx, rx = (cols.min() + cols.max()) / 2, (cols.max() - cols.min()) / 2 + 2
            yy, xx = np.mgrid[0:self.h, 0:self.w]
            contact = np.exp(-(((xx - cx) / (rx * 1.05)) ** 2 + ((yy - base_y) / (rx * 0.16 + 2)) ** 2) * 2.2)
            sh = np.maximum(sh, contact.astype(np.float32) * 0.9)
        self.img *= (1 - np.clip(sh, 0, 1) * strength)[..., None]

    def composite(self, color, alpha):
        a = alpha[..., None]
        self.img = self.img * (1 - a) + color * a

    def add_glow(self, cx, cy, radius, color, strength):
        yy, xx = np.mgrid[0:self.h, 0:self.w].astype(np.float32)
        d = np.sqrt((xx - cx) ** 2 + (yy - cy) ** 2) / radius
        self.img += (np.exp(-d * d * 2.2) * strength)[..., None] * hex2lin(color)

    def save(self, path, quality=84, grain=0.012):
        img = self.img
        if self.vignette:
            yy, xx = np.mgrid[0:self.h, 0:self.w].astype(np.float32)
            d = np.sqrt(((xx / self.w) - 0.5) ** 2 * 1.2 + ((yy / self.h) - 0.48) ** 2)
            img = img * (1 - self.vignette * smoothstep(0.3, 0.85, d))[..., None]
        out = lin2srgb(img)
        out = out + RNG.normal(0, grain, out.shape[:2])[..., None]
        out = (np.clip(out, 0, 1) * 255).astype(np.uint8)
        Image.fromarray(out).save(path, quality=quality, optimize=True, progressive=True)


# ----------------------------------------------------------------------------
# Objects
# ----------------------------------------------------------------------------

def profile(points, n=900):
    """Smooth radius profile r(t), t in [0, 1] from bottom to top (Catmull-Rom)."""
    pts = np.array(points, dtype=np.float64)
    p = np.vstack([pts[0] * 2 - pts[1], pts, pts[-1] * 2 - pts[-2]])
    t_out = np.linspace(0, 1, n)
    r_out = np.empty(n)
    seg_t = pts[:, 0]
    for i in range(len(pts) - 1):
        p0, p1, p2, p3 = p[i], p[i + 1], p[i + 2], p[i + 3]
        sel = (t_out >= seg_t[i]) & (t_out <= seg_t[i + 1])
        if not sel.any():
            continue
        # Parameterise by t along the segment.
        u = (t_out[sel] - seg_t[i]) / max(seg_t[i + 1] - seg_t[i], 1e-9)
        u2, u3 = u * u, u * u * u
        r_out[sel] = 0.5 * ((2 * p1[1]) + (-p0[1] + p2[1]) * u + (2 * p0[1] - 5 * p1[1] + 4 * p2[1] - p3[1]) * u2 + (-p0[1] + 3 * p1[1] - 3 * p2[1] + p3[1]) * u3)
    k = 6
    pad = np.pad(r_out, (k, k), mode='edge')
    kern = np.hanning(2 * k + 1)
    kern /= kern.sum()
    r_out = np.convolve(pad, kern, mode='valid')
    return t_out.astype(np.float32), np.maximum(r_out, 0.5).astype(np.float32)


def shade(nx, ny, nz, base, gloss=0.35, shininess=36, ambient=0.2, rim_color=None, sheen=0.0, u=None):
    ndl = nx * LIGHT[0] + ny * LIGHT[1] + nz * LIGHT[2]
    lambert = np.clip((ndl + 0.15) / 1.15, 0, 1) ** 1.25
    sky = 0.5 - 0.5 * ny
    fill = np.clip(-nx * 0.5 + 0.5, 0, 1) * 0.12
    diffuse = base * (ambient * (0.7 + 0.3 * sky) + 1.05 * lambert + fill)[..., None]
    ndh = np.clip(nx * HALF[0] + ny * HALF[1] + nz * HALF[2], 0, 1)
    spec = gloss * 0.6 * ndh ** shininess + sheen * ndh ** 5
    if u is not None:
        # Studio softbox reflected on a glazed surface of revolution.
        flat = np.clip(1 - np.abs(ny) * 2.2, 0, 1)
        stripe = np.exp(-((u + 0.42) / 0.11) ** 2) * (0.5 + 0.5 * nz) + 0.3 * np.exp(-((u - 0.72) / 0.06) ** 2)
        spec = spec + gloss * 0.9 * stripe * flat
    fres = (1 - np.clip(nz, 0, 1)) ** 3
    col = diffuse + spec[..., None]
    if rim_color is not None:
        col += fres[..., None] * hex2lin(rim_color) * 0.18
    return col


def speckle(shape, density=0.004, darkness=0.35):
    s = (RNG.random(shape) < density).astype(np.float32)
    s = blur(s, 0.7) * 6
    return 1 - np.clip(s, 0, 1) * darkness


def lathe(scene, cx, base_y, height, prof, color, gloss=0.35, shininess=36, open_top=False,
          rim_ratio=0.22, inner=None, speck=0.0, glaze_split=None, glaze_color=None,
          shadow=True, alpha=1.0, rim_color='#FFF4E2', sheen=0.08, emissive=None):
    """Renders a surface of revolution. prof: list of (t, r_px)."""
    t, r = profile(prof)
    top_y = base_y - height
    reach_bot, reach_top = float(r[0]) * rim_ratio, float(r[-1]) * rim_ratio
    y0 = int(max(top_y - max(r) * rim_ratio - 2, 0))
    y1 = int(min(max(base_y + reach_bot, top_y + reach_top) + 3, scene.h))
    rmax = float(r.max())
    x0, x1 = int(max(cx - rmax - 2, 0)), int(min(cx + rmax + 2, scene.w))
    yy, xx = np.mgrid[y0:y1, x0:x1].astype(np.float32)
    tt = (base_y - yy) / height
    ri = np.interp(np.clip(tt, 0, 1), t, r)
    dr = np.gradient(r, t)
    dri = np.interp(np.clip(tt, 0, 1), t, dr) / height
    u = (xx - cx) / np.maximum(ri, 1e-3)
    inside = (np.abs(u) <= 1) & (tt >= 0) & (tt <= 1)
    # Bottom edge is an ellipse too (we look slightly from above).
    r_bot = float(r[0])
    bottom_ell = ((xx - cx) / max(r_bot, 1e-3)) ** 2 + ((yy - base_y) / max(r_bot * rim_ratio, 1e-3)) ** 2 <= 1
    body = inside | (bottom_ell & (yy >= base_y - 1))
    u = np.clip(u, -1, 1)
    nx = u
    nz = np.sqrt(np.clip(1 - u * u, 0, 1))
    ny = -dri * nz * 1.0
    n = np.sqrt(nx * nx + ny * ny + nz * nz) + 1e-6
    nx, ny, nz = nx / n, ny / n, nz / n
    base_col = np.broadcast_to(hex2lin(color), nx.shape + (3,)).copy()
    if glaze_split is not None and glaze_color is not None:
        # Two-tone glaze: lower part raw clay, upper part glazed, with drips.
        drip = glaze_split + 0.03 * np.sin((xx - cx) / max(rmax, 1) * 9) + 0.015 * np.sin((xx - cx) / max(rmax, 1) * 23)
        gmask = smoothstep(drip - 0.01, drip + 0.01, tt)[..., None]
        base_col = base_col * (1 - gmask) + hex2lin(glaze_color) * gmask
        g = gloss * gmask[..., 0] + 0.05 * (1 - gmask[..., 0])
    else:
        g = gloss
    col = shade(nx, ny, nz, base_col, gloss=g, shininess=shininess, rim_color=rim_color, sheen=sheen, u=u)
    if speck:
        col *= speckle(nx.shape, density=speck)[..., None]
    # Ambient occlusion near the base.
    col *= (0.72 + 0.28 * smoothstep(0, 0.08, tt))[..., None]
    if emissive is not None:
        glow = (0.55 + 0.45 * nz)[..., None]
        col = hex2lin(emissive) * glow * 1.25 + col * 0.15
    alpha_map = body.astype(np.float32)
    # Anti-aliased silhouette.
    edge = np.clip((1 - np.abs(u)) * ri, 0, 1.0)
    alpha_map = np.where(inside, np.minimum(1, edge + 0.0), alpha_map) * (body.astype(np.float32))
    alpha_map = blur(alpha_map, 0.6) * body + alpha_map * (1 - body)
    # Rim ellipse (opening or closed top).
    r_top = float(r[-1])
    ell = ((xx - cx) / max(r_top, 1e-3)) ** 2 + ((yy - top_y) / max(r_top * rim_ratio, 1e-3)) ** 2
    top_mask = ell <= 1
    if open_top and r_top > 3:
        wall = max(2.0, r_top * 0.08)
        inner_ell = ((xx - cx) / max(r_top - wall, 1e-3)) ** 2 + ((yy - top_y) / max((r_top - wall) * rim_ratio, 1e-3)) ** 2
        lip = top_mask & (inner_ell > 1)
        hole = inner_ell <= 1
        lip_col = hex2lin(glaze_color or color) * 1.05 + 0.05
        ry = max((r_top - wall) * rim_ratio, 1e-3)
        gy = np.clip((yy - (top_y - ry)) / (2 * ry), 0, 1)          # 0 = far wall, 1 = near wall
        gx = np.clip((xx - (cx - r_top)) / (2 * r_top), 0, 1)       # 0 = left, 1 = right
        if inner is None:
            openness = float(np.clip(r_top / max(height, 1) * 1.6, 0, 1))
            glaze_lin = hex2lin(glaze_color or color)
            lit = 0.35 + 0.65 * (1 - gy) * (0.45 + 0.55 * gx)      # far right wall catches the light
            shade_in = glaze_lin * (lit * (0.35 + 0.65 * openness))[..., None]
            deep = hex2lin('#2a211b') * (0.6 + 0.5 * gy)[..., None]
            inner_col = shade_in * openness + deep * (1 - openness) * 0.9 + shade_in * (1 - openness) * 0.25
            # Soft shadow cast by the rim onto the inner far wall.
            inner_col *= (1 - 0.35 * np.exp(-(gy / 0.18) ** 2) * (1 - gx))[..., None]
        else:
            inner_col = hex2lin(inner) * (0.55 + 0.6 * gy)[..., None]
        col = np.where(lip[..., None], lip_col, col)
        col = np.where(hole[..., None], inner_col, col)
        alpha_map = np.maximum(alpha_map, top_mask.astype(np.float32))
    elif r_top > 1.5:
        cap = hex2lin(glaze_color or color) * (0.85 + 0.25 * (1 - smoothstep(-1, 1, (yy - top_y) / max(r_top * rim_ratio, 1))))[..., None]
        col = np.where(top_mask[..., None], cap * 1.08, col)
        alpha_map = np.maximum(alpha_map, top_mask.astype(np.float32))
    full = np.zeros((scene.h, scene.w), dtype=np.float32)
    full[y0:y1, x0:x1] = alpha_map
    if shadow:
        scene.add_shadow(full, base_y)
    region = scene.img[y0:y1, x0:x1]
    a = (alpha_map * alpha)[..., None]
    scene.img[y0:y1, x0:x1] = region * (1 - a) + col * a
    return full


def handle(scene, cx, cy, rx, ry, thick, color, side=1, gloss=0.3, angle_span=(-80, 80)):
    """Tube-like handle (part of an ellipse ring) on the side of a vessel."""
    yy, xx = np.mgrid[0:scene.h, 0:scene.w].astype(np.float32)
    dx, dy = (xx - cx) * side, yy - cy
    ang = np.degrees(np.arctan2(dy, dx))
    ell = np.sqrt((dx / rx) ** 2 + (dy / ry) ** 2)
    rr = (ell - 1) * min(rx, ry)
    dist = np.abs(rr) / (thick / 2)
    m = (dist <= 1) & (ang >= angle_span[0]) & (ang <= angle_span[1]) & (dx > 0)
    nz = np.sqrt(np.clip(1 - dist ** 2, 0, 1))
    nrm = np.where(rr > 0, 1, -1) * np.sqrt(np.clip(1 - nz ** 2, 0, 1))
    nx = nrm * np.cos(np.radians(ang)) * side
    ny = nrm * np.sin(np.radians(ang))
    col = shade(nx, ny, nz, np.broadcast_to(hex2lin(color), nx.shape + (3,)), gloss=gloss, rim_color='#FFF4E2')
    alpha = blur(m.astype(np.float32), 0.6) * m
    scene.add_shadow(m.astype(np.float32), cy + ry * 1.55, strength=0.25)
    scene.composite(col, alpha)


def box(scene, x0, x1, y_top, y_bot, depth, color, shadow=True):
    """Plinth or shelf: front face plus a lighter top face seen from above."""
    c = hex2lin(color)
    yy, xx = np.mgrid[0:scene.h, 0:scene.w].astype(np.float32)
    front = (xx >= x0) & (xx <= x1) & (yy >= y_top) & (yy <= y_bot)
    top = (xx >= x0) & (xx <= x1) & (yy >= y_top - depth) & (yy < y_top)
    if shadow:
        scene.add_shadow((front | top).astype(np.float32), y_bot, strength=0.35, soft=0.02)
    grad = 1 - 0.18 * smoothstep(y_top, y_bot, yy)
    front_col = c[None, None, :] * (0.9 * grad)[..., None]
    side_light = 1 - 0.12 * smoothstep(x0, x1, xx)
    front_col = front_col * side_light[..., None]
    top_col = c * 1.08 + 0.02
    scene.composite(front_col, front.astype(np.float32))
    scene.composite(np.broadcast_to(top_col, scene.img.shape), top.astype(np.float32) * 0.98)
    return y_top - depth * 0.5


def flame(scene, cx, base_y, h):
    yy, xx = np.mgrid[0:scene.h, 0:scene.w].astype(np.float32)
    t = (base_y - yy) / h
    w = h * 0.22 * np.sqrt(np.clip(t, 0, 1)) * np.clip(1 - t, 0, 1) * 2.2
    m = (t >= 0) & (t <= 1) & (np.abs(xx - cx) <= w)
    core = np.exp(-((xx - cx) / (h * 0.08 + 1)) ** 2 - ((t - 0.3) / 0.3) ** 2)
    col = hex2lin('#FFB347') * 1.6 + hex2lin('#FFF6D8')[None, None, :] * core[..., None] * 1.2
    scene.add_glow(cx, base_y - h * 0.45, h * 3.2, '#FFB45E', 0.35)
    scene.composite(col, blur(m.astype(np.float32), 1.0))


def leaves(scene, cx, base_y, size, color='#4E7A4A', n=7, spread=70, seed=3):
    rng = np.random.default_rng(seed)
    yy, xx = np.mgrid[0:scene.h, 0:scene.w].astype(np.float32)
    for i in range(n):
        ang = np.radians(-90 + (i - (n - 1) / 2) * (spread * 2 / max(n - 1, 1)) + rng.normal(0, 6))
        length = size * (0.75 + rng.random() * 0.45)
        ex, ey = cx + math.cos(ang) * length * 0.5, base_y + math.sin(ang) * length * 0.5
        ca, sa = math.cos(-ang), math.sin(-ang)
        lx = (xx - ex) * ca - (yy - ey) * sa
        ly = (xx - ex) * sa + (yy - ey) * ca
        a, b = length * 0.5, length * 0.12
        d = (lx / a) ** 2 + (ly / b) ** 2
        m = d <= 1
        shade_v = 0.75 + 0.35 * (ly / b) * (-1 if i % 2 else 1) * 0.5 + 0.25 * (1 - np.abs(lx / a))
        vein = np.exp(-(ly / (b * 0.08)) ** 2) * (np.abs(lx) < a * 0.9)
        tint = hex2lin(color) * (0.75 + 0.5 * rng.random())
        col = tint[None, None, :] * np.clip(shade_v, 0.3, 1.4)[..., None] * (1 - 0.25 * vein)[..., None]
        scene.composite(col, blur(m.astype(np.float32), 0.8))


def sticks(scene, x, y, n=5, length=380, color='#3b2f25', seed=2):
    rng = np.random.default_rng(seed)
    yy, xx = np.mgrid[0:scene.h, 0:scene.w].astype(np.float32)
    for i in range(n):
        ang = np.radians(-90 + rng.normal(0, 13))
        x2, y2 = x + math.cos(ang) * length * (0.85 + rng.random() * 0.3), y + math.sin(ang) * length
        vx, vy = x2 - x, y2 - y
        L2 = vx * vx + vy * vy
        tt = np.clip(((xx - x) * vx + (yy - y) * vy) / L2, 0, 1)
        d = np.sqrt((xx - x - tt * vx) ** 2 + (yy - y - tt * vy) ** 2)
        m = np.clip(2.2 - d, 0, 1)
        scene.composite(np.broadcast_to(hex2lin(color), scene.img.shape), m)


# ----------------------------------------------------------------------------
# Object library (profiles in units of "size"; scaled at draw time)
# ----------------------------------------------------------------------------

SHAPES = {
    'amphora': [(0, .34), (.05, .40), (.35, .78), (.55, .74), (.72, .44), (.84, .27), (.93, .25), (1, .30)],
    'bottle': [(0, .30), (.05, .33), (.45, .36), (.62, .30), (.74, .14), (.9, .12), (1, .13)],
    'bud': [(0, .30), (.1, .55), (.3, .62), (.55, .48), (.75, .2), (.9, .16), (1, .19)],
    'globe_vase': [(0, .32), (.1, .62), (.35, .78), (.6, .70), (.82, .38), (.92, .26), (1, .27)],
    'mug': [(0, .40), (.03, .43), (.5, .45), (1, .47)],
    'cup': [(0, .26), (.08, .36), (.5, .46), (1, .52)],
    'bowl': [(0, .32), (.05, .45), (.25, .75), (.6, .93), (1, 1.0)],
    'plate': [(0, .55), (.3, .85), (1, 1.0)],
    'pot': [(0, .46), (.05, .48), (.85, .60), (.9, .64), (1, .64)],
    'candle_jar': [(0, .42), (.04, .44), (1, .44)],
    'pitcher': [(0, .40), (.06, .48), (.45, .55), (.75, .43), (.9, .36), (1, .40)],
    'lamp_base': [(0, .30), (.1, .30), (.18, .12), (1, .09)],
    'diffuser': [(0, .33), (.06, .36), (.5, .37), (.72, .30), (.82, .12), (1, .11)],
    'candleholder': [(0, .42), (.06, .42), (.12, .14), (.8, .10), (.88, .26), (1, .27)],
}


def draw(scene, kind, cx, base_y, size, color, height_ratio=1.0, **kw):
    prof = [(t, r * size) for t, r in SHAPES[kind]]
    return lathe(scene, cx, base_y, size * height_ratio, prof, color, **kw)


def mug(scene, cx, base_y, size, color, glaze=None, side=1):
    hgt = size * 0.95
    handle(scene, cx + side * size * 0.47, base_y - hgt * 0.52, size * 0.2, hgt * 0.26, size * 0.085, glaze or color, side=side)
    draw(scene, 'mug', cx, base_y, size, color, height_ratio=0.95, open_top=True, gloss=0.45,
         glaze_split=0.12 if glaze else None, glaze_color=glaze, speck=0.0025)


def lamp(scene, cx, base_y, size, shade_color='#FFF1D6', base_color='#2E2A26', lit=True):
    draw(scene, 'lamp_base', cx, base_y, size * 0.9, base_color, height_ratio=0.62, gloss=0.6, shininess=60)
    top = base_y - size * 0.9 * 0.62
    radius = size * 0.42
    cy = top - radius * 0.92
    prof = [(t, math.sqrt(max(0.0, 1 - (2 * t - 1) ** 2)) * radius) for t in np.linspace(0, 1, 40)]
    if lit:
        scene.add_glow(cx, cy, radius * 3.2, '#FFC77A', 0.55)
    lathe(scene, cx, cy + radius, radius * 2, prof, shade_color, gloss=0.2, rim_ratio=0.0, shadow=True,
          emissive=('#FFE2B0' if lit else None))


# ----------------------------------------------------------------------------
# Compositions
# ----------------------------------------------------------------------------

def product_shot(path, draw_fn, bg=('#EFE9E1', '#E7DFD4'), floor=('#E2D8CA', '#EAE2D7'), w=1200, h=1500, horizon=0.66, beams=True):
    s = Scene(w, h, bg, floor, int(h * horizon), beams=beams, beam_strength=0.16)
    draw_fn(s, w, h)
    s.save(path)


def build(out, only=None):
    os.makedirs(out, exist_ok=True)
    jobs = {}

    # --- Theme images ------------------------------------------------------
    def hero():
        s = Scene(1200, 1500, ('#E9DCCB', '#E2D1BC'), ('#D8C4AC', '#E1CFB8'), 1010, beam_strength=0.28)
        base = box(s, 120, 560, 1060, 1500, 70, '#E7D8C4')
        draw(s, 'amphora', 330, 1030, 360, '#C9714A', height_ratio=1.45, gloss=0.3, speck=0.004, open_top=True, glaze_split=0.35, glaze_color='#D8875E')
        box(s, 600, 1100, 1180, 1500, 70, '#EEE2D2')
        draw(s, 'bottle', 760, 1150, 270, '#F1EBE2', height_ratio=2.1, gloss=0.55, shininess=50, open_top=True, speck=0.002)
        draw(s, 'bud', 960, 1152, 210, '#3F4E43', height_ratio=1.15, gloss=0.5, open_top=True, speck=0.003)
        s.save(os.path.join(out, 'hero.jpg'))
    jobs['hero'] = hero

    def category(name, bg, floor, fn):
        def run():
            s = Scene(900, 1125, bg, floor, 760, beam_strength=0.22)
            fn(s)
            s.save(os.path.join(out, name))
        return run

    jobs['category-1'] = category('category-1.jpg', ('#D9B49C', '#CFA588'), ('#C79478', '#D3A68B'),
                                  lambda s: draw(s, 'globe_vase', 450, 860, 380, '#F2E9DD', height_ratio=1.25, gloss=0.5, open_top=True, speck=0.003))
    jobs['category-2'] = category('category-2.jpg', ('#2C3442', '#323B4A'), ('#262D39', '#2E3644'),
                                  lambda s: lamp(s, 450, 880, 420))
    jobs['category-3'] = category('category-3.jpg', ('#C9CFBF', '#BEC5B2'), ('#AEB5A0', '#B9C0AB'),
                                  lambda s: (mug(s, 330, 840, 220, '#E9E2D6', glaze='#7C8F78'), mug(s, 580, 880, 230, '#E9E2D6', glaze='#E6DED0', side=-1)))
    jobs['category-4'] = category('category-4.jpg', ('#E8DFD0', '#DED2BF'), ('#D3C4AD', '#DCCFBB'),
                                  lambda s: (draw(s, 'candleholder', 330, 850, 230, '#B08A5B', height_ratio=1.3, gloss=0.7, shininess=70),
                                             draw(s, 'diffuser', 590, 880, 250, '#5C4632', height_ratio=1.25, gloss=0.6, alpha=0.92), sticks(s, 590, 880 - 250 * 1.25 + 10, length=330)))

    def promo():
        s = Scene(1500, 1200, ('#E9DCCA', '#E0CFB9'), ('#D4BFA4', '#DCCAB2'), 690, beam_strength=0.26)
        y = 1010
        for size, col in ((380, '#F3EDE4'), (370, '#E8B596'), (360, '#F3EDE4')):
            h = size * 0.11
            draw(s, 'plate', 430, y, size, col, height_ratio=0.11, gloss=0.5, open_top=True, rim_ratio=0.3)
            y -= h * 0.92
        draw(s, 'bowl', 820, 1080, 270, '#F0E8DC', height_ratio=0.55, gloss=0.5, open_top=True, rim_ratio=0.3, glaze_split=0.22, glaze_color='#5E7C70')
        mug(s, 1130, 960, 220, '#ECE5D8', glaze='#C9714A')
        draw(s, 'cup', 1290, 1100, 160, '#F4EEE6', height_ratio=0.68, open_top=True, gloss=0.5, glaze_split=0.15, glaze_color='#E9DFD0')
        s.save(os.path.join(out, 'promo.jpg'))
    jobs['promo'] = promo

    def story():
        s = Scene(1200, 1500, ('#DCD3C6', '#D3C8B8'), ('#C5B8A5', '#CEC2B0'), 1300, beams=True, beam_strength=0.18)
        for shelf_y, items in ((560, [('cup', 240, '#D8CDBE', 0.7), ('bud', 470, '#BFAE97', 1.1), ('mug', 720, '#D4C8B6', 0.95), ('globe_vase', 960, '#CBBDA8', 1.2)]),
                               (1060, [('bowl', 260, '#C9B9A2', 0.55), ('amphora', 560, '#BCA88E', 1.4), ('pitcher', 880, '#D2C5B2', 1.25)])):
            box(s, 60, 1140, shelf_y, shelf_y + 40, 26, '#B79B79')
            for kind, x, col, hr in items:
                size = 190 if kind not in ('bowl',) else 260
                draw(s, kind, x, shelf_y - 8, size, col, height_ratio=hr, gloss=0.08, shininess=12, open_top=kind in ('cup', 'mug', 'bowl', 'bud', 'amphora', 'globe_vase', 'pitcher'), speck=0.006)
        s.save(os.path.join(out, 'story.jpg'))
    jobs['story'] = story

    def cover():
        s = Scene(2400, 1200, ('#1F2530', '#262D3A'), ('#1B2029', '#232934'), 840, beam_strength=0.0, beams=False, vignette=0.32)
        box(s, -20, 2420, 900, 1200, 90, '#3A3129', shadow=False)
        lamp(s, 1580, 900, 470)
        draw(s, 'candle_jar', 1980, 900, 170, '#D8C9B0', height_ratio=1.0, open_top=True, gloss=0.4, alpha=0.95, inner='#F1E2C6')
        flame(s, 1980, 900 - 170 - 10, 60)
        draw(s, 'bottle', 1250, 900, 200, '#5B6B78', height_ratio=2.0, gloss=0.6, shininess=60, open_top=True)
        draw(s, 'bud', 2180, 900, 150, '#B66A45', height_ratio=1.1, gloss=0.4, open_top=True)
        s.save(os.path.join(out, 'cover.jpg'))
    jobs['cover'] = cover

    social = [
        (('#D8C2A8', '#CDB394'), ('#BFA181', '#C9AD8E'), lambda s: draw(s, 'amphora', 450, 700, 300, '#7D4B33', height_ratio=1.4, gloss=0.4, speck=0.004, open_top=True)),
        (('#BFC7C2', '#B3BCB6'), ('#A3ADA6', '#AEB7B0'), lambda s: (draw(s, 'pot', 450, 760, 280, '#E8DFD2', height_ratio=0.85, open_top=True, gloss=0.2, speck=0.004, inner='#3A2E25'), leaves(s, 450, 760 - 280 * 0.85 + 18, 300, n=11, spread=80, color='#3F6B45'))),
        (('#2E2A33', '#36313C'), ('#28242C', '#302B35'), lambda s: (draw(s, 'candle_jar', 450, 740, 230, '#C9B79A', open_top=True, inner='#F0DFC0'), flame(s, 450, 740 - 230 - 12, 70))),
        (('#E6D7C9', '#DCCBBB'), ('#D0BBA6', '#D9C6B3'), lambda s: draw(s, 'bowl', 450, 690, 330, '#F1EAE0', height_ratio=0.6, open_top=True, rim_ratio=0.34, glaze_split=0.25, glaze_color='#3F5A73')),
    ]
    for i, (bg, fl, fn) in enumerate(social, 1):
        def run(bg=bg, fl=fl, fn=fn, i=i):
            s = Scene(900, 900, bg, fl, 560, beam_strength=0.2)
            fn(s)
            s.save(os.path.join(out, f'social-{i}.jpg'))
        jobs[f'social-{i}'] = run

    for name, fn in jobs.items():
        if only and name not in only:
            continue
        fn()
        print('rendered', name, flush=True)


if __name__ == '__main__':
    out = sys.argv[1] if len(sys.argv) > 1 else '.'
    only = None
    if '--only' in sys.argv:
        only = set(sys.argv[sys.argv.index('--only') + 1].split(','))
    build(out, only)
