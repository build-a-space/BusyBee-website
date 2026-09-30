<?php
/**
 * Shared helpers.
 */
declare(strict_types=1);

function e(mixed $v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function base_url(): string
{
    return rtrim((string) setting('site_url', ''), '/');
}

function abs_url(string $path): string
{
    if (preg_match('#^https?://#i', $path)) {
        return $path;
    }
    return base_url() . '/' . ltrim($path, '/');
}

function tel_href(string $phone): string
{
    $digits = preg_replace('/\D+/', '', $phone);
    if (strlen($digits) === 10) {
        $digits = '1' . $digits;
    }
    return 'tel:+' . $digits;
}

function tel_e164(string $phone): string
{
    return substr(tel_href($phone), 4);
}

function full_address(): string
{
    $s = load_settings();
    return trim("{$s['street']}, {$s['city']}, {$s['state']} {$s['zip']}", ', ');
}

function asset(string $path): string
{
    $file = ROOT_DIR . '/' . ltrim($path, '/');
    $v = is_file($file) ? (string) filemtime($file) : '1';
    return $path . '?v=' . $v;
}

function current_path(): string
{
    $p = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $p = '/' . trim(rawurldecode($p), '/');
    return $p;
}

/* ---------- Sessions / security ---------- */

function start_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_name('bbsid');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function csrf_token(): string
{
    start_session();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_check(): bool
{
    start_session();
    $t = $_POST['csrf'] ?? '';
    return is_string($t) && !empty($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $t);
}

/** Stateless signed token for public forms (no session cookie needed for visitors). */
function site_secret(): string
{
    $file = DATA_DIR . '/.secret';
    if (!is_file($file)) {
        file_put_contents($file, bin2hex(random_bytes(32)), LOCK_EX);
        @chmod($file, 0600);
    }
    return trim((string) file_get_contents($file));
}

function form_token(int $ts): string
{
    return hash_hmac('sha256', 'form|' . $ts, site_secret());
}

function form_token_valid(): bool
{
    $ts = (int) ($_POST['ts'] ?? 0);
    $tok = (string) ($_POST['ft'] ?? '');
    $age = time() - $ts;
    return $age >= 3 && $age < 86400 && hash_equals(form_token($ts), $tok);
}

function is_admin(): bool
{
    if (session_status() !== PHP_SESSION_ACTIVE && !isset($_COOKIE['bbsid'])) {
        return false;
    }
    start_session();
    return !empty($_SESSION['admin_user']);
}

function client_ip(): string
{
    return (string) ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
}

function redirect(string $to, int $code = 302): never
{
    header('Location: ' . $to, true, $code);
    exit;
}

function flash(?string $msg = null, string $type = 'success'): ?array
{
    start_session();
    if ($msg !== null) {
        $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
        return null;
    }
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}

/* ---------- SEO content helpers ---------- */

/**
 * Walks the text nodes of an HTML fragment (skipping tags, <a>, headings, <strong>)
 * and applies $fn to each text chunk. Used for keyword highlighting + interlinking.
 */
function map_text_nodes(string $html, callable $fn): string
{
    $parts = preg_split('/(<[^>]+>)/', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
    $skipDepth = 0;
    $out = '';
    foreach ($parts as $part) {
        if ($part === '') {
            continue;
        }
        if ($part[0] === '<') {
            if (preg_match('#^<(a|h[1-6]|strong|b|button|script|style|summary)\b#i', $part)) {
                $skipDepth++;
            } elseif (preg_match('#^</(a|h[1-6]|strong|b|button|script|style|summary)>#i', $part)) {
                $skipDepth = max(0, $skipDepth - 1);
            }
            $out .= $part;
            continue;
        }
        $out .= $skipDepth > 0 ? $part : $fn($part);
    }
    return $out;
}

/**
 * Auto-link the first mention of each service / area to its page (never to the current page),
 * then bold the first mention of each highlight keyword.
 */
function enrich(string $html, string $currentSlug = ''): string
{
    $s = load_settings();
    if (!empty($s['auto_interlink'])) {
        $linked = [];
        $targets = interlink_targets();
        foreach ($targets as $phrase => $href) {
            if ($href === '/' . ltrim($currentSlug, '/') || isset($linked[$href])) {
                continue;
            }
            $done = false;
            $html = map_text_nodes($html, function (string $t) use ($phrase, $href, &$done) {
                if ($done) {
                    return $t;
                }
                $re = '/\b(' . preg_quote($phrase, '/') . ')\b/i';
                if (preg_match($re, $t)) {
                    $done = true;
                    return preg_replace($re, '<a href="' . e($href) . '" class="inlink">$1</a>', $t, 1);
                }
                return $t;
            });
            if ($done) {
                $linked[$href] = true;
            }
        }
    }
    foreach ((array) ($s['highlight_keywords'] ?? []) as $kw) {
        $kw = trim((string) $kw);
        if ($kw === '') {
            continue;
        }
        $done = false;
        $html = map_text_nodes($html, function (string $t) use ($kw, &$done) {
            if ($done) {
                return $t;
            }
            $re = '/\b(' . preg_quote($kw, '/') . ')\b/i';
            if (preg_match($re, $t)) {
                $done = true;
                return preg_replace($re, '<strong class="kw">$1</strong>', $t, 1);
            }
            return $t;
        });
    }
    return $html;
}

/** Phrase => URL map used by enrich(). Longer phrases first so they win. */
function interlink_targets(): array
{
    static $map = null;
    if ($map !== null) {
        return $map;
    }
    $map = [];
    foreach (services() as $slug => $svc) {
        if (!page_enabled($slug)) {
            continue;
        }
        foreach ($svc['link_phrases'] as $p) {
            $map[$p] = '/' . $slug;
        }
    }
    foreach (counties() as $slug => $c) {
        if (page_enabled($slug)) {
            $map[$c['name'] . ' County'] = '/' . $slug;
        }
    }
    uksort($map, fn($a, $b) => strlen($b) <=> strlen($a));
    return $map;
}

/** Page visibility / overrides from the admin. */
function page_override(string $slug): array
{
    $pages = (array) setting('pages', []);
    return (array) ($pages[$slug] ?? []);
}

function page_enabled(string $slug): bool
{
    $o = page_override($slug);
    return !array_key_exists('enabled', $o) || (bool) $o['enabled'];
}

function slugify(string $s): string
{
    $s = strtolower(trim($s));
    $s = preg_replace('/[^a-z0-9]+/', '-', $s);
    return trim((string) $s, '-');
}

function icon(string $name, string $class = 'ico'): string
{
    $paths = [
        'window'  => '<rect x="4" y="3" width="16" height="18" rx="1.5"/><path d="M12 3v18M4 12h16"/>',
        'gutter'  => '<path d="M3 7h18l-2 4H5z"/><path d="M17 11v8a2 2 0 0 1-2 2"/><path d="M9 15l1.5 2.5M12 14l1 2"/>',
        'guard'   => '<path d="M12 3l8 3v6c0 4.5-3.4 8.3-8 9-4.6-.7-8-4.5-8-9V6z"/><path d="M8.5 12l2.5 2.5 4.5-5"/>',
        'wash'    => '<path d="M3 12h7l3-3h4"/><path d="M17 7v4"/><path d="M20 5l-1.5 1.5M21 9h-2M20 13l-1.5-1.5"/><path d="M4 12v6h5"/>',
        'building'=> '<rect x="4" y="3" width="16" height="18" rx="1"/><path d="M8 7h2M14 7h2M8 11h2M14 11h2M8 15h2M14 15h2M11 21v-3h2v3"/>',
        'screen'  => '<rect x="4" y="3" width="16" height="18" rx="1"/><path d="M4 8h16M4 13h16M9 3v18M15 3v18"/>',
        'wrench'  => '<path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4l-2.6 2.6-2.4-.6-.6-2.4z"/>',
        'sun'     => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>',
        'phone'   => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/>',
        'mail'    => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
        'pin'     => '<path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/>',
        'clock'   => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'star'    => '<path d="M12 3l2.8 5.7 6.2.9-4.5 4.4 1.1 6.2L12 17.3 6.4 20.2l1.1-6.2L3 9.6l6.2-.9z"/>',
        'check'   => '<path d="M5 12.5l4.5 4.5L19 7.5"/>',
        'shield'  => '<path d="M12 3l8 3v6c0 4.5-3.4 8.3-8 9-4.6-.7-8-4.5-8-9V6z"/>',
        'leaf'    => '<path d="M5 19c0-8 5-14 15-14 0 10-6 15-14 15"/><path d="M5 19l7-7"/>',
        'calendar'=> '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>',
        'arrow'   => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'menu'    => '<path d="M3 6h18M3 12h18M3 18h18"/>',
        'chandelier' => '<path d="M12 2v5"/><path d="M5 11c0 2 3 3 7 3s7-1 7-3"/><path d="M5 11V9M19 11V9M12 14v3M5 11v4M19 11v4"/><circle cx="5" cy="17" r="1.5"/><circle cx="12" cy="19" r="1.5"/><circle cx="19" cy="17" r="1.5"/>',
    ];
    $p = $paths[$name] ?? $paths['check'];
    return '<svg class="' . e($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $p . '</svg>';
}

function stars(float $value = 5.0): string
{
    $out = '<span class="stars" aria-label="' . e(number_format($value, 1)) . ' out of 5 stars">';
    for ($i = 1; $i <= 5; $i++) {
        $out .= '<svg viewBox="0 0 24 24" class="star' . ($i <= round($value) ? ' on' : '') . '" aria-hidden="true"><path d="M12 3l2.8 5.7 6.2.9-4.5 4.4 1.1 6.2L12 17.3 6.4 20.2l1.1-6.2L3 9.6l6.2-.9z"/></svg>';
    }
    return $out . '</span>';
}

/** Store an uploaded image safely, return its public URL or null. */
function handle_image_upload(array $file, string $prefix = 'img'): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
        return null;
    }
    if ($file['size'] > 8 * 1024 * 1024) {
        return null;
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $ext = [
        'image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp',
        'image/gif' => 'gif', 'image/x-icon' => 'ico', 'image/vnd.microsoft.icon' => 'ico',
    ][$mime] ?? null;
    if ($ext === null) {
        return null;
    }
    if ($ext !== 'ico' && @getimagesize($file['tmp_name']) === false) {
        return null;
    }
    $name = slugify($prefix) . '-' . date('Ymd-His') . '-' . bin2hex(random_bytes(3)) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], UPLOAD_DIR . '/' . $name)) {
        return null;
    }
    @chmod(UPLOAD_DIR . '/' . $name, 0644);
    return UPLOAD_URL . '/' . $name;
}

function list_uploads(): array
{
    $files = glob(UPLOAD_DIR . '/*.{jpg,jpeg,png,webp,gif,ico}', GLOB_BRACE) ?: [];
    usort($files, fn($a, $b) => filemtime($b) <=> filemtime($a));
    return array_map(fn($f) => UPLOAD_URL . '/' . basename($f), $files);
}
