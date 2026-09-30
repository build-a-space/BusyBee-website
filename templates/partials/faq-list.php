<?php /** Accessible accordion. Requires $faqs = [[q, a], ...] */ ?>
<div class="faq">
<?php foreach ($faqs as $i => [$q, $a]): ?>
  <details<?= $i === 0 ? ' open' : '' ?>>
    <summary><?= e($q) ?></summary>
    <div class="faq-a"><p><?= enrich(e($a)) ?></p></div>
  </details>
<?php endforeach; ?>
</div>
