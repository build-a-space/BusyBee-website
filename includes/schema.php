<?php
/**
 * JSON-LD structured data builders (schema.org).
 */
declare(strict_types=1);

function org_id(): string
{
    return abs_url('/#business');
}

function schema_opening_hours(): array
{
    $map = ['Monday' => 'Mo', 'Tuesday' => 'Tu', 'Wednesday' => 'We', 'Thursday' => 'Th', 'Friday' => 'Fr', 'Saturday' => 'Sa', 'Sunday' => 'Su'];
    $out = [];
    foreach ((array) setting('hours', []) as $day => $val) {
        if (!preg_match('/(\d{1,2}):(\d{2})\s*(AM|PM)\s*[–-]\s*(\d{1,2}):(\d{2})\s*(AM|PM)/i', (string) $val, $m)) {
            continue;
        }
        $to24 = function ($h, $min, $ap) {
            $h = (int) $h % 12 + (strtoupper($ap) === 'PM' ? 12 : 0);
            return sprintf('%02d:%s', $h, $min);
        };
        $out[] = [
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => 'https://schema.org/' . $day,
            'opens' => $to24($m[1], $m[2], $m[3]),
            'closes' => $to24($m[4], $m[5], $m[6]),
        ];
    }
    return $out;
}

function schema_area_served(): array
{
    $areas = [];
    foreach (counties() as $c) {
        $areas[] = ['@type' => 'AdministrativeArea', 'name' => $c['name'] . ' County, MA'];
    }
    foreach (towns() as $t) {
        $areas[] = ['@type' => 'City', 'name' => $t['name'] . ', MA'];
    }
    return $areas;
}

function schema_local_business(): array
{
    $s = load_settings();
    $sameAs = array_values(array_filter((array) $s['social']));
    if (!empty($s['google_business_url'])) {
        $sameAs[] = $s['google_business_url'];
    }
    $offers = [];
    foreach (services() as $slug => $svc) {
        $offers[] = [
            '@type' => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $svc['name'], 'url' => abs_url('/' . $slug)],
        ];
    }
    $biz = [
        '@type' => ['LocalBusiness', 'HomeAndConstructionBusiness'],
        '@id' => org_id(),
        'name' => $s['business_name'],
        'legalName' => $s['legal_name'],
        'alternateName' => $s['short_name'],
        'description' => $s['tagline'],
        'url' => abs_url('/'),
        'logo' => abs_url($s['logo']),
        'image' => abs_url($s['og_image'] ?: $s['logo']),
        'telephone' => tel_e164($s['phone']),
        'email' => $s['email'],
        'priceRange' => '$$',
        'foundingDate' => $s['founded'],
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $s['street'],
            'addressLocality' => $s['city'],
            'addressRegion' => $s['state'],
            'postalCode' => $s['zip'],
            'addressCountry' => 'US',
        ],
        'openingHoursSpecification' => schema_opening_hours(),
        'areaServed' => schema_area_served(),
        'hasOfferCatalog' => [
            '@type' => 'OfferCatalog',
            'name' => 'Exterior Cleaning Services',
            'itemListElement' => $offers,
        ],
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'telephone' => tel_e164($s['phone']),
            'contactType' => 'customer service',
            'areaServed' => 'US-MA',
            'availableLanguage' => 'English',
        ],
    ];
    if ($s['latitude'] !== '' && $s['longitude'] !== '') {
        $biz['geo'] = ['@type' => 'GeoCoordinates', 'latitude' => (float) $s['latitude'], 'longitude' => (float) $s['longitude']];
        $biz['hasMap'] = 'https://www.google.com/maps?q=' . rawurlencode(full_address());
    }
    if (!empty($s['owner'])) {
        $biz['founder'] = ['@type' => 'Person', 'name' => $s['owner']];
    }
    if ($sameAs) {
        $biz['sameAs'] = $sameAs;
    }
    if (!empty($s['show_rating']) && (float) $s['rating_value'] > 0 && (int) $s['rating_count'] > 0) {
        $biz['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => (string) $s['rating_value'],
            'reviewCount' => (string) (int) $s['rating_count'],
            'bestRating' => '5',
            'worstRating' => '1',
        ];
    }
    $reviews = [];
    foreach ((array) $s['testimonials'] as $t) {
        if (empty($t['name']) || empty($t['text'])) {
            continue;
        }
        $reviews[] = [
            '@type' => 'Review',
            'author' => ['@type' => 'Person', 'name' => $t['name']],
            'reviewBody' => $t['text'],
            'reviewRating' => ['@type' => 'Rating', 'ratingValue' => (string) ($t['rating'] ?? 5), 'bestRating' => '5'],
        ] + (!empty($t['date']) ? ['datePublished' => $t['date']] : []);
    }
    if ($reviews) {
        $biz['review'] = $reviews;
    }
    return $biz;
}

function schema_website(): array
{
    return [
        '@type' => 'WebSite',
        '@id' => abs_url('/#website'),
        'url' => abs_url('/'),
        'name' => setting('business_name'),
        'publisher' => ['@id' => org_id()],
        'inLanguage' => 'en-US',
    ];
}

function schema_breadcrumbs(array $crumbs): array
{
    $items = [];
    $i = 1;
    foreach ($crumbs as [$name, $url]) {
        $items[] = ['@type' => 'ListItem', 'position' => $i++, 'name' => $name, 'item' => abs_url($url)];
    }
    return ['@type' => 'BreadcrumbList', 'itemListElement' => $items];
}

function schema_faq(array $faqs): array
{
    return [
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn($f) => [
            '@type' => 'Question',
            'name' => $f[0],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
        ], $faqs),
    ];
}

function schema_service(string $slug, array $svc, ?string $areaName = null): array
{
    $area = $areaName
        ? [['@type' => 'City', 'name' => $areaName]]
        : array_map(fn($c) => ['@type' => 'AdministrativeArea', 'name' => $c['name'] . ' County, MA'], array_values(counties()));
    return [
        '@type' => 'Service',
        '@id' => abs_url('/' . $slug . '#service'),
        'name' => $svc['name'],
        'serviceType' => $svc['name'],
        'description' => $svc['description'],
        'url' => abs_url('/' . $slug),
        'provider' => ['@id' => org_id()],
        'areaServed' => $area,
        'offers' => [
            '@type' => 'Offer',
            'priceCurrency' => 'USD',
            'price' => '0',
            'description' => 'Free, no-obligation estimate',
        ],
    ];
}

function schema_howto(string $name, array $steps): array
{
    $i = 1;
    return [
        '@type' => 'HowTo',
        'name' => $name,
        'step' => array_map(function ($s) use (&$i) {
            return ['@type' => 'HowToStep', 'position' => $i++, 'name' => $s[0], 'text' => $s[1]];
        }, $steps),
    ];
}

function schema_webpage(string $url, string $title, string $description, string $type = 'WebPage'): array
{
    return [
        '@type' => $type,
        '@id' => abs_url($url) . '#webpage',
        'url' => abs_url($url),
        'name' => $title,
        'description' => $description,
        'isPartOf' => ['@id' => abs_url('/#website')],
        'about' => ['@id' => org_id()],
        'inLanguage' => 'en-US',
    ];
}

function schema_blog_post(string $slug, array $post): array
{
    return [
        '@type' => 'BlogPosting',
        '@id' => abs_url('/blog/' . $slug . '#article'),
        'headline' => $post['title'],
        'description' => $post['description'],
        'datePublished' => $post['date'],
        'dateModified' => $post['date'],
        'mainEntityOfPage' => abs_url('/blog/' . $slug),
        'image' => abs_url((string) setting('og_image')),
        'articleSection' => $post['category'],
        'author' => ['@type' => 'Organization', 'name' => setting('business_name'), 'url' => abs_url('/')],
        'publisher' => ['@id' => org_id()],
    ];
}

/** Render a @graph block. */
function render_schema(array $nodes): string
{
    $graph = ['@context' => 'https://schema.org', '@graph' => array_values($nodes)];
    $json = json_encode($graph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP);
    return '<script type="application/ld+json">' . $json . '</script>';
}
