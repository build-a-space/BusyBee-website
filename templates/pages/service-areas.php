<section class="page-hero"><div class="wrap">
  <h1><?= e($page['h1']) ?></h1>
  <p class="lead">Based in Northborough, Busy Bee serves homes and businesses throughout Worcester County, MetroWest Middlesex County and Norfolk County. Find your town below.</p>
</div></section>
<section class="section"><div class="wrap">
  <div class="county-cards">
  <?php foreach (counties() as $cs => $c): if (!page_enabled($cs)) continue; ?>
    <div class="county-card">
      <h2><a href="/<?= e($cs) ?>"><?= e($c['name']) ?> County, MA</a></h2>
      <p><?= e($c['intro']) ?></p>
      <?php $townSlugs = array_filter(array_map('town_slug', $c['towns'])); require TPL_DIR . '/partials/area-links.php'; ?>
    </div>
  <?php endforeach; ?>
  </div>
  <div class="map-embed">
    <iframe title="Busy Bee service area map" src="<?= e(setting('map_embed_url')) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
  <p class="center muted">Don't see your town? We likely still serve you — <a href="/contact">contact us</a> and ask.</p>
</div></section>
