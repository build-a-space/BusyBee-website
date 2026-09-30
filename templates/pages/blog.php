<section class="page-hero"><div class="wrap">
  <h1><?= e($page['h1']) ?></h1>
  <p class="lead">Expert tips, seasonal guides and honest advice to help Massachusetts homeowners keep their windows, gutters and exteriors in great shape.</p>
</div></section>
<section class="section"><div class="wrap">
  <div class="posts">
  <?php $posts = blog_posts(); uasort($posts, fn($a, $b) => strcmp($b['date'], $a['date']));
  foreach ($posts as $bs => $p): if (!page_enabled('blog/' . $bs)) continue; ?>
    <article class="post-card">
      <p class="meta"><?= e($p['category']) ?> · <time datetime="<?= e($p['date']) ?>"><?= e(date('M j, Y', strtotime($p['date']))) ?></time></p>
      <h2><a href="/blog/<?= e($bs) ?>"><?= e($p['title']) ?></a></h2>
      <p><?= e($p['excerpt']) ?></p>
      <a class="more" href="/blog/<?= e($bs) ?>" aria-label="Read <?= e($p['title']) ?>">Read article <?= icon('arrow') ?></a>
    </article>
  <?php endforeach; ?>
  </div>
</div></section>
