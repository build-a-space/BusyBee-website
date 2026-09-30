<?php
/** @var array $page */
declare(strict_types=1);

$s = load_settings();
$canonical = $page['canonical'] !== null ? abs_url($page['canonical'] === '/' ? '/' : $page['canonical']) : null;
$ogImage = abs_url(($page['image'] ?? '') ?: ($s['og_image'] ?: $s['logo']));
header('Content-Type: text/html; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
?><!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($page['title']) ?></title>
<meta name="description" content="<?= e($page['description']) ?>">
<?php if (!empty($page['noindex']) || !$s['site_online']): ?>
<meta name="robots" content="noindex, follow">
<?php else: ?>
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
<?php endif; ?>
<?php if ($canonical): ?><link rel="canonical" href="<?= e($canonical) ?>"><?php endif; ?>

<meta property="og:locale" content="en_US">
<meta property="og:type" content="<?= e($page['og_type'] ?? 'website') ?>">
<meta property="og:site_name" content="<?= e($s['business_name']) ?>">
<meta property="og:title" content="<?= e($page['title']) ?>">
<meta property="og:description" content="<?= e($page['description']) ?>">
<?php if ($canonical): ?><meta property="og:url" content="<?= e($canonical) ?>"><?php endif; ?>
<meta property="og:image" content="<?= e($ogImage) ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($page['title']) ?>">
<meta name="twitter:description" content="<?= e($page['description']) ?>">
<meta name="twitter:image" content="<?= e($ogImage) ?>">

<meta name="geo.region" content="US-<?= e($s['state']) ?>">
<meta name="geo.placename" content="<?= e($s['city']) ?>">
<?php if ($s['latitude'] !== ''): ?>
<meta name="geo.position" content="<?= e($s['latitude']) ?>;<?= e($s['longitude']) ?>">
<meta name="ICBM" content="<?= e($s['latitude']) ?>, <?= e($s['longitude']) ?>">
<?php endif; ?>
<?php if ($s['google_verification'] !== ''): ?><meta name="google-site-verification" content="<?= e($s['google_verification']) ?>"><?php endif; ?>
<?php if ($s['bing_verification'] !== ''): ?><meta name="msvalidate.01" content="<?= e($s['bing_verification']) ?>"><?php endif; ?>
<meta name="theme-color" content="<?= e($s['color_dark']) ?>">

<link rel="icon" href="<?= e($s['favicon']) ?>">
<link rel="apple-touch-icon" href="<?= e($s['favicon']) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="preload" as="image" href="<?= e($s['logo']) ?>">
<link rel="stylesheet" href="<?= e(asset('/assets/css/style.css')) ?>">
<style>:root{--yellow:<?= e($s['color_primary']) ?>;--ink:<?= e($s['color_dark']) ?>;--amber:<?= e($s['color_accent']) ?>}</style>
<?= render_schema($page['schema']) ?>

<?php if ($s['ga_id'] !== ''): ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($s['ga_id']) ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments)}gtag('js',new Date());gtag('config',<?= json_encode($s['ga_id']) ?>);</script>
<?php endif; ?>
<?= $s['head_code'] /* raw, admin-controlled */ ?>
</head>
<body class="tpl-<?= e($page['template']) ?>">
<a class="skip" href="#main">Skip to content</a>

<?php if (is_admin()): ?>
<div class="admin-bar">
  <span>Logged in as admin<?= !$s['site_online'] ? ' — <strong>site is OFFLINE</strong> (visitors see maintenance page)' : '' ?></span>
  <a href="<?= e(ADMIN_PATH) ?>">Open dashboard</a>
</div>
<?php endif; ?>

<?php if (!empty($s['show_announcement']) && $s['announcement'] !== ''): ?>
<div class="topbar">
  <div class="wrap topbar-inner">
    <span><?= e($s['announcement']) ?></span>
    <span class="topbar-contact">
      <a href="<?= e(tel_href($s['phone'])) ?>"><?= icon('phone') ?><?= e($s['phone']) ?></a>
      <a href="mailto:<?= e($s['email']) ?>" class="hide-sm"><?= icon('mail') ?><?= e($s['email']) ?></a>
    </span>
  </div>
</div>
<?php endif; ?>

<header class="site-header" id="top">
  <div class="wrap header-inner">
    <a class="brand" href="/" aria-label="<?= e($s['business_name']) ?> — Home">
      <img src="<?= e($s['logo']) ?>" alt="<?= e($s['business_name']) ?> logo" width="176" height="96">
    </a>
    <button class="nav-toggle" aria-expanded="false" aria-controls="site-nav" aria-label="Open menu"><?= icon('menu') ?></button>
    <nav id="site-nav" class="site-nav" aria-label="Main">
      <ul>
      <?php foreach (nav_items() as [$href, $label, $children]):
          $active = $page['canonical'] === $href || ($href !== '/' && str_starts_with((string) $page['canonical'], $href)); ?>
        <li class="<?= $children ? 'has-sub' : '' ?><?= $active ? ' active' : '' ?>">
          <a href="<?= e($href) ?>"<?= $page['canonical'] === $href ? ' aria-current="page"' : '' ?>><?= e($label) ?></a>
          <?php if ($children): ?>
            <button class="sub-toggle" aria-label="Show <?= e($label) ?> menu" aria-expanded="false"></button>
            <ul class="sub">
              <?php foreach ($children as $ch => $cl): ?>
                <li><a href="<?= e($ch) ?>"><?= e($cl) ?></a></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
      </ul>
      <a class="btn btn-yellow nav-cta" href="/free-estimate">Free Estimate</a>
    </nav>
  </div>
</header>

<main id="main">
<?php if (count($page['breadcrumbs'] ?? []) > 1): ?>
  <nav class="crumbs wrap" aria-label="Breadcrumb">
    <ol>
    <?php foreach ($page['breadcrumbs'] as $i => [$n, $u]): ?>
      <?php if ($i === count($page['breadcrumbs']) - 1): ?>
        <li aria-current="page"><?= e($n) ?></li>
      <?php else: ?>
        <li><a href="<?= e($u) ?>"><?= e($n) ?></a></li>
      <?php endif; ?>
    <?php endforeach; ?>
    </ol>
  </nav>
<?php endif; ?>

<?php require TPL_DIR . '/pages/' . $page['template'] . '.php'; ?>
</main>

<?php require TPL_DIR . '/partials/cta-band.php'; ?>

<footer class="site-footer">
  <div class="honey-edge" aria-hidden="true"></div>
  <div class="wrap footer-grid">
    <div class="f-brand">
      <img src="<?= e($s['logo']) ?>" alt="<?= e($s['business_name']) ?>" width="200" height="109" loading="lazy">
      <p><?= e($s['tagline']) ?></p>
      <?php if ($s['show_rating']): ?>
        <p class="f-rating"><?= stars((float) $s['rating_value']) ?> <strong><?= e($s['rating_value']) ?></strong> from <?= e(number_format((int) $s['rating_count'])) ?>+ reviews</p>
      <?php endif; ?>
    </div>
    <div>
      <h2 class="f-h">Services</h2>
      <ul class="f-links">
        <?php foreach (services() as $sl => $svc): if (!page_enabled($sl)) continue; ?>
          <li><a href="/<?= e($sl) ?>"><?= e($svc['name']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div>
      <h2 class="f-h">Service Areas</h2>
      <ul class="f-links f-cols">
        <?php foreach (array_slice(towns(), 0, 14, true) as $sl => $t): if (!page_enabled($sl)) continue; ?>
          <li><a href="/<?= e($sl) ?>"><?= e($t['name']) ?></a></li>
        <?php endforeach; ?>
        <li><a href="/service-areas"><strong>View all →</strong></a></li>
      </ul>
    </div>
    <div class="f-contact">
      <h2 class="f-h">Contact</h2>
      <address>
        <p><?= icon('phone') ?><a href="<?= e(tel_href($s['phone'])) ?>"><?= e($s['phone']) ?></a></p>
        <?php if ($s['phone_secondary'] !== ''): ?><p><?= icon('phone') ?><a href="<?= e(tel_href($s['phone_secondary'])) ?>"><?= e($s['phone_secondary']) ?></a></p><?php endif; ?>
        <p><?= icon('mail') ?><a href="mailto:<?= e($s['email']) ?>"><?= e($s['email']) ?></a></p>
        <p><?= icon('pin') ?><a href="https://www.google.com/maps?q=<?= e(rawurlencode(full_address())) ?>" rel="noopener" target="_blank"><?= e($s['street']) ?><br><?= e($s['city']) ?>, <?= e($s['state']) ?> <?= e($s['zip']) ?></a></p>
        <p><?= icon('clock') ?>Mon–Fri <?= e($s['hours']['Monday'] ?? '') ?></p>
      </address>
      <ul class="social">
        <?php foreach ($s['social'] as $net => $url): if ($url === '') continue; ?>
          <li><a href="<?= e($url) ?>" rel="noopener me" target="_blank"><?= e(ucfirst($net)) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <div class="wrap f-bottom">
    <p>&copy; <?= date('Y') ?> <?= e($s['legal_name']) ?>. All rights reserved.</p>
    <p><a href="/about">About</a> · <a href="/faq">FAQ</a> · <a href="/blog">Blog</a> · <a href="/privacy-policy">Privacy</a> · <a href="/sitemap.xml">Sitemap</a></p>
  </div>
</footer>

<a class="call-fab" href="<?= e(tel_href($s['phone'])) ?>" aria-label="Call <?= e($s['phone']) ?>"><?= icon('phone') ?><span>Call Now</span></a>
<script src="<?= e(asset('/assets/js/main.js')) ?>" defer></script>
</body>
</html>
