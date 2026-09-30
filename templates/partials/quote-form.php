<?php
/** Quote / contact form. Optional $formTitle, $preselect (service slug). */
$s = load_settings();
$sent = isset($_GET['sent']);
$err = $_GET['error'] ?? '';
$preselect = $preselect ?? '';
?>
<form class="quote-form" method="post" action="/contact" id="quote" novalidate>
  <h2 class="qf-title"><?= e($formTitle ?? 'Get Your Free Estimate') ?></h2>
  <p class="qf-sub">We usually reply within one business day.</p>
  <?php if ($sent): ?>
    <div class="alert ok" role="status">Thanks! Your request is in — we'll be in touch shortly. Need us sooner? Call <a href="<?= e(tel_href($s['phone'])) ?>"><?= e($s['phone']) ?></a>.</div>
  <?php elseif ($err !== ''): ?>
    <div class="alert bad" role="alert">Please fill in your name, a valid phone or email, and try again.</div>
  <?php endif; ?>
  <?php $ts = time(); ?>
  <input type="hidden" name="ts" value="<?= $ts ?>">
  <input type="hidden" name="ft" value="<?= e(form_token($ts)) ?>">
  <input type="hidden" name="source" value="<?= e(current_path()) ?>">
  <div class="hp" aria-hidden="true"><label>Leave this empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
  <div class="qf-grid">
    <label>Name*<input type="text" name="name" required autocomplete="name" maxlength="100"></label>
    <label>Phone*<input type="tel" name="phone" required autocomplete="tel" maxlength="30"></label>
    <label>Email<input type="email" name="email" autocomplete="email" maxlength="150"></label>
    <label>Town / ZIP<input type="text" name="town" autocomplete="address-level2" maxlength="100"></label>
  </div>
  <fieldset class="qf-services">
    <legend>What can we help with?</legend>
    <?php foreach (services() as $sl => $svc): if (!page_enabled($sl)) continue; ?>
      <label class="chip"><input type="checkbox" name="services[]" value="<?= e($svc['name']) ?>"<?= $preselect === $sl ? ' checked' : '' ?>><span><?= e($svc['short']) ?></span></label>
    <?php endforeach; ?>
  </fieldset>
  <label>Tell us about your project<textarea name="message" rows="4" maxlength="3000" placeholder="Number of windows, stories, anything we should know…"></textarea></label>
  <button class="btn btn-yellow btn-block" type="submit">Send My Free Estimate Request</button>
  <p class="qf-note">By submitting, you agree we may contact you about your request. See our <a href="/privacy-policy">privacy policy</a>.</p>
</form>
