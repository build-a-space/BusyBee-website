<?php
/**
 * Dynamic XML sitemap — includes every enabled page.
 */
declare(strict_types=1);

header('Content-Type: application/xml; charset=utf-8');
$priority = ['core' => '0.8', 'service' => '0.9', 'county' => '0.8', 'town' => '0.7', 'blog' => '0.6'];
$freq = ['core' => 'monthly', 'service' => 'monthly', 'county' => 'monthly', 'town' => 'monthly', 'blog' => 'yearly'];
$lastmod = date('Y-m-d', max(filemtime(__DIR__ . '/content.php'), is_file(settings_file()) ? filemtime(settings_file()) : 0));
$posts = blog_posts();

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach (all_pages() as $key => [$url, $label, $type]) {
    if (!page_enabled($key) || $key === 'privacy-policy') {
        continue;
    }
    $lm = $type === 'blog' ? $posts[substr($key, 5)]['date'] : $lastmod;
    $p = $key === 'home' ? '1.0' : $priority[$type];
    echo "  <url><loc>" . e(abs_url($url)) . "</loc><lastmod>$lm</lastmod><changefreq>{$freq[$type]}</changefreq><priority>$p</priority></url>\n";
}
echo "</urlset>\n";
