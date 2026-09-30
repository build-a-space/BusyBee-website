<?php $c = $page['county']; $slug = $page['slug']; ?>
<section class="page-hero"><div class="wrap">
  <p class="eyebrow"><?= icon('pin') ?> <?= e($c['name']) ?> County, Massachusetts</p>
  <h1><?= e($page['h1']) ?></h1>
  <p class="lead"><?= e($c['intro']) ?></p>
  <div class="hero-actions"><a class="btn btn-yellow" href="#quote">Get a Free Estimate</a></div>
</div></section>
<section class="section"><div class="wrap with-aside">
  <article class="prose">
    <?= enrich('<p>' . e($c['body']) . '</p>', $slug) ?>
    <h2>Towns we serve in <?= e($c['name']) ?> County</h2>
    <?php $townSlugs = array_filter(array_map('town_slug', $c['towns'])); require TPL_DIR . '/partials/area-links.php'; ?>
    <h2>Our services in <?= e($c['name']) ?> County</h2>
    <?php require TPL_DIR . '/partials/service-cards.php'; ?>
  </article>
  <aside class="aside"><?php $formTitle = 'Free Estimate in ' . $c['name'] . ' County'; require TPL_DIR . '/partials/quote-form.php'; ?></aside>
</div></section>
