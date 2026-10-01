#!/usr/bin/env bash
# Exports a static preview of the site into ./vercel-preview for Vercel hosting.
# Forms and the admin panel need PHP, so they are disabled in this preview.
set -euo pipefail
cd "$(dirname "$0")/.."
OUT=vercel-preview
PORT=8099
rm -rf "$OUT" && mkdir -p "$OUT"
php -S 127.0.0.1:$PORT router.php >/dev/null 2>&1 &
PID=$!
trap 'kill $PID 2>/dev/null || true' EXIT
sleep 1
URLS=$(curl -s http://127.0.0.1:$PORT/sitemap.xml | grep -o '<loc>[^<]*' | sed -E 's#<loc>https?://[^/]+##')
for u in $URLS /privacy-policy; do
  if [ "$u" = "/" ]; then f="$OUT/index.html"; else f="$OUT${u}.html"; fi
  mkdir -p "$(dirname "$f")"
  curl -s "http://127.0.0.1:$PORT$u" -o "$f"
done
curl -s http://127.0.0.1:$PORT/this-page-does-not-exist -o "$OUT/404.html"
curl -s http://127.0.0.1:$PORT/sitemap.xml -o "$OUT/sitemap.xml"
printf 'User-agent: *\nDisallow: /\n' > "$OUT/robots.txt"
cp -r assets "$OUT/"
cat >> "$OUT/assets/js/main.js" <<'JS'

/* Static preview: forms need the PHP host, so show a notice instead of submitting. */
document.querySelectorAll('.quote-form').forEach(function (f) {
  f.addEventListener('submit', function (e) {
    if (e.defaultPrevented) return;
    e.preventDefault();
    var b = f.querySelector('button[type=submit]');
    b.disabled = false; b.textContent = 'Send My Free Estimate Request';
    alert('Preview site: the estimate form goes live once the site is on the PHP host. For now, please call the number above.');
  });
});
JS
php -r '
require "includes/config.php";
$r = [];
foreach (load_settings()["redirects"] as $f => $t) $r[] = ["source" => $f, "destination" => $t, "permanent" => true];
$r[] = ["source" => ADMIN_PATH, "destination" => "/", "permanent" => false];
echo json_encode([
  "cleanUrls" => true, "trailingSlash" => false, "redirects" => $r,
  "headers" => [["source" => "/(.*)", "headers" => [["key" => "X-Robots-Tag", "value" => "noindex, nofollow"]]]],
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), "\n";' > "$OUT/vercel.json"
echo "Exported $(find "$OUT" -type f | wc -l) files to $OUT"
