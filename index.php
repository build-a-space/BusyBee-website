<?php
/**
 * Front controller — every public URL is routed through here.
 */
declare(strict_types=1);

require __DIR__ . '/includes/config.php';

$rawPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$path = current_path();

// Normalize trailing slashes and uppercase (keeps one canonical URL per page).
if ($rawPath !== '/' && str_ends_with($rawPath, '/') && !str_starts_with($path, ADMIN_PATH)) {
    $qs = $_SERVER['QUERY_STRING'] ?? '';
    redirect($path . ($qs !== '' ? '?' . $qs : ''), 301);
}

// Admin panel (secret path).
if ($path === ADMIN_PATH || str_starts_with($path, ADMIN_PATH . '/')) {
    require ROOT_DIR . '/admin/admin.php';
    exit;
}

// 301 redirects managed in the admin.
$redirects = (array) setting('redirects', []);
foreach ($redirects as $from => $to) {
    if (rtrim((string) $from, '/') === $path && $to !== '') {
        redirect((string) $to, 301);
    }
}

// Technical SEO files.
if ($path === '/sitemap.xml') {
    require ROOT_DIR . '/includes/sitemap.php';
    exit;
}
if ($path === '/robots.txt') {
    header('Content-Type: text/plain; charset=utf-8');
    if (!setting('site_online', true)) {
        echo "User-agent: *\nDisallow: /\n";
        exit;
    }
    echo "User-agent: *\nAllow: /\nDisallow: /data/\nDisallow: /includes/\nDisallow: /templates/\nDisallow: /admin/\n\nSitemap: " . abs_url('/sitemap.xml') . "\n";
    exit;
}

// Site on/off switch. Logged-in admins can still preview everything.
if (!setting('site_online', true) && !is_admin()) {
    http_response_code(503);
    header('Retry-After: 3600');
    require TPL_DIR . '/maintenance.php';
    exit;
}

// Form submissions.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($path, ['/contact', '/free-estimate'], true)) {
    require ROOT_DIR . '/includes/form-handler.php';
    exit;
}

require ROOT_DIR . '/includes/router.php';
$page = resolve_page($path);

if ($page === null) {
    http_response_code(404);
    $page = [
        'template' => '404',
        'title' => 'Page Not Found | ' . setting('business_name'),
        'description' => 'Sorry, we couldn\'t find that page.',
        'h1' => 'Oops — this page flew the hive.',
        'canonical' => null,
        'noindex' => true,
        'breadcrumbs' => [['Home', '/'], ['Page not found', $path]],
        'schema' => [],
    ];
}

require TPL_DIR . '/layout.php';
