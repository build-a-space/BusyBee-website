<?php $s = load_settings(); ?>
<section class="page-hero"><div class="wrap">
  <h1><?= e($page['h1']) ?></h1>
  <p class="lead">A locally owned, family-minded window and gutter cleaning company based in Northborough, Massachusetts.</p>
</div></section>
<section class="section"><div class="wrap split">
  <div class="prose">
    <?= enrich(<<<HTML
<h2>Our story</h2>
<p>Busy Bee Window &amp; Gutter Cleaning started in {$s['founded']} with a simple idea: homeowners deserve an exterior cleaning company that shows up when it says it will, treats their home with respect, and does the job right the first time. What began as one truck and a set of ladders has grown into a trusted crew serving hundreds of homes and businesses across Worcester County and beyond.</p>
<p>We're still based in Northborough, and we still run the business the same way — with honest pricing, clear communication and an obsession with detail. That's why so many of our customers book us year after year for their spring window cleaning and fall gutter cleaning.</p>
<h2>What we stand for</h2>
HTML, 'about') ?>
    <ul class="checks">
      <li><strong>Reliability.</strong> On-time arrival windows and reminders before every visit.</li>
      <li><strong>Respect.</strong> Drop cloths, shoe covers and a clean-up you'll notice.</li>
      <li><strong>Safety.</strong> Trained technicians, proper equipment and full insurance.</li>
      <li><strong>Satisfaction.</strong> If something isn't right, we come back and fix it — free.</li>
    </ul>
    <a class="btn btn-yellow" href="/free-estimate">Get a Free Estimate</a>
  </div>
  <div class="about-card">
    <img src="<?= e($s['logo']) ?>" alt="<?= e($s['business_name']) ?> logo" width="400" height="218" loading="lazy">
    <dl class="facts">
      <div><dt>Founded</dt><dd><?= e($s['founded']) ?></dd></div>
      <div><dt>Home base</dt><dd><?= e($s['city']) ?>, <?= e($s['state']) ?></dd></div>
      <?php if ($s['owner']): ?><div><dt>Owner</dt><dd><?= e($s['owner']) ?></dd></div><?php endif; ?>
      <div><dt>Rating</dt><dd><?= e($s['rating_value']) ?> ★ (<?= e(number_format((int) $s['rating_count'])) ?>+ reviews)</dd></div>
      <div><dt>Service area</dt><dd>Worcester, Middlesex &amp; Norfolk County</dd></div>
    </dl>
  </div>
</div></section>
<section class="section alt"><div class="wrap">
  <header class="sec-head"><h2>What we do</h2></header>
  <?php require TPL_DIR . '/partials/service-cards.php'; ?>
</div></section>
