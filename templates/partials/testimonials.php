<?php
$s = load_settings();
$list = array_values(array_filter((array) $s['testimonials'], fn($t) => !empty($t['name']) && !empty($t['text'])));
$limit = $limit ?? 6;
if (!$list) return;
?>
<div class="testimonials">
<?php foreach (array_slice($list, 0, $limit) as $t): ?>
  <figure class="review">
    <?= stars((float) ($t['rating'] ?? 5)) ?>
    <blockquote><p><?= e($t['text']) ?></p></blockquote>
    <figcaption><strong><?= e($t['name']) ?></strong><?= !empty($t['location']) ? ' · ' . e($t['location']) : '' ?></figcaption>
  </figure>
<?php endforeach; ?>
</div>
