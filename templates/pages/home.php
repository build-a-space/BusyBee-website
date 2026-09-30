<?php $s = load_settings(); $hero = $page['image'] ?? $s['hero_image']; ?>
<section class="hero<?= $hero ? ' has-img' : '' ?>"<?= $hero ? ' style="--hero:url(\'' . e($hero) . '\')"' : '' ?>>
  <div class="honeycomb" aria-hidden="true"></div>
  <div class="wrap hero-grid">
    <div class="hero-copy">
      <?php if ($s['show_rating']): ?>
        <p class="hero-rating"><?= stars((float) $s['rating_value']) ?> <span><strong><?= e($s['rating_value']) ?></strong> · <?= e(number_format((int) $s['rating_count'])) ?>+ verified reviews</span></p>
      <?php endif; ?>
      <h1><?= e($page['h1']) ?></h1>
      <p class="hero-sub"><?= e($s['hero_subtext']) ?></p>
      <div class="hero-actions">
        <a class="btn btn-yellow btn-lg" href="#quote">Get My Free Estimate</a>
        <a class="btn btn-ghost btn-lg" href="<?= e(tel_href($s['phone'])) ?>"><?= icon('phone') ?> <?= e($s['phone']) ?></a>
      </div>
      <ul class="hero-points">
        <li><?= icon('check') ?>Streak-free guarantee</li>
        <li><?= icon('check') ?>Fully insured crew</li>
        <li><?= icon('check') ?>No contracts</li>
      </ul>
    </div>
    <div class="hero-form">
      <?php $formTitle = 'Get a Free Estimate'; require TPL_DIR . '/partials/quote-form.php'; ?>
    </div>
  </div>
</section>

<section class="wrap trust-wrap"><?php require TPL_DIR . '/partials/trust.php'; ?></section>

<section class="section">
  <div class="wrap">
    <header class="sec-head">
      <p class="eyebrow">What we do</p>
      <h2>Window, Gutter &amp; Exterior Cleaning Services</h2>
      <p>One local, insured crew for every part of your home's exterior — from the glass to the gutters to the driveway.</p>
    </header>
    <?php require TPL_DIR . '/partials/service-cards.php'; ?>
    <p class="center"><a class="btn btn-dark" href="/services">View All Services</a></p>
  </div>
</section>

<section class="section alt">
  <div class="wrap split">
    <div class="prose">
      <p class="eyebrow">Why Busy Bee</p>
      <h2>Central Massachusetts' Hardest-Working Cleaning Crew</h2>
      <?= enrich(<<<HTML
<p>Busy Bee Window &amp; Gutter Cleaning is a locally owned company based in Northborough, right in the heart of Worcester County. Since {$s['founded']} we've built our reputation one home at a time — showing up on schedule, protecting your property, and leaving every window streak-free and every gutter flowing.</p>
<p>We handle residential window cleaning, commercial window cleaning, gutter cleaning, gutter guard installation, gutter repairs, power washing, screen repair and skylight cleaning for homeowners and businesses across Worcester County, Middlesex County and Norfolk County. Every job comes with a free estimate and our 100% satisfaction guarantee.</p>
HTML, '') ?>
      <ul class="checks">
        <li>Uniformed, background-checked, fully insured technicians</li>
        <li>Drop cloths and shoe covers inside your home — always</li>
        <li>Up-front pricing with no hidden fees or contracts</li>
        <li>Text reminders and on-time arrival windows</li>
      </ul>
      <a class="btn btn-yellow" href="/about">Meet the Busy Bee team</a>
    </div>
    <div class="why-art" aria-hidden="true">
      <div class="hex big"><img src="<?= e($s['logo']) ?>" alt="" width="320" height="175" loading="lazy"></div>
      <div class="hex s1"><?= icon('window') ?></div>
      <div class="hex s2"><?= icon('gutter') ?></div>
      <div class="hex s3"><?= icon('wash') ?></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <header class="sec-head">
      <p class="eyebrow">How it works</p>
      <h2>Clean Windows &amp; Gutters in 3 Easy Steps</h2>
    </header>
    <ol class="steps">
      <li><span class="n">1</span><h3>Request a free estimate</h3><p>Call, text or fill out the form. We'll ask a few quick questions and send an up-front price.</p></li>
      <li><span class="n">2</span><h3>Pick a time that works</h3><p>Choose a day that fits your schedule. We'll send a reminder before we arrive.</p></li>
      <li><span class="n">3</span><h3>Enjoy the view</h3><p>We clean, walk the job with you and leave your property spotless — guaranteed.</p></li>
    </ol>
  </div>
</section>

<?php if ($s['testimonials']): ?>
<section class="section alt">
  <div class="wrap">
    <header class="sec-head"><p class="eyebrow">Reviews</p><h2>What Our Customers Say</h2></header>
    <?php $limit = 3; require TPL_DIR . '/partials/testimonials.php'; ?>
    <p class="center"><a class="btn btn-dark" href="/reviews">Read More Reviews</a></p>
  </div>
</section>
<?php endif; ?>

<section class="section areas-band">
  <div class="wrap">
    <header class="sec-head">
      <p class="eyebrow">Service areas</p>
      <h2>Proudly Serving Worcester, Middlesex &amp; Norfolk County</h2>
      <p>Based in Northborough, we're minutes from most of Central Massachusetts and MetroWest.</p>
    </header>
    <div class="county-cards">
      <?php foreach (counties() as $cs => $c): if (!page_enabled($cs)) continue; ?>
        <div class="county-card">
          <h3><a href="/<?= e($cs) ?>"><?= e($c['name']) ?> County</a></h3>
          <?php $townSlugs = array_filter(array_map('town_slug', $c['towns'])); require TPL_DIR . '/partials/area-links.php'; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section alt">
  <div class="wrap narrow">
    <header class="sec-head"><p class="eyebrow">FAQ</p><h2>Common Questions</h2></header>
    <?php $faqs = array_slice(general_faqs(), 0, 5); require TPL_DIR . '/partials/faq-list.php'; ?>
    <p class="center"><a href="/faq" class="more">See all FAQs <?= icon('arrow') ?></a></p>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <header class="sec-head"><p class="eyebrow">From the blog</p><h2>Tips for Massachusetts Homeowners</h2></header>
    <div class="posts">
      <?php foreach (array_slice(blog_posts(), 0, 3, true) as $bs => $p): if (!page_enabled('blog/' . $bs)) continue; ?>
        <article class="post-card">
          <p class="meta"><?= e($p['category']) ?> · <time datetime="<?= e($p['date']) ?>"><?= e(date('M j, Y', strtotime($p['date']))) ?></time></p>
          <h3><a href="/blog/<?= e($bs) ?>"><?= e($p['title']) ?></a></h3>
          <p><?= e($p['excerpt']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
