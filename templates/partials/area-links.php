<?php /** Town link list. Requires $townSlugs (array of slugs). */ ?>
<ul class="area-links">
<?php foreach ($townSlugs as $ts): $t = towns()[$ts] ?? null; if (!$t || !page_enabled($ts)) continue; ?>
  <li><a href="/<?= e($ts) ?>"><?= icon('pin') ?><?= e($t['name']) ?>, MA</a></li>
<?php endforeach; ?>
</ul>
