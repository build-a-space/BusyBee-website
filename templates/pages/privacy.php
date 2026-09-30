<?php $s = load_settings(); ?>
<section class="section"><div class="wrap narrow prose">
  <h1><?= e($page['h1']) ?></h1>
  <p><em>Last updated: <?= e(date('F j, Y', filemtime(__FILE__))) ?></em></p>
  <p><?= e($s['business_name']) ?> ("we", "us") respects your privacy. This policy explains what information we collect through this website and how we use it.</p>
  <h2>Information we collect</h2>
  <p>When you submit a form, we collect the details you provide — such as your name, phone number, email address, town and a description of your project. Our web server may also log basic technical information such as IP address and browser type for security purposes.</p>
  <h2>How we use it</h2>
  <p>We use your information only to respond to your request, schedule and provide services, and communicate with you about your appointment. We do not sell or rent your personal information.</p>
  <h2>Cookies &amp; analytics</h2>
  <p>We may use analytics tools such as Google Analytics to understand how visitors use our website. These tools may set cookies. You can disable cookies in your browser settings.</p>
  <h2>Contact</h2>
  <p>Questions? Email <a href="mailto:<?= e($s['email']) ?>"><?= e($s['email']) ?></a> or call <a href="<?= e(tel_href($s['phone'])) ?>"><?= e($s['phone']) ?></a>.</p>
</div></section>
