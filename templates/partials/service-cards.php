<?php /** Grid of service cards. Optional $exclude slug, $only array of slugs. */ ?>
<div class="cards">
<?php foreach (services() as $sl => $svc):
    if (!page_enabled($sl) || (!empty($exclude) && $sl === $exclude) || (!empty($only) && !in_array($sl, $only, true))) continue;
    $img = page_override($sl)['image'] ?? ''; ?>
  <article class="card">
    <?php if ($img): ?>
      <img class="card-img" src="<?= e($img) ?>" alt="<?= e($svc['name']) ?> by Busy Bee" loading="lazy">
    <?php else: ?>
      <div class="card-icon"><?= icon($svc['icon']) ?></div>
    <?php endif; ?>
    <h3><a href="/<?= e($sl) ?>"><?= e($svc['name']) ?></a></h3>
    <p><?= e($svc['lead']) ?></p>
    <a class="more" href="/<?= e($sl) ?>" aria-label="Learn more about <?= e($svc['name']) ?>">Learn more <?= icon('arrow') ?></a>
  </article>
<?php endforeach; ?>
</div>
