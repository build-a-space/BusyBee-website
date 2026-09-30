<?php
/**
 * Admin panel controller — served at ADMIN_PATH (see includes/config.php).
 */
declare(strict_types=1);

header('X-Robots-Tag: noindex, nofollow', true);
header('X-Frame-Options: DENY');
header('Cache-Control: no-store');
start_session();

$sub = trim(substr(current_path(), strlen(ADMIN_PATH)), '/');
$settings = load_settings();
$needsSetup = empty($settings['admin']['username']) || empty($settings['admin']['password_hash']);
$A = ADMIN_PATH;

// Idle timeout (2 hours).
if (!empty($_SESSION['admin_user']) && (time() - (int) ($_SESSION['admin_seen'] ?? 0)) > 7200) {
    unset($_SESSION['admin_user']);
}
if (!empty($_SESSION['admin_user'])) {
    $_SESSION['admin_seen'] = time();
}

/* ---------- Login throttling ---------- */
function attempts_load(): array
{
    $a = load_list('login-attempts');
    $now = time();
    return array_filter($a, fn($r) => ($r['t'] ?? 0) > $now - LOGIN_LOCKOUT_SECONDS);
}
function locked_out(): bool
{
    $ip = client_ip();
    return count(array_filter(attempts_load(), fn($r) => $r['ip'] === $ip)) >= LOGIN_MAX_ATTEMPTS;
}
function record_failure(): void
{
    $a = attempts_load();
    $a[] = ['ip' => client_ip(), 't' => time()];
    save_list('login-attempts', $a);
}

/* ---------- First-run setup ---------- */
if ($needsSetup) {
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_check()) {
        $u = trim((string) ($_POST['username'] ?? ''));
        $p = (string) ($_POST['password'] ?? '');
        $p2 = (string) ($_POST['password2'] ?? '');
        if (strlen($u) < 3) {
            $error = 'Username must be at least 3 characters.';
        } elseif (strlen($p) < 10) {
            $error = 'Password must be at least 10 characters.';
        } elseif ($p !== $p2) {
            $error = 'Passwords do not match.';
        } else {
            $settings['admin'] = ['username' => $u, 'password_hash' => password_hash($p, PASSWORD_DEFAULT)];
            save_settings($settings);
            session_regenerate_id(true);
            $_SESSION['admin_user'] = $u;
            $_SESSION['admin_seen'] = time();
            flash('Admin account created. Welcome to your dashboard!');
            redirect($A);
        }
    }
    require __DIR__ . '/views/setup.php';
    exit;
}

/* ---------- Login ---------- */
if ($sub === 'logout') {
    $_SESSION = [];
    session_destroy();
    redirect($A);
}

if (empty($_SESSION['admin_user'])) {
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (locked_out()) {
            $error = 'Too many failed attempts. Please wait 15 minutes and try again.';
        } elseif (!csrf_check()) {
            $error = 'Your session expired. Please try again.';
        } else {
            $u = (string) ($_POST['username'] ?? '');
            $p = (string) ($_POST['password'] ?? '');
            if (hash_equals($settings['admin']['username'], $u) && password_verify($p, $settings['admin']['password_hash'])) {
                session_regenerate_id(true);
                $_SESSION['admin_user'] = $u;
                $_SESSION['admin_seen'] = time();
                if (password_needs_rehash($settings['admin']['password_hash'], PASSWORD_DEFAULT)) {
                    $settings['admin']['password_hash'] = password_hash($p, PASSWORD_DEFAULT);
                    save_settings($settings);
                }
                redirect($A);
            }
            record_failure();
            usleep(400000);
            $error = 'Incorrect username or password.';
        }
    }
    require __DIR__ . '/views/login.php';
    exit;
}

/* ---------- Authenticated actions ---------- */
$post = $_SERVER['REQUEST_METHOD'] === 'POST';
if ($post && !csrf_check()) {
    flash('Security token expired — please try again.', 'error');
    redirect($A . ($sub ? '/' . $sub : ''));
}
$str = fn(string $k, int $max = 500) => mb_substr(trim((string) ($_POST[$k] ?? '')), 0, $max);
$saveAndBack = function (array $s, string $msg) use ($A, $sub) {
    if (save_settings($s)) {
        flash($msg);
    } else {
        flash('Could not save — check that the /data folder is writable.', 'error');
    }
    redirect($A . ($sub ? '/' . $sub : ''));
};
$validUrl = fn(string $u) => $u === '' || preg_match('#^(https?://|/)#i', $u) ? $u : '';

switch ($sub) {
    case '':
        if ($post && isset($_POST['toggle_site'])) {
            $settings['site_online'] = !$settings['site_online'];
            $saveAndBack($settings, $settings['site_online'] ? 'Site is now ONLINE.' : 'Site is now OFFLINE — visitors see the maintenance page.');
        }
        break;

    case 'site':
        if ($post) {
            $settings['site_online'] = isset($_POST['site_online']);
            $settings['maintenance_title'] = $str('maintenance_title', 150);
            $settings['maintenance_text'] = $str('maintenance_text', 1000);
            $settings['show_announcement'] = isset($_POST['show_announcement']);
            $settings['announcement'] = $str('announcement', 200);
            $saveAndBack($settings, 'Site status saved.');
        }
        break;

    case 'business':
        if ($post) {
            foreach (['business_name' => 120, 'legal_name' => 150, 'short_name' => 60, 'tagline' => 250, 'founded' => 10, 'owner' => 100,
                      'phone' => 30, 'phone_secondary' => 30, 'street' => 150, 'city' => 80, 'state' => 2, 'zip' => 10,
                      'latitude' => 20, 'longitude' => 20, 'hero_headline' => 150, 'hero_subtext' => 400,
                      'rating_value' => 3, 'rating_count' => 7] as $k => $max) {
                $settings[$k] = $str($k, $max);
            }
            foreach (['email', 'email_notify'] as $k) {
                $v = $str($k, 150);
                $settings[$k] = ($v === '' || filter_var($v, FILTER_VALIDATE_EMAIL)) ? $v : $settings[$k];
            }
            $settings['state'] = strtoupper($settings['state']);
            $settings['site_url'] = rtrim($validUrl($str('site_url', 200)) ?: $settings['site_url'], '/');
            $settings['map_embed_url'] = $validUrl($str('map_embed_url', 1000));
            $settings['google_business_url'] = $validUrl($str('google_business_url', 500));
            $settings['show_rating'] = isset($_POST['show_rating']);
            foreach (array_keys($settings['hours']) as $d) {
                $settings['hours'][$d] = mb_substr(trim((string) ($_POST['hours'][$d] ?? '')), 0, 40);
            }
            foreach (array_keys($settings['social']) as $n) {
                $settings['social'][$n] = $validUrl(mb_substr(trim((string) ($_POST['social'][$n] ?? '')), 0, 300));
            }
            $saveAndBack($settings, 'Business info saved.');
        }
        break;

    case 'branding':
        if ($post) {
            foreach (['logo' => 'logo', 'favicon' => 'favicon', 'hero_image' => 'hero', 'og_image' => 'share-image'] as $field => $prefix) {
                if (!empty($_FILES[$field]['name'])) {
                    $url = handle_image_upload($_FILES[$field], $prefix);
                    if ($url === null) {
                        flash('Upload failed for ' . $field . ' — use JPG, PNG, WEBP or GIF under 8 MB.', 'error');
                        redirect($A . '/branding');
                    }
                    $settings[$field] = $url;
                } elseif (isset($_POST[$field . '_choose']) && $_POST[$field . '_choose'] !== '') {
                    $settings[$field] = $validUrl((string) $_POST[$field . '_choose']);
                }
                if (isset($_POST[$field . '_clear'])) {
                    $settings[$field] = $field === 'hero_image' ? '' : default_settings()[$field];
                }
            }
            foreach (['color_primary', 'color_dark', 'color_accent'] as $c) {
                $v = $str($c, 7);
                if (preg_match('/^#[0-9a-f]{6}$/i', $v)) {
                    $settings[$c] = $v;
                }
            }
            if (isset($_POST['reset_colors'])) {
                foreach (['color_primary', 'color_dark', 'color_accent'] as $c) {
                    $settings[$c] = default_settings()[$c];
                }
            }
            $saveAndBack($settings, 'Branding saved.');
        }
        break;

    case 'pages':
        if ($post) {
            $all = all_pages();
            $key = (string) ($_POST['key'] ?? '');
            if (isset($_POST['bulk'])) {
                $enabled = (array) ($_POST['enabled'] ?? []);
                foreach ($all as $k => $_) {
                    if ($k === 'home') {
                        continue;
                    }
                    $settings['pages'][$k]['enabled'] = in_array($k, $enabled, true);
                }
                $saveAndBack($settings, 'Page visibility saved.');
            }
            if (isset($all[$key])) {
                $o = $settings['pages'][$key] ?? [];
                $o['title'] = $str('title', 200);
                $o['description'] = $str('description', 400);
                $o['h1'] = $str('h1', 200);
                $o['image'] = $validUrl($str('image', 300));
                if (!empty($_FILES['image_file']['name'])) {
                    $o['image'] = handle_image_upload($_FILES['image_file'], $key) ?? $o['image'];
                }
                $o['enabled'] = $key === 'home' ? true : isset($_POST['enabled']);
                $settings['pages'][$key] = array_filter($o, fn($v) => $v !== '');
                $saveAndBack($settings, 'Page "' . $all[$key][1] . '" saved.');
            }
        }
        break;

    case 'reviews':
        if ($post) {
            if (isset($_POST['delete'])) {
                $i = (int) $_POST['delete'];
                array_splice($settings['testimonials'], $i, 1);
                $saveAndBack($settings, 'Review deleted.');
            }
            $t = [
                'name' => $str('name', 100),
                'location' => $str('location', 100),
                'rating' => max(1, min(5, (int) ($_POST['rating'] ?? 5))),
                'date' => preg_match('/^\d{4}-\d{2}-\d{2}$/', $str('date', 10)) ? $str('date', 10) : date('Y-m-d'),
                'text' => $str('text', 2000),
            ];
            if ($t['name'] !== '' && $t['text'] !== '') {
                if (isset($_POST['index']) && $_POST['index'] !== '' && isset($settings['testimonials'][(int) $_POST['index']])) {
                    $settings['testimonials'][(int) $_POST['index']] = $t;
                } else {
                    $settings['testimonials'][] = $t;
                }
                $saveAndBack($settings, 'Review saved.');
            }
            flash('Name and review text are required.', 'error');
            redirect($A . '/reviews');
        }
        break;

    case 'messages':
        $msgs = load_list('messages');
        if ($post) {
            $id = (string) ($_POST['id'] ?? '');
            if (isset($_POST['delete_all_read'])) {
                $msgs = array_filter($msgs, fn($m) => empty($m['read']));
            }
            foreach ($msgs as $i => $m) {
                if ($m['id'] !== $id) {
                    continue;
                }
                if (isset($_POST['delete'])) {
                    unset($msgs[$i]);
                } else {
                    $msgs[$i]['read'] = !empty($_POST['read']);
                }
            }
            save_list('messages', $msgs);
            flash('Messages updated.');
            redirect($A . '/messages');
        }
        break;

    case 'media':
        if ($post) {
            if (isset($_POST['delete'])) {
                $f = basename((string) $_POST['delete']);
                $path = UPLOAD_DIR . '/' . $f;
                if (is_file($path) && preg_match('/\.(jpe?g|png|webp|gif|ico)$/i', $f)) {
                    unlink($path);
                    flash('Image deleted.');
                }
                redirect($A . '/media');
            }
            $n = 0;
            $files = $_FILES['files'] ?? null;
            if ($files && is_array($files['name'])) {
                foreach ($files['name'] as $i => $name) {
                    $one = ['name' => $name, 'type' => $files['type'][$i], 'tmp_name' => $files['tmp_name'][$i], 'error' => $files['error'][$i], 'size' => $files['size'][$i]];
                    if (handle_image_upload($one, pathinfo((string) $name, PATHINFO_FILENAME) ?: 'photo')) {
                        $n++;
                    }
                }
            }
            flash($n ? "$n image(s) uploaded." : 'No valid images uploaded.', $n ? 'success' : 'error');
            redirect($A . '/media');
        }
        break;

    case 'seo':
        if ($post) {
            $settings['highlight_keywords'] = array_values(array_filter(array_map('trim', explode("\n", $str('highlight_keywords', 3000)))));
            $settings['auto_interlink'] = isset($_POST['auto_interlink']);
            $settings['ga_id'] = preg_match('/^[A-Z0-9\-]{0,30}$/i', $str('ga_id', 30)) ? $str('ga_id', 30) : '';
            $settings['google_verification'] = preg_replace('/[^A-Za-z0-9_\-]/', '', $str('google_verification', 100));
            $settings['bing_verification'] = preg_replace('/[^A-Za-z0-9_\-]/', '', $str('bing_verification', 100));
            $settings['head_code'] = (string) ($_POST['head_code'] ?? '');
            $redirects = [];
            foreach (explode("\n", (string) ($_POST['redirects'] ?? '')) as $line) {
                $parts = preg_split('/\s+/', trim($line));
                if (count($parts) === 2 && str_starts_with($parts[0], '/') && $validUrl($parts[1]) !== '') {
                    $redirects['/' . trim($parts[0], '/')] = $parts[1];
                }
            }
            $settings['redirects'] = $redirects;
            $saveAndBack($settings, 'SEO settings saved.');
        }
        break;

    case 'account':
        if ($post) {
            $cur = (string) ($_POST['current'] ?? '');
            if (!password_verify($cur, $settings['admin']['password_hash'])) {
                flash('Current password is incorrect.', 'error');
                redirect($A . '/account');
            }
            $u = $str('username', 60);
            $p = (string) ($_POST['password'] ?? '');
            if (strlen($u) >= 3) {
                $settings['admin']['username'] = $u;
                $_SESSION['admin_user'] = $u;
            }
            if ($p !== '') {
                if (strlen($p) < 10 || $p !== (string) ($_POST['password2'] ?? '')) {
                    flash('New password must be 10+ characters and match the confirmation.', 'error');
                    redirect($A . '/account');
                }
                $settings['admin']['password_hash'] = password_hash($p, PASSWORD_DEFAULT);
            }
            $saveAndBack($settings, 'Account updated.');
        }
        break;

    default:
        http_response_code(404);
        $sub = '404';
}

$settings = load_settings();
require __DIR__ . '/views/layout.php';
