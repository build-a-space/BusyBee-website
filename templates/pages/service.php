<?php $svc = $page['service']; $slug = $page['slug']; $s = load_settings(); $img = $page['image'] ?? ''; ?>
<section class="page-hero">
  <div class="wrap page-hero-grid">
    <div>
      <p class="eyebrow"><?= icon($svc['icon']) ?> <?= e($svc['name']) ?></p>
      <h1><?= e($page['h1']) ?></h1>
      <p class="lead"><?= e($svc['lead']) ?></p>
      <div class="hero-actions">
        <a class="btn btn-yellow" href="#quote">Get a Free Quote</a>
        <a class="btn btn-ghost" href="<?= e(tel_href($s['phone'])) ?>"><?= icon('phone') ?> <?= e($s['phone']) ?></a>
      </div>
    </div>
    <?php if ($img): ?><img class="page-hero-img" src="<?= e($img) ?>" alt="<?= e($svc['name']) ?> in Massachusetts" width="560" height="400"><?php endif; ?>
  </div>
</section>

<section class="section">
  <div class="wrap with-aside">
    <article class="prose">
      <?= enrich($svc['body'], $slug) ?>

      <h2>How it works — step by step</h2>
      <ol class="steps steps-compact">
        <?php foreach ($svc['steps'] as $i => [$h, $t]): ?>
          <li><span class="n"><?= $i + 1 ?></span><h3><?= e($h) ?></h3><p><?= e($t) ?></p></li>
        <?php endforeach; ?>
      </ol>

      <h2><?= e($svc['name']) ?> near you</h2>
      <p>We provide <?= e(strtolower($svc['name'])) ?> throughout Worcester, Middlesex and Norfolk County, including:</p>
      <?php $townSlugs = array_keys(towns()); require TPL_DIR . '/partials/area-links.php'; ?>

      <h2><?= e($svc['name']) ?> FAQs</h2>
      <?php $faqs = $svc['faqs']; require TPL_DIR . '/partials/faq-list.php'; ?>
    </article>
    <aside class="aside">
      <?php $formTitle = 'Free ' . $svc['short'] . ' Estimate'; $preselect = $slug; require TPL_DIR . '/partials/quote-form.php'; ?>
      <div class="aside-box">
        <h2 class="aside-h">Other services</h2>
        <ul class="aside-links">
          <?php foreach (services() as $sl => $o): if ($sl === $slug || !page_enabled($sl)) continue; ?>
            <li><a href="/<?= e($sl) ?>"><?= icon($o['icon']) ?><?= e($o['name']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </aside>
  </div>
</section>

<section class="section alt"><div class="wrap">
  <header class="sec-head"><h2>Pairs well with</h2></header>
  <?php $only = $svc['related']; $exclude = $slug; require TPL_DIR . '/partials/service-cards.php'; $only = null; ?>
</div></section>
