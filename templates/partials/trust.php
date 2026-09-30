<?php $s = load_settings(); ?>
<ul class="trust">
  <li><?= icon('shield') ?><span><strong>Fully insured</strong>Residential &amp; commercial</span></li>
  <li><?= icon('star') ?><span><strong><?= e($s['rating_value']) ?>-star rated</strong><?= e(number_format((int) $s['rating_count'])) ?>+ reviews</span></li>
  <li><?= icon('check') ?><span><strong>Free estimates</strong>No pressure, no contracts</span></li>
  <li><?= icon('calendar') ?><span><strong>Mon–Fri 7am–7pm</strong>Fast scheduling</span></li>
</ul>
