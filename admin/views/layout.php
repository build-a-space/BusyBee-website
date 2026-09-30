<?php
/** @var string $sub @var array $settings @var string $A */
$titles = [
    '' => 'Dashboard', 'site' => 'Site On/Off', 'business' => 'Business Info', 'branding' => 'Logos & Branding',
    'pages' => 'Pages & SEO', 'reviews' => 'Reviews', 'messages' => 'Messages', 'media' => 'Media Library',
    'seo' => 'SEO & Tracking', 'account' => 'Account', '404' => 'Not found',
];
$adminTitle = $titles[$sub] ?? 'Dashboard';
$messages = load_list('messages');
$unread = count(array_filter($messages, fn($m) => empty($m['read'])));
$f = flash();
$s = $settings;
$uploads = list_uploads();
require __DIR__ . '/_head.php';

$imgPicker = function (string $field, string $label, string $help) use ($s, $uploads) {
    ?>
    <div class="card">
      <h2><?= e($label) ?></h2>
      <p class="muted"><?= e($help) ?></p>
      <?php if ($s[$field]): ?><img class="preview" src="<?= e($s[$field]) ?>" alt=""><code class="muted"><?= e($s[$field]) ?></code><?php else: ?><p class="muted"><em>None set</em></p><?php endif; ?>
      <label>Upload new<input type="file" name="<?= e($field) ?>" accept="image/*"></label>
      <?php if ($uploads): ?>
      <label>…or choose from media library
        <select name="<?= e($field) ?>_choose"><option value="">— keep current —</option>
          <?php foreach ($uploads as $u): ?><option value="<?= e($u) ?>"><?= e(basename($u)) ?></option><?php endforeach; ?>
        </select></label>
      <?php endif; ?>
      <label class="check"><input type="checkbox" name="<?= e($field) ?>_clear"> Reset to default</label>
    </div>
    <?php
};
?>
<body>
<div class="shell">
  <nav class="side" id="side">
    <a href="/" target="_blank" style="padding:0;background:none"><img src="<?= e($s['logo']) ?>" alt="View site"></a>
    <?php foreach (['' => 'Dashboard', 'site' => 'Site On/Off', 'business' => 'Business Info', 'branding' => 'Logos & Branding', 'pages' => 'Pages & SEO', 'reviews' => 'Reviews', 'messages' => 'Messages', 'media' => 'Media Library', 'seo' => 'SEO & Tracking', 'account' => 'Account'] as $k => $l): ?>
      <a href="<?= e($A . ($k ? '/' . $k : '')) ?>" class="<?= $sub === $k ? 'on' : '' ?>"><?= e($l) ?><?php if ($k === 'messages' && $unread): ?><span class="badge"><?= $unread ?></span><?php endif; ?></a>
    <?php endforeach; ?>
    <hr>
    <a href="/" target="_blank">View website ↗</a>
    <a href="<?= e($A) ?>/logout">Sign out</a>
  </nav>
  <main class="main">
    <div class="topbar">
      <h1><?= e($adminTitle) ?></h1>
      <div>
        <button class="btn sm dark menu-btn" onclick="document.getElementById('side').classList.toggle('open')">Menu</button>
        <span class="pill <?= $s['site_online'] ? 'on' : 'off' ?>">Site <?= $s['site_online'] ? 'ONLINE' : 'OFFLINE' ?></span>
      </div>
    </div>
    <?php if ($f): ?><div class="flash <?= e($f['type']) ?>"><?= e($f['msg']) ?></div><?php endif; ?>

<?php if ($sub === ''): ?>
    <div class="card status">
      <div>
        <h2 style="margin:0">Website is <?= $s['site_online'] ? 'live' : 'turned off' ?></h2>
        <p class="muted" style="margin:4px 0 0"><?= $s['site_online'] ? 'Visitors can see every page.' : 'Visitors see the maintenance page. You can still browse the site while signed in.' ?></p>
      </div>
      <form method="post"><?= csrf_field() ?><button class="btn <?= $s['site_online'] ? 'red' : 'green' ?>" name="toggle_site" value="1" onclick="return confirm('<?= $s['site_online'] ? 'Turn the website OFF for visitors?' : 'Turn the website back ON?' ?>')"><?= $s['site_online'] ? 'Turn site OFF' : 'Turn site ON' ?></button></form>
    </div>
    <div class="stats">
      <div class="stat"><b><?= $unread ?></b>Unread messages</div>
      <div class="stat"><b><?= count($messages) ?></b>Total estimate requests</div>
      <div class="stat"><b><?= count(array_filter(all_pages(), fn($k) => page_enabled($k), ARRAY_FILTER_USE_KEY)) ?></b>Live pages</div>
      <div class="stat"><b><?= count($s['testimonials']) ?></b>Reviews on site</div>
    </div>
    <div class="card">
      <h2>Quick info</h2>
      <table>
        <tr><th>Phone</th><td><?= e($s['phone']) ?></td><td rowspan="4" style="width:1%"><a class="btn sm" href="<?= e($A) ?>/business">Edit</a></td></tr>
        <tr><th>Email</th><td><?= e($s['email']) ?></td></tr>
        <tr><th>Address</th><td><?= e(full_address()) ?></td></tr>
        <tr><th>Hours</th><td>Mon–Fri <?= e($s['hours']['Monday']) ?></td></tr>
      </table>
    </div>
    <?php if ($messages): ?>
    <div class="card">
      <h2>Latest requests</h2>
      <table><tr><th>Date</th><th>Name</th><th>Phone</th><th>Services</th></tr>
      <?php foreach (array_slice($messages, 0, 5) as $m): ?>
        <tr class="msg <?= empty($m['read']) ? 'unread' : '' ?>"><td><?= e(date('M j, g:ia', strtotime($m['date']))) ?></td><td><?= e($m['name']) ?></td><td><a href="<?= e(tel_href($m['phone'])) ?>"><?= e($m['phone']) ?></a></td><td><?= e(implode(', ', $m['services'])) ?></td></tr>
      <?php endforeach; ?>
      </table>
      <p><a href="<?= e($A) ?>/messages">View all messages →</a></p>
    </div>
    <?php endif; ?>
    <div class="card">
      <h2>SEO quick links</h2>
      <p><a href="/sitemap.xml" target="_blank">sitemap.xml</a> · <a href="/robots.txt" target="_blank">robots.txt</a> · <a href="https://search.google.com/test/rich-results?url=<?= e(rawurlencode(abs_url('/'))) ?>" target="_blank" rel="noopener">Test schema (Google Rich Results)</a> · <a href="https://validator.schema.org/#url=<?= e(rawurlencode(abs_url('/'))) ?>" target="_blank" rel="noopener">Schema validator</a></p>
    </div>

<?php elseif ($sub === 'site'): ?>
    <form method="post"><?= csrf_field() ?>
    <div class="card">
      <h2>Website status</h2>
      <label class="check"><input type="checkbox" name="site_online" <?= $s['site_online'] ? 'checked' : '' ?>> Website is ONLINE (uncheck to show the maintenance page to visitors)</label>
      <p class="muted">While offline, visitors get a friendly maintenance page with your phone and email (HTTP 503 so Google knows it's temporary). You can still view the full site while signed in.</p>
      <label>Maintenance headline<input type="text" name="maintenance_title" value="<?= e($s['maintenance_title']) ?>"></label>
      <label>Maintenance message<textarea name="maintenance_text"><?= e($s['maintenance_text']) ?></textarea></label>
    </div>
    <div class="card">
      <h2>Announcement bar</h2>
      <label class="check"><input type="checkbox" name="show_announcement" <?= $s['show_announcement'] ? 'checked' : '' ?>> Show the yellow bar at the top of every page</label>
      <label>Announcement text<input type="text" name="announcement" value="<?= e($s['announcement']) ?>"></label>
    </div>
    <button class="btn">Save</button>
    </form>

<?php elseif ($sub === 'business'): ?>
    <form method="post"><?= csrf_field() ?>
    <div class="card"><h2>Contact details</h2><div class="grid">
      <label>Main phone<input type="tel" name="phone" value="<?= e($s['phone']) ?>" required></label>
      <label>Second phone (optional)<input type="tel" name="phone_secondary" value="<?= e($s['phone_secondary']) ?>"></label>
      <label>Public email<input type="email" name="email" value="<?= e($s['email']) ?>"></label>
      <label>Send form notifications to<input type="email" name="email_notify" value="<?= e($s['email_notify']) ?>"></label>
    </div></div>
    <div class="card"><h2>Address</h2><div class="grid">
      <label>Street<input type="text" name="street" value="<?= e($s['street']) ?>"></label>
      <label>City<input type="text" name="city" value="<?= e($s['city']) ?>"></label>
      <label>State<input type="text" name="state" value="<?= e($s['state']) ?>" maxlength="2"></label>
      <label>ZIP<input type="text" name="zip" value="<?= e($s['zip']) ?>"></label>
      <label>Latitude<input type="text" name="latitude" value="<?= e($s['latitude']) ?>"></label>
      <label>Longitude<input type="text" name="longitude" value="<?= e($s['longitude']) ?>"></label>
    </div>
      <label>Google Maps embed URL<input type="url" name="map_embed_url" value="<?= e($s['map_embed_url']) ?>"></label>
      <label>Google Business Profile URL (for "Review us on Google")<input type="url" name="google_business_url" value="<?= e($s['google_business_url']) ?>"></label>
    </div>
    <div class="card"><h2>Business hours</h2><div class="grid">
      <?php foreach ($s['hours'] as $d => $h): ?><label><?= e($d) ?><input type="text" name="hours[<?= e($d) ?>]" value="<?= e($h) ?>" placeholder="7:00 AM – 7:00 PM or Closed"></label><?php endforeach; ?>
    </div><p class="muted">Use the format "7:00 AM – 7:00 PM" so it appears in Google's structured data.</p></div>
    <div class="card"><h2>Business details</h2><div class="grid">
      <label>Business name<input type="text" name="business_name" value="<?= e($s['business_name']) ?>"></label>
      <label>Legal name<input type="text" name="legal_name" value="<?= e($s['legal_name']) ?>"></label>
      <label>Short name<input type="text" name="short_name" value="<?= e($s['short_name']) ?>"></label>
      <label>Year founded<input type="text" name="founded" value="<?= e($s['founded']) ?>"></label>
      <label>Owner<input type="text" name="owner" value="<?= e($s['owner']) ?>"></label>
      <label>Website URL (no trailing slash)<input type="url" name="site_url" value="<?= e($s['site_url']) ?>"></label>
    </div>
      <label>Tagline<input type="text" name="tagline" value="<?= e($s['tagline']) ?>"></label>
      <label>Homepage headline (H1)<input type="text" name="hero_headline" value="<?= e($s['hero_headline']) ?>"></label>
      <label>Homepage intro text<textarea name="hero_subtext"><?= e($s['hero_subtext']) ?></textarea></label>
    </div>
    <div class="card"><h2>Rating</h2><div class="grid">
      <label>Average rating<input type="text" name="rating_value" value="<?= e($s['rating_value']) ?>"></label>
      <label>Number of reviews<input type="number" name="rating_count" value="<?= e($s['rating_count']) ?>"></label>
    </div><label class="check"><input type="checkbox" name="show_rating" <?= $s['show_rating'] ? 'checked' : '' ?>> Show rating on the site and in schema</label>
    <p class="muted">Keep this matched to your real Google/Yelp totals.</p></div>
    <div class="card"><h2>Social profiles</h2><div class="grid">
      <?php foreach ($s['social'] as $n => $u): ?><label><?= e(ucfirst($n)) ?><input type="url" name="social[<?= e($n) ?>]" value="<?= e($u) ?>"></label><?php endforeach; ?>
    </div></div>
    <button class="btn">Save business info</button>
    </form>

<?php elseif ($sub === 'branding'): ?>
    <form method="post" enctype="multipart/form-data"><?= csrf_field() ?>
    <div class="grid2">
      <?php $imgPicker('logo', 'Logo', 'Shown in the header, footer and schema. Transparent PNG/WEBP works best (header background is black).'); ?>
      <?php $imgPicker('favicon', 'Favicon', 'Square image, at least 192×192.'); ?>
      <?php $imgPicker('hero_image', 'Homepage hero photo', 'Optional background photo behind the homepage headline. Wide photos (1920×1080) look best.'); ?>
      <?php $imgPicker('og_image', 'Social share image', 'Shown when your site is shared on Facebook, text messages, etc. 1200×630 recommended.'); ?>
    </div>
    <div class="card"><h2>Brand colors</h2><div class="grid">
      <label>Primary (yellow)<input type="color" name="color_primary" value="<?= e($s['color_primary']) ?>"></label>
      <label>Dark (header/footer)<input type="color" name="color_dark" value="<?= e($s['color_dark']) ?>"></label>
      <label>Accent<input type="color" name="color_accent" value="<?= e($s['color_accent']) ?>"></label>
    </div><label class="check"><input type="checkbox" name="reset_colors"> Reset to Busy Bee defaults</label></div>
    <button class="btn">Save branding</button>
    </form>

<?php elseif ($sub === 'pages'): $all = all_pages(); $groups = ['core' => 'Main pages', 'service' => 'Service pages', 'county' => 'County pages', 'town' => 'Town pages', 'blog' => 'Blog posts']; ?>
    <?php $edit = $_GET['edit'] ?? ''; if ($edit !== '' && isset($all[$edit])): $o = page_override($edit); ?>
      <form method="post" enctype="multipart/form-data" class="card"><?= csrf_field() ?>
        <input type="hidden" name="key" value="<?= e($edit) ?>">
        <h2>Edit: <?= e($all[$edit][1]) ?> <a class="muted" href="<?= e($all[$edit][0]) ?>" target="_blank"><?= e($all[$edit][0]) ?> ↗</a></h2>
        <p class="muted">Leave a field blank to use the built-in default.</p>
        <?php if ($edit !== 'home'): ?><label class="check"><input type="checkbox" name="enabled" <?= page_enabled($edit) ? 'checked' : '' ?>> Page is published</label><?php endif; ?>
        <label>SEO title (≈50–60 characters)<input type="text" name="title" value="<?= e($o['title'] ?? '') ?>" maxlength="200"></label>
        <label>Meta description (≈140–160 characters)<textarea name="description" maxlength="400"><?= e($o['description'] ?? '') ?></textarea></label>
        <label>Page headline (H1)<input type="text" name="h1" value="<?= e($o['h1'] ?? '') ?>"></label>
        <label>Page image URL<input type="text" name="image" value="<?= e($o['image'] ?? '') ?>" list="uploads"></label>
        <datalist id="uploads"><?php foreach ($uploads as $u): ?><option value="<?= e($u) ?>"><?php endforeach; ?></datalist>
        <label>…or upload an image<input type="file" name="image_file" accept="image/*"></label>
        <button class="btn">Save page</button> <a href="<?= e($A) ?>/pages">Cancel</a>
      </form>
    <?php endif; ?>
    <form method="post"><?= csrf_field() ?><input type="hidden" name="bulk" value="1">
    <?php foreach ($groups as $g => $gl): ?>
      <div class="card"><h2><?= e($gl) ?></h2>
      <table><tr><th style="width:70px">Live</th><th>Page</th><th>URL</th><th></th></tr>
      <?php foreach ($all as $k => [$url, $label, $type]): if ($type !== $g) continue; ?>
        <tr><td><input type="checkbox" name="enabled[]" value="<?= e($k) ?>" <?= page_enabled($k) ? 'checked' : '' ?> <?= $k === 'home' ? 'disabled checked' : '' ?>></td>
        <td><?= e($label) ?><?= page_override($k) && array_diff_key(page_override($k), ['enabled' => 1]) ? ' <span class="muted">(customized)</span>' : '' ?></td>
        <td><a href="<?= e($url) ?>" target="_blank"><?= e($url) ?></a></td>
        <td><a class="btn sm" href="<?= e($A) ?>/pages?edit=<?= e(rawurlencode($k)) ?>">Edit SEO</a></td></tr>
      <?php endforeach; ?>
      </table></div>
    <?php endforeach; ?>
    <button class="btn">Save page visibility</button>
    <p class="muted">Unpublished pages return a 404, drop out of the sitemap, navigation and internal links.</p>
    </form>

<?php elseif ($sub === 'reviews'): $ei = isset($_GET['edit']) ? (int) $_GET['edit'] : null; $et = $ei !== null ? ($s['testimonials'][$ei] ?? null) : null; ?>
    <form method="post" class="card"><?= csrf_field() ?>
      <h2><?= $et ? 'Edit review' : 'Add a customer review' ?></h2>
      <p class="muted">Only add real reviews (e.g. copied from Google with the customer's first name). These appear on the site and in your review schema.</p>
      <input type="hidden" name="index" value="<?= $et ? e($ei) : '' ?>">
      <div class="grid">
        <label>Customer name<input type="text" name="name" value="<?= e($et['name'] ?? '') ?>" required></label>
        <label>Town (optional)<input type="text" name="location" value="<?= e($et['location'] ?? '') ?>"></label>
        <label>Stars<select name="rating"><?php for ($i = 5; $i >= 1; $i--): ?><option <?= (int) ($et['rating'] ?? 5) === $i ? 'selected' : '' ?>><?= $i ?></option><?php endfor; ?></select></label>
        <label>Date<input type="date" name="date" value="<?= e($et['date'] ?? date('Y-m-d')) ?>"></label>
      </div>
      <label>Review text<textarea name="text" required><?= e($et['text'] ?? '') ?></textarea></label>
      <button class="btn"><?= $et ? 'Update review' : 'Add review' ?></button>
      <?php if ($et): ?> <a href="<?= e($A) ?>/reviews">Cancel</a><?php endif; ?>
    </form>
    <div class="card"><h2>Reviews on the site (<?= count($s['testimonials']) ?>)</h2>
      <?php if (!$s['testimonials']): ?><p class="muted">No reviews yet.</p><?php endif; ?>
      <table><?php foreach ($s['testimonials'] as $i => $t): ?>
        <tr><td><strong><?= e($t['name']) ?></strong><br><span class="muted"><?= e($t['location'] ?? '') ?> · <?= str_repeat('★', (int) $t['rating']) ?> · <?= e($t['date'] ?? '') ?></span></td><td><?= e($t['text']) ?></td>
        <td style="white-space:nowrap"><a class="btn sm" href="<?= e($A) ?>/reviews?edit=<?= $i ?>">Edit</a>
        <form method="post" style="display:inline"><?= csrf_field() ?><button class="btn sm red" name="delete" value="<?= $i ?>" onclick="return confirm('Delete this review?')">Delete</button></form></td></tr>
      <?php endforeach; ?></table>
    </div>

<?php elseif ($sub === 'messages'): ?>
    <div class="card">
      <?php if (!$messages): ?><p class="muted">No messages yet. Estimate requests from the website will appear here (and be emailed to <?= e($s['email_notify'] ?: $s['email']) ?>).</p><?php endif; ?>
      <?php foreach ($messages as $m): ?>
        <div class="msg <?= empty($m['read']) ? 'unread' : '' ?>" style="border-bottom:1px solid var(--line);padding:14px 8px">
          <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap">
            <div><strong><?= e($m['name']) ?></strong> · <a href="<?= e(tel_href($m['phone'])) ?>"><?= e($m['phone']) ?></a><?= $m['email'] ? ' · <a href="mailto:' . e($m['email']) . '">' . e($m['email']) . '</a>' : '' ?><?= $m['town'] ? ' · ' . e($m['town']) : '' ?>
            <br><span class="muted"><?= e(date('D M j, Y g:ia', strtotime($m['date']))) ?> · from <?= e($m['page']) ?></span></div>
            <form method="post" style="white-space:nowrap"><?= csrf_field() ?><input type="hidden" name="id" value="<?= e($m['id']) ?>">
              <?php if (empty($m['read'])): ?><button class="btn sm" name="read" value="1">Mark read</button><?php else: ?><button class="btn sm dark" name="read" value="">Mark unread</button><?php endif; ?>
              <button class="btn sm red" name="delete" value="1" onclick="return confirm('Delete this message?')">Delete</button></form>
          </div>
          <?php if ($m['services']): ?><p style="margin:6px 0"><strong>Services:</strong> <?= e(implode(', ', $m['services'])) ?></p><?php endif; ?>
          <?php if ($m['message']): ?><p style="margin:6px 0;white-space:pre-wrap"><?= e($m['message']) ?></p><?php endif; ?>
        </div>
      <?php endforeach; ?>
      <?php if ($messages): ?><form method="post" style="margin-top:14px"><?= csrf_field() ?><button class="btn sm red" name="delete_all_read" value="1" onclick="return confirm('Delete all read messages?')">Delete all read messages</button></form><?php endif; ?>
    </div>

<?php elseif ($sub === 'media'): ?>
    <form method="post" enctype="multipart/form-data" class="card"><?= csrf_field() ?>
      <h2>Upload photos</h2>
      <p class="muted">Upload job photos, team photos or logos (JPG, PNG, WEBP, GIF — up to 8 MB each). Use them for the homepage hero, service pages, blog posts and more. Tip: give files descriptive names like <code>gutter-cleaning-shrewsbury.jpg</code> for better image SEO.</p>
      <input type="file" name="files[]" accept="image/*" multiple required>
      <button class="btn" style="margin-top:10px">Upload</button>
    </form>
    <div class="card"><h2>Library (<?= count($uploads) ?>)</h2>
      <div class="thumbs"><?php foreach ($uploads as $u): ?>
        <div class="thumb"><img src="<?= e($u) ?>" alt="" loading="lazy"><input type="text" value="<?= e($u) ?>" readonly onclick="this.select()">
        <form method="post"><?= csrf_field() ?><button class="btn sm red" name="delete" value="<?= e(basename($u)) ?>" onclick="return confirm('Delete this image? Pages using it will show a broken image.')" style="margin-top:6px">Delete</button></form></div>
      <?php endforeach; ?></div>
    </div>

<?php elseif ($sub === 'seo'): ?>
    <form method="post"><?= csrf_field() ?>
    <div class="card"><h2>Keyword highlighting</h2>
      <p class="muted">The first mention of each phrase in page content is bolded with a yellow highlight. One phrase per line.</p>
      <textarea name="highlight_keywords" rows="8"><?= e(implode("\n", $s['highlight_keywords'])) ?></textarea>
      <label class="check" style="margin-top:10px"><input type="checkbox" name="auto_interlink" <?= $s['auto_interlink'] ? 'checked' : '' ?>> Automatic internal linking (first mention of a service or county links to its page)</label>
    </div>
    <div class="card"><h2>Tracking &amp; verification</h2><div class="grid">
      <label>Google Analytics 4 ID<input type="text" name="ga_id" value="<?= e($s['ga_id']) ?>" placeholder="G-XXXXXXX"></label>
      <label>Google Search Console verification code<input type="text" name="google_verification" value="<?= e($s['google_verification']) ?>"></label>
      <label>Bing verification code<input type="text" name="bing_verification" value="<?= e($s['bing_verification']) ?>"></label>
    </div>
      <label>Extra &lt;head&gt; code (pixels, chat widgets — advanced)<textarea class="code" name="head_code" rows="5"><?= e($s['head_code']) ?></textarea></label>
    </div>
    <div class="card"><h2>301 redirects</h2>
      <p class="muted">One per line: <code>/old-url /new-url</code>. Use this to keep old links and Google rankings when a URL changes.</p>
      <textarea class="code" name="redirects" rows="8"><?php foreach ($s['redirects'] as $from => $to) echo e($from . ' ' . $to) . "\n"; ?></textarea>
    </div>
    <button class="btn">Save SEO settings</button>
    </form>

<?php elseif ($sub === 'account'): ?>
    <form method="post" class="card" style="max-width:520px"><?= csrf_field() ?>
      <h2>Login details</h2>
      <label>Username<input type="text" name="username" value="<?= e($s['admin']['username']) ?>" autocomplete="username"></label>
      <label>New password (leave blank to keep current)<input type="password" name="password" minlength="10" autocomplete="new-password"></label>
      <label>Confirm new password<input type="password" name="password2" autocomplete="new-password"></label>
      <label>Current password (required)<input type="password" name="current" required autocomplete="current-password"></label>
      <button class="btn">Update account</button>
    </form>

<?php else: ?>
    <div class="card"><p>That page doesn't exist. <a href="<?= e($A) ?>">Back to dashboard</a></p></div>
<?php endif; ?>
  </main>
</div>
</body></html>
