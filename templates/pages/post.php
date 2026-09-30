<?php $p = $page['post']; ?>
<article class="section"><div class="wrap with-aside">
  <div class="prose">
    <p class="meta"><?= e($p['category']) ?> · <time datetime="<?= e($p['date']) ?>"><?= e(date('F j, Y', strtotime($p['date']))) ?></time> · By <?= e(setting('short_name')) ?></p>
    <h1><?= e($page['h1']) ?></h1>
    <?php if (!empty($page['image'])): ?><img src="<?= e($page['image']) ?>" alt="<?= e($p['title']) ?>" loading="lazy"><?php endif; ?>
    <?= enrich($p['body'], 'blog/' . $page['slug']) ?>
    <div class="post-cta">
      <h2>Let Busy Bee handle it</h2>
      <p>Skip the ladder. Get a free, no-obligation estimate from our fully insured team.</p>
      <a class="btn btn-yellow" href="/free-estimate">Get My Free Estimate</a>
    </div>
    <h2>More from the blog</h2>
    <ul class="related-posts">
      <?php foreach (blog_posts() as $bs => $o): if ($bs === $page['slug'] || !page_enabled('blog/' . $bs)) continue; ?>
        <li><a href="/blog/<?= e($bs) ?>"><?= e($o['title']) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <aside class="aside"><?php $formTitle = 'Free Estimate'; require TPL_DIR . '/partials/quote-form.php'; ?></aside>
</div></article>
