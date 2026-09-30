<section class="page-hero"><div class="wrap">
  <h1><?= e($page['h1']) ?></h1>
  <p class="lead">From crystal-clear windows to clog-free gutters and freshly washed siding, Busy Bee handles your entire exterior — for homes and businesses across Worcester, Middlesex &amp; Norfolk County.</p>
</div></section>
<section class="section"><div class="wrap">
  <?php require TPL_DIR . '/partials/service-cards.php'; ?>
</div></section>
<section class="section alt"><div class="wrap narrow prose">
  <?= enrich(<<<HTML
<h2>Why bundle your exterior cleaning?</h2>
<p>Most of our customers don't stop at one service. Scheduling window cleaning, gutter cleaning and power washing together means one appointment, one crew and one invoice — and your home looks its absolute best all at once. Fall is the most popular time to bundle, when gutters are full and windows need a wash before winter.</p>
<h2>Residential and commercial</h2>
<p>We serve single-family homes, condos and multi-family properties, plus storefronts, offices, restaurants and property-managed buildings. Every crew member is trained, uniformed and fully insured, and every job starts with a free estimate.</p>
HTML, 'services') ?>
</div></section>
