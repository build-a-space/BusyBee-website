<?php $t = $page['town']; $c = $page['county']; $slug = $page['slug']; $s = load_settings(); ?>
<section class="page-hero"><div class="wrap">
  <p class="eyebrow"><?= icon('pin') ?> <?= e($t['name']) ?>, <?= e($c['name']) ?> County, MA</p>
  <h1><?= e($page['h1']) ?></h1>
  <p class="lead">Streak-free windows, clean-flowing gutters and a sparkling exterior for <?= e($t['name']) ?> homes and businesses — from a local, fully insured crew.</p>
  <div class="hero-actions">
    <a class="btn btn-yellow" href="#quote">Get a Free Estimate</a>
    <a class="btn btn-ghost" href="<?= e(tel_href($s['phone'])) ?>"><?= icon('phone') ?> <?= e($s['phone']) ?></a>
  </div>
</div></section>
<section class="section"><div class="wrap with-aside">
  <article class="prose">
    <?= enrich('<p>' . e($t['blurb']) . '</p>', $slug) ?>
    <?= enrich(<<<HTML
<h2>Exterior cleaning services in {$t['name']}, MA</h2>
<p>Busy Bee offers the full range of exterior cleaning in {$t['name']}: residential window cleaning inside and out, commercial window cleaning for storefronts and offices, gutter cleaning with downspout flushing, gutter guard installation, gutter and downspout repair, power washing and soft washing, screen repair, and skylight cleaning. Every visit starts with a free estimate and ends with a walk-through to make sure you're 100% satisfied.</p>
HTML, $slug) ?>
    <div class="mini-services">
      <?php foreach (services() as $sl => $svc): if (!page_enabled($sl)) continue; ?>
        <a class="mini" href="/<?= e($sl) ?>"><?= icon($svc['icon']) ?><span><?= e($svc['name']) ?> <small>in <?= e($t['name']) ?></small></span></a>
      <?php endforeach; ?>
    </div>
    <h2>Why <?= e($t['name']) ?> homeowners choose Busy Bee</h2>
    <ul class="checks">
      <li>Local company based in Northborough — close by and quick to schedule</li>
      <li><?= e($s['rating_value']) ?>-star average rating from <?= e(number_format((int) $s['rating_count'])) ?>+ customer reviews</li>
      <li>Fully insured, uniformed, respectful technicians</li>
      <li>Up-front pricing, no contracts, satisfaction guaranteed</li>
    </ul>
    <h2>Frequently asked questions in <?= e($t['name']) ?></h2>
    <?php $faqs = $page['faqs']; require TPL_DIR . '/partials/faq-list.php'; ?>
    <h2>Nearby towns we also serve</h2>
    <?php $townSlugs = array_filter(array_map('town_slug', $t['nearby'])); require TPL_DIR . '/partials/area-links.php'; ?>
    <p>See all of our <a href="/<?= e($t['county_slug']) ?>"><?= e($c['name']) ?> County service areas</a>.</p>
  </article>
  <aside class="aside"><?php $formTitle = 'Free Estimate in ' . $t['name']; require TPL_DIR . '/partials/quote-form.php'; ?></aside>
</div></section>
