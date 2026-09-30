<?php $s = load_settings(); ?>
<section class="cta-band" aria-label="Get a free estimate">
  <div class="wrap cta-inner">
    <div>
      <h2>Ready for sparkling windows &amp; worry-free gutters?</h2>
      <p>Free estimates, no contracts, and a 100% satisfaction guarantee. Let the Busy Bee crew do the dirty work.</p>
    </div>
    <div class="cta-actions">
      <a class="btn btn-dark" href="<?= e(tel_href($s['phone'])) ?>"><?= icon('phone') ?> <?= e($s['phone']) ?></a>
      <a class="btn btn-outline-dark" href="/free-estimate">Request a Free Estimate</a>
    </div>
  </div>
</section>
