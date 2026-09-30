<?php $s = load_settings(); ?>
<section class="page-hero"><div class="wrap">
  <h1><?= e($page['h1']) ?></h1>
  <p class="lead">Estimates are always free — no pressure, no obligation. Call, email or send us a message and we'll get right back to you.</p>
</div></section>
<section class="section"><div class="wrap split contact-split">
  <div>
    <?php $formTitle = 'Send Us a Message'; require TPL_DIR . '/partials/quote-form.php'; ?>
  </div>
  <div class="contact-info">
    <ul class="info-list">
      <li><?= icon('phone') ?><div><strong>Call or text</strong><a href="<?= e(tel_href($s['phone'])) ?>"><?= e($s['phone']) ?></a><?php if ($s['phone_secondary']): ?><br><a href="<?= e(tel_href($s['phone_secondary'])) ?>"><?= e($s['phone_secondary']) ?></a><?php endif; ?></div></li>
      <li><?= icon('mail') ?><div><strong>Email</strong><a href="mailto:<?= e($s['email']) ?>"><?= e($s['email']) ?></a></div></li>
      <li><?= icon('pin') ?><div><strong>Address</strong><?= e($s['street']) ?><br><?= e($s['city']) ?>, <?= e($s['state']) ?> <?= e($s['zip']) ?></div></li>
      <li><?= icon('clock') ?><div><strong>Hours</strong>
        <table class="hours"><?php foreach ($s['hours'] as $d => $h): ?><tr><th scope="row"><?= e($d) ?></th><td><?= e($h) ?></td></tr><?php endforeach; ?></table>
      </div></li>
    </ul>
    <div class="map-embed small">
      <iframe title="Map to <?= e($s['business_name']) ?>" src="<?= e($s['map_embed_url']) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
</div></section>
