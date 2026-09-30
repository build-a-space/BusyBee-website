<section class="page-hero"><div class="wrap">
  <h1><?= e($page['h1']) ?></h1>
  <p class="lead">Quick answers about our services, pricing, scheduling and service areas. Don't see your question? <a href="/contact">Just ask.</a></p>
  <label class="faq-search"><span class="sr">Search FAQs</span><input type="search" placeholder="Search questions…" data-faq-filter></label>
</div></section>
<section class="section"><div class="wrap narrow">
  <h2>General</h2>
  <?php $faqs = general_faqs(); require TPL_DIR . '/partials/faq-list.php'; ?>
  <?php foreach (services() as $sl => $svc): if (!page_enabled($sl)) continue; ?>
    <h2><a href="/<?= e($sl) ?>"><?= e($svc['name']) ?></a></h2>
    <?php $faqs = $svc['faqs']; require TPL_DIR . '/partials/faq-list.php'; ?>
  <?php endforeach; ?>
</div></section>
