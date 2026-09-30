<?php
/**
 * Site settings — stored as JSON in /data/settings.json and editable from the admin panel.
 */
declare(strict_types=1);

function default_settings(): array
{
    return [
        'site_online'       => true,
        'maintenance_title' => "We'll be right back!",
        'maintenance_text'  => "Our website is getting a quick tune-up. Need your windows or gutters cleaned today? Give us a call — we're still buzzing.",

        'business_name'  => 'Busy Bee Window & Gutter Cleaning',
        'legal_name'     => 'Busy Bee Window & Gutter Cleaning, Inc.',
        'short_name'     => 'Busy Bee',
        'tagline'        => 'Window, Gutter & Exterior Cleaning in Worcester, Middlesex & Norfolk County, MA',
        'site_url'       => 'https://busybeewg.com',
        'founded'        => '2020',
        'owner'          => 'Timothy Clark',

        'phone'          => '(508) 499-9193',
        'phone_secondary'=> '',
        'email'          => 'busybeewindowgutter@gmail.com',
        'email_notify'   => 'busybeewindowgutter@gmail.com',

        'street'         => '235 W. Main St. Unit 601',
        'city'           => 'Northborough',
        'state'          => 'MA',
        'zip'            => '01532',
        'latitude'       => '42.3195',
        'longitude'      => '-71.6412',
        'map_embed_url'  => 'https://www.google.com/maps?q=235+W+Main+St+Northborough+MA+01532&output=embed',
        'google_business_url' => '',

        'hours' => [
            'Monday'    => '7:00 AM – 7:00 PM',
            'Tuesday'   => '7:00 AM – 7:00 PM',
            'Wednesday' => '7:00 AM – 7:00 PM',
            'Thursday'  => '7:00 AM – 7:00 PM',
            'Friday'    => '7:00 AM – 7:00 PM',
            'Saturday'  => 'Closed',
            'Sunday'    => 'Closed',
        ],

        'rating_value'   => '5.0',
        'rating_count'   => '400',
        'show_rating'    => true,

        'logo'           => '/assets/img/logo.webp',
        'favicon'        => '/assets/img/favicon.png',
        'hero_image'     => '',
        'og_image'       => '/assets/img/og-image.jpg',

        'hero_headline'  => 'Top-Rated Window & Gutter Cleaning in Worcester County, MA',
        'hero_subtext'   => 'Streak-free windows, clog-free gutters and a sparkling exterior — delivered by a local, fully insured crew that treats your home like our own hive.',

        'announcement'   => 'Free estimates • No contracts • 100% satisfaction guaranteed',
        'show_announcement' => true,

        'color_primary'  => '#FFD600',
        'color_dark'     => '#141414',
        'color_accent'   => '#F2A900',

        'social' => [
            'facebook'  => '',
            'instagram' => '',
            'google'    => '',
            'yelp'      => 'https://www.yelp.com/biz/busy-bee-window-and-gutter-cleaning-northborough-4',
            'nextdoor'  => 'https://nextdoor.com/pages/busy-bee-window-gutter-cleaning-boylston-ma/',
            'linkedin'  => '',
        ],

        // Words/phrases that get auto-bolded (first mention per block) in page content.
        'highlight_keywords' => [
            'window cleaning', 'gutter cleaning', 'power washing', 'gutter guard',
            'streak-free', 'free estimate', 'fully insured', 'Worcester County',
            'Middlesex County', 'Norfolk County', 'screen repair', 'downspout',
        ],
        'auto_interlink' => true,

        'ga_id'                 => '',
        'google_verification'   => '',
        'bing_verification'     => '',
        'head_code'             => '',

        // Per-page overrides: slug => [enabled, title, description, h1, image]
        'pages' => [],

        // Old URL => new URL (301)
        'redirects' => [
            '/residential-window-cleaning-services-in-northborough-ma' => '/northborough-worcester-county-ma-window-cleaning',
            '/residential-power-washing-services-in-worcester-ma'      => '/worcester-worcester-county-ma-window-cleaning',
            '/gutter-cleaning-services-in-shrewsbury-ma'               => '/shrewsbury-worcester-county-ma-window-cleaning',
            '/shrewsbury-ma'                                           => '/shrewsbury-worcester-county-ma-window-cleaning',
            '/revere-suffolk-county-massachusetts'                     => '/service-areas',
            '/blog/category/Affordable-Gutter-Cleaning-in-Middlesex-County' => '/blog',
        ],

        'testimonials' => [],

        'admin' => [
            'username'      => '',
            'password_hash' => '',
        ],
    ];
}

function settings_file(): string
{
    return DATA_DIR . '/settings.json';
}

function load_settings(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }
    $defaults = default_settings();
    $file = settings_file();
    $stored = [];
    if (is_file($file)) {
        $json = file_get_contents($file);
        $decoded = json_decode((string) $json, true);
        if (is_array($decoded)) {
            $stored = $decoded;
        }
    }
    // Shallow merge; nested assoc arrays (hours, social, admin) merged one level deep.
    foreach ($stored as $k => $v) {
        if (isset($defaults[$k]) && is_array($defaults[$k]) && is_array($v) && !array_is_list($defaults[$k]) && $k !== 'pages' && $k !== 'redirects') {
            $defaults[$k] = array_merge($defaults[$k], $v);
        } else {
            $defaults[$k] = $v;
        }
    }
    $cache = $defaults;
    return $cache;
}

function save_settings(array $settings): bool
{
    $file = settings_file();
    $tmp = $file . '.' . bin2hex(random_bytes(4)) . '.tmp';
    $json = json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    if ($json === false || file_put_contents($tmp, $json, LOCK_EX) === false) {
        return false;
    }
    return rename($tmp, $file);
}

function setting(string $key, mixed $default = ''): mixed
{
    $s = load_settings();
    return $s[$key] ?? $default;
}

/** JSON list store (messages, etc.) */
function load_list(string $name): array
{
    $file = DATA_DIR . '/' . $name . '.json';
    if (!is_file($file)) {
        return [];
    }
    $d = json_decode((string) file_get_contents($file), true);
    return is_array($d) ? $d : [];
}

function save_list(string $name, array $list): bool
{
    $file = DATA_DIR . '/' . $name . '.json';
    return file_put_contents($file, json_encode(array_values($list), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), LOCK_EX) !== false;
}
