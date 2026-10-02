"""Generates the Witryna icon set (24x24, 1.5px outline drawn as filled paths).

WordPress 7.1 icon registry only allows <path>/<polygon> with fill attributes,
so every "stroke" is expressed as a filled shape with an even-odd hole.
"""
import math, os

OUT = os.path.join(os.path.dirname(__file__), '..', '..', 'witryna', 'assets', 'icons')
W = 1.5  # stroke width

def f(n):
    s = f"{n:.2f}".rstrip('0').rstrip('.')
    return '0' if s in ('-0', '') else s

def circle(cx, cy, r):
    return f"M{f(cx)} {f(cy-r)}A{f(r)} {f(r)} 0 1 1 {f(cx)} {f(cy+r)}A{f(r)} {f(r)} 0 1 1 {f(cx)} {f(cy-r)}Z"

def ring(cx, cy, r):  # r = centre-line radius
    return circle(cx, cy, r + W/2) + circle(cx, cy, r - W/2)

def rrect(x0, y0, x1, y1, r):
    if r <= 0:
        return f"M{f(x0)} {f(y0)}H{f(x1)}V{f(y1)}H{f(x0)}Z"
    return (f"M{f(x0+r)} {f(y0)}H{f(x1-r)}A{f(r)} {f(r)} 0 0 1 {f(x1)} {f(y0+r)}V{f(y1-r)}"
            f"A{f(r)} {f(r)} 0 0 1 {f(x1-r)} {f(y1)}H{f(x0+r)}A{f(r)} {f(r)} 0 0 1 {f(x0)} {f(y1-r)}"
            f"V{f(y0+r)}A{f(r)} {f(r)} 0 0 1 {f(x0+r)} {f(y0)}Z")

def frame(x0, y0, x1, y1, r):  # centre-line rectangle -> outline
    h = W/2
    return rrect(x0-h, y0-h, x1+h, y1+h, r+h if r else 0) + rrect(x0+h, y0+h, x1-h, y1-h, max(r-h, 0) if r else 0)

def bar(x0, y0, x1, y1):  # thick line segment with butt caps
    dx, dy = x1-x0, y1-y0
    L = math.hypot(dx, dy); nx, ny = -dy/L*W/2, dx/L*W/2
    pts = [(x0+nx, y0+ny), (x1+nx, y1+ny), (x1-nx, y1-ny), (x0-nx, y0-ny)]
    return 'M' + 'L'.join(f"{f(x)} {f(y)}" for x, y in pts) + 'Z'

def arc_band(cx, cy, r, a0, a1):
    """Band along a circle from angle a0 to a1 (degrees, clockwise in screen space)."""
    ro, ri = r + W/2, r - W/2
    p = lambda rad, a: (cx + rad*math.cos(math.radians(a)), cy + rad*math.sin(math.radians(a)))
    large = 1 if (a1 - a0) % 360 > 180 else 0
    (x0, y0), (x1, y1) = p(ro, a0), p(ro, a1)
    (x2, y2), (x3, y3) = p(ri, a1), p(ri, a0)
    return (f"M{f(x0)} {f(y0)}A{f(ro)} {f(ro)} 0 {large} 1 {f(x1)} {f(y1)}L{f(x2)} {f(y2)}"
            f"A{f(ri)} {f(ri)} 0 {large} 0 {f(x3)} {f(y3)}Z")

def offset_polygon(pts, d):
    """Inward offset of a convex polygon given clockwise (screen) vertices."""
    n = len(pts); lines = []
    for i in range(n):
        (x0, y0), (x1, y1) = pts[i], pts[(i+1) % n]
        dx, dy = x1-x0, y1-y0; L = math.hypot(dx, dy)
        nx, ny = -dy/L, dx/L  # right-hand normal points inward for clockwise screen polygons
        lines.append(((x0+nx*d, y0+ny*d), (dx, dy)))
    out = []
    for i in range(n):
        (p1, d1), (p2, d2) = lines[i-1], lines[i]
        den = d1[0]*d2[1] - d1[1]*d2[0]
        t = ((p2[0]-p1[0])*d2[1] - (p2[1]-p1[1])*d2[0]) / den
        out.append((p1[0]+d1[0]*t, p1[1]+d1[1]*t))
    return out

def poly(pts):
    return 'M' + 'L'.join(f"{f(x)} {f(y)}" for x, y in pts) + 'Z'

def outline_polygon(pts):  # centre-line convex polygon -> outline
    return poly(offset_polygon(pts, -W/2)) + poly(offset_polygon(pts, W/2))

icons = {}

# Delivery truck.
cab = [(14, 8.75), (18.25, 8.75), (21.25, 11.75), (21.25, 15.5), (14, 15.5)]
icons['truck'] = ('Delivery truck', [
    frame(2.75, 5.75, 14, 15.5, 1),
    outline_polygon(cab),
    ring(6.75, 17.5, 1.75),
    ring(17.25, 17.5, 1.75),
])

# Returns: circular arrow.
icons['return'] = ('Returns', [
    arc_band(12, 12, 7.25, -150, 160),
    poly([(2.4, 4.9), (8.9, 6.9), (3.6, 11.3)]),
])

# Chat bubble with dots.
icons['chat'] = ('Chat', [
    "M6 3.75H18A3.25 3.25 0 0 1 21.25 7V13.5A3.25 3.25 0 0 1 18 16.75H11.5L7 21V16.75H6A3.25 3.25 0 0 1 2.75 13.5V7A3.25 3.25 0 0 1 6 3.75Z"
    "M6 5.25A1.75 1.75 0 0 0 4.25 7V13.5A1.75 1.75 0 0 0 6 15.25H8.5V17.5L10.9 15.25H18A1.75 1.75 0 0 0 19.75 13.5V7A1.75 1.75 0 0 0 18 5.25Z",
    circle(8.25, 10.25, 1) + circle(12, 10.25, 1) + circle(15.75, 10.25, 1),
])

# Gift box.
icons['gift'] = ('Gift', [
    frame(3.75, 8, 20.25, 11.5, 1),
    frame(5, 11.5, 19, 20.25, 1),
    "M11.25 8H12.75V20.25H11.25Z",
    ring(9.6, 5.6, 1.6),
    ring(14.4, 5.6, 1.6),
])

# Leaf.
icons['leaf'] = ('Leaf', [
    "M4.25 19.75C4.25 9.75 10.5 3.5 20.5 3.5C20.5 13.5 14.25 19.75 4.25 19.75Z"
    "M5.79 18.21C6.39 10.43 11.43 5.65 18.96 5.04C18.35 12.57 13.57 17.61 5.79 18.21Z",
    bar(2.8, 21.2, 14.5, 9.5),
])

# Package.
hexa = [(12, 2.75), (20.25, 7.25), (20.25, 16.75), (12, 21.25), (3.75, 16.75), (3.75, 7.25)]
icons['package'] = ('Package', [
    outline_polygon(hexa),
    bar(4.2, 7.6, 12, 11.85),
    bar(12, 11.85, 19.8, 7.6),
    "M11.25 11.8H12.75V21H11.25Z",
])

# Padlock.
icons['lock'] = ('Padlock', [
    frame(5, 10.5, 19, 20.25, 2),
    arc_band(12, 8, 4, 180, 360) + f"M{f(7.25)} {f(8)}H{f(8.75)}V{f(10)}H{f(7.25)}Z" + f"M{f(15.25)} {f(8)}H{f(16.75)}V{f(10)}H{f(15.25)}Z",
    circle(12, 15.25, 1.4),
])

# Sparkles.
icons['sparkle'] = ('Sparkle', [
    "M10 3.5C10.55 8.6 12.9 10.95 18 11.5C12.9 12.05 10.55 14.4 10 19.5C9.45 14.4 7.1 12.05 2 11.5C7.1 10.95 9.45 8.6 10 3.5Z",
    "M18.5 2.5C18.75 4.4 19.6 5.25 21.5 5.5C19.6 5.75 18.75 6.6 18.5 8.5C18.25 6.6 17.4 5.75 15.5 5.5C17.4 5.25 18.25 4.4 18.5 2.5Z",
])

# Heart (wishlist).
icons['heart'] = ('Heart', [
    "M12 20.6L3.9 12.9C1.7 10.7 1.8 7.1 4.1 5C6.3 3 9.7 3.4 11.6 5.6L12 6.1L12.4 5.6C14.3 3.4 17.7 3 19.9 5C22.2 7.1 22.3 10.7 20.1 12.9Z"
    "M12 18.5L18.99 11.85C20.6 10.24 20.55 7.62 18.88 6.1C17.29 4.65 14.81 4.93 13.43 6.53L12 8.25L10.57 6.53C9.19 4.93 6.71 4.65 5.12 6.1C3.45 7.62 3.4 10.24 5.01 11.85Z",
])

# Phone handset.
icons['phone'] = ('Phone', [
    "M7.06 2.75L9.8 2.98L11.32 7.55L9.17 9.36C10.14 11.53 12.47 13.86 14.64 14.83L16.45 12.68L21.02 14.2L21.25 16.94C21.32 18.17 20.37 19.25 19.14 19.25C10.4 19.25 4.75 13.6 4.75 4.86C4.75 3.63 5.83 2.68 7.06 2.75Z"
    "M7 4.25C6.6 4.23 6.25 4.53 6.25 4.92C6.38 12.62 11.38 17.62 19.08 17.75C19.47 17.75 19.77 17.4 19.75 17L19.6 15.28L16.97 14.41L15.07 16.67L14.12 16.27C11.6 15.15 8.85 12.4 7.73 9.88L7.33 8.93L9.59 7.03L8.72 4.4Z",
])

os.makedirs(OUT, exist_ok=True)
for name, (label, paths) in icons.items():
    body = ''.join(f'<path fill-rule="evenodd" d="{d}"/>' for d in paths)
    svg = f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">{body}</svg>\n'
    open(os.path.join(OUT, f'{name}.svg'), 'w').write(svg)
    print(name, len(svg))
