<?php $s = load_settings(); ?>
<section class="page-hero"><div class="wrap">
  <h1><?= e($page['h1']) ?></h1>
  <?php if ($s['show_rating']): ?>
  <div class="big-rating">
    <span class="num"><?= e($s['rating_value']) ?></span>
    <div><?= stars((float) $s['rating_value']) ?><p>Average rating from <?= e(number_format((int) $s['rating_count'])) ?>+ verified reviews</p></div>
  </div>
  <?php endif; ?>
  <p class="lead">Homeowners and businesses across Massachusetts trust Busy Bee for spotless windows, clean gutters and friendly, professional service.</p>
</div></section>
<section class="section"><div class="wrap">
  <?php $limit = 100; require TPL_DIR . '/partials/testimonials.php'; ?>
  <div class="review-links">
    <h2>Read &amp; leave reviews</h2>
    <p>Worked with us? We'd love to hear how we did.</p>
    <div class="hero-actions">
      <?php if ($s['google_business_url']): ?><a class="btn btn-yellow" href="<?= e($s['google_business_url']) ?>" target="_blank" rel="noopener">Review us on Google</a><?php endif; ?>
      <?php foreach (['yelp' => 'Yelp', 'nextdoor' => 'Nextdoor', 'facebook' => 'Facebook'] as $k => $label): if (empty($s['social'][$k])) continue; ?>
        <a class="btn btn-dark" href="<?= e($s['social'][$k]) ?>" target="_blank" rel="noopener">See us on <?= e($label) ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</div></section>
