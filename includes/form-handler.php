<?php
/**
 * Handles quote/contact form POSTs: validates, stores in /data/messages.json, emails the owner.
 */
declare(strict_types=1);

$back = '/contact';
$src = (string) ($_POST['source'] ?? '');
if (preg_match('#^/[a-z0-9/\-]*$#i', $src)) {
    $back = $src;
}
$fail = fn() => redirect($back . '?error=1#quote', 303);

// Spam checks: honeypot, CSRF, too-fast submissions.
if (!empty($_POST['website']) || !form_token_valid()) {
    $fail();
}

$clean = fn(string $k, int $max) => mb_substr(trim(strip_tags((string) ($_POST[$k] ?? ''))), 0, $max);
$name = $clean('name', 100);
$phone = $clean('phone', 30);
$email = $clean('email', 150);
$town = $clean('town', 100);
$message = $clean('message', 3000);
$services = array_map(fn($v) => mb_substr(strip_tags((string) $v), 0, 60), array_slice((array) ($_POST['services'] ?? []), 0, 12));

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $email = '';
}
if ($name === '' || ($phone === '' && $email === '') || ($phone !== '' && strlen(preg_replace('/\D/', '', $phone)) < 10)) {
    $fail();
}

// Basic per-IP rate limit (5 per 10 minutes).
$now = time();
$hits = array_values(array_filter(load_list('form-hits'), fn($h) => $h['t'] > $now - 600));
if (count(array_filter($hits, fn($h) => $h['ip'] === client_ip())) >= 5) {
    $fail();
}
$hits[] = ['ip' => client_ip(), 't' => $now];
save_list('form-hits', $hits);

$entry = [
    'id' => bin2hex(random_bytes(6)),
    'date' => date('c'),
    'name' => $name,
    'phone' => $phone,
    'email' => $email,
    'town' => $town,
    'services' => $services,
    'message' => $message,
    'page' => $back,
    'ip' => client_ip(),
    'read' => false,
];
$list = load_list('messages');
array_unshift($list, $entry);
save_list('messages', array_slice($list, 0, 2000));

$to = (string) setting('email_notify') ?: (string) setting('email');
if ($to !== '' && function_exists('mail')) {
    $host = parse_url(base_url(), PHP_URL_HOST) ?: 'localhost';
    $body = "New estimate request from the website\n\n"
        . "Name: $name\nPhone: $phone\nEmail: $email\nTown: $town\n"
        . 'Services: ' . implode(', ', $services) . "\nPage: $back\n\nMessage:\n$message\n";
    $headers = "From: Website <no-reply@$host>\r\nContent-Type: text/plain; charset=UTF-8\r\n";
    if ($email !== '') {
        $headers .= "Reply-To: $email\r\n";
    }
    @mail($to, 'New estimate request: ' . $name, $body, $headers);
}

redirect($back . '?sent=1#quote', 303);
