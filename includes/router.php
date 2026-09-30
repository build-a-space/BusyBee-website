<?php
/**
 * Maps a URL path to a page definition (template + SEO metadata + schema).
 */
declare(strict_types=1);

function apply_overrides(string $key, array $page): ?array
{
    if (!page_enabled($key)) {
        return null;
    }
    $o = page_override($key);
    foreach (['title', 'description', 'h1', 'image'] as $f) {
        if (!empty($o[$f])) {
            $page[$f] = $o[$f];
        }
    }
    return $page;
}

function base_nodes(array $page): array
{
    $nodes = [
        schema_local_business(),
        schema_website(),
        schema_webpage($page['canonical'] ?? '/', $page['title'], $page['description'], $page['page_type'] ?? 'WebPage'),
    ];
    if (!empty($page['breadcrumbs']) && count($page['breadcrumbs']) > 1) {
        $nodes[] = schema_breadcrumbs($page['breadcrumbs']);
    }
    return $nodes;
}

function resolve_page(string $path): ?array
{
    $s = load_settings();
    $biz = $s['business_name'];
    $slug = ltrim($path, '/');
    $page = null;
    $key = $slug === '' ? 'home' : $slug;

    if ($path === '/') {
        $page = [
            'template' => 'home',
            'title' => $s['hero_headline'] . ' | ' . $s['short_name'],
            'description' => 'Busy Bee delivers 5-star residential & commercial window cleaning, gutter cleaning, gutter guards and power washing across Worcester, Middlesex & Norfolk County, MA. Free estimates: ' . $s['phone'] . '.',
            'h1' => $s['hero_headline'],
            'breadcrumbs' => [['Home', '/']],
            'extra_schema' => [schema_faq(array_slice(general_faqs(), 0, 5))],
        ];
    } elseif ($slug === 'services') {
        $page = [
            'template' => 'services',
            'title' => 'Exterior Cleaning Services | Windows, Gutters & Power Washing | Busy Bee',
            'description' => 'Explore Busy Bee\'s exterior cleaning services: residential and commercial window cleaning, gutter cleaning, gutter guards, repairs, power washing and more.',
            'h1' => 'Exterior Cleaning Services',
            'breadcrumbs' => [['Home', '/'], ['Services', '/services']],
        ];
        $items = [];
        $i = 1;
        foreach (services() as $sl => $svc) {
            if (page_enabled($sl)) {
                $items[] = ['@type' => 'ListItem', 'position' => $i++, 'url' => abs_url('/' . $sl), 'name' => $svc['name']];
            }
        }
        $page['extra_schema'] = [['@type' => 'ItemList', 'name' => 'Busy Bee Services', 'itemListElement' => $items]];
    } elseif (isset(services()[$slug])) {
        $svc = services()[$slug];
        $page = [
            'template' => 'service',
            'service' => $svc,
            'slug' => $slug,
            'title' => $svc['title'],
            'description' => $svc['description'],
            'h1' => $svc['h1'],
            'breadcrumbs' => [['Home', '/'], ['Services', '/services'], [$svc['name'], '/' . $slug]],
            'extra_schema' => [
                schema_service($slug, $svc),
                schema_faq($svc['faqs']),
                schema_howto('How Busy Bee handles ' . strtolower($svc['name']), $svc['steps']),
            ],
        ];
    } elseif ($slug === 'service-areas') {
        $page = [
            'template' => 'service-areas',
            'title' => 'Service Areas | Worcester, Middlesex & Norfolk County, MA | Busy Bee',
            'description' => 'Busy Bee serves homes and businesses across Worcester, Middlesex and Norfolk County, MA. Find your town for local window cleaning, gutter cleaning and power washing.',
            'h1' => 'Our Service Areas',
            'breadcrumbs' => [['Home', '/'], ['Service Areas', '/service-areas']],
        ];
    } elseif (isset(counties()[$slug])) {
        $c = counties()[$slug];
        $page = [
            'template' => 'county',
            'county' => $c,
            'slug' => $slug,
            'title' => $c['title'],
            'description' => $c['description'],
            'h1' => 'Window & Gutter Cleaning in ' . $c['name'] . ' County, MA',
            'breadcrumbs' => [['Home', '/'], ['Service Areas', '/service-areas'], [$c['name'] . ' County', '/' . $slug]],
        ];
        $page['extra_schema'] = [
            array_merge(schema_service($slug, [
                'name' => 'Window Cleaning & Gutter Cleaning',
                'description' => $c['description'],
            ]), ['areaServed' => ['@type' => 'AdministrativeArea', 'name' => $c['name'] . ' County, MA']]),
        ];
    } elseif (isset(towns()[$slug])) {
        $t = towns()[$slug];
        $c = counties()[$t['county_slug']];
        $page = [
            'template' => 'town',
            'town' => $t,
            'county' => $c,
            'slug' => $slug,
            'title' => 'Window & Gutter Cleaning in ' . $t['name'] . ', MA | Busy Bee',
            'description' => 'Professional window cleaning, gutter cleaning, gutter guards and power washing in ' . $t['name'] . ', ' . $c['name'] . ' County, MA. Fully insured, 5-star rated. Free estimates: ' . $s['phone'] . '.',
            'h1' => 'Window Cleaning & Gutter Cleaning in ' . $t['name'] . ', MA',
            'breadcrumbs' => [['Home', '/'], ['Service Areas', '/service-areas'], [$c['name'] . ' County', '/' . $t['county_slug']], [$t['name'], '/' . $slug]],
        ];
        $faqs = [
            ['Do you offer window cleaning in ' . $t['name'] . ', MA?', 'Yes. Busy Bee provides residential and commercial window cleaning throughout ' . $t['name'] . ' and the rest of ' . $c['name'] . ' County, along with gutter cleaning, gutter guards and power washing.'],
            ['How much does gutter cleaning cost in ' . $t['name'] . '?', 'Pricing depends on the size of your home, roof height and how full the gutters are. We provide free, no-obligation estimates — call ' . $s['phone'] . ' or request one online.'],
            ['How quickly can you get to ' . $t['name'] . '?', 'We\'re based in Northborough and schedule regular service days in ' . $t['name'] . '. Most customers are booked within one to two weeks, often sooner.'],
        ];
        $page['faqs'] = $faqs;
        $page['extra_schema'] = [
            array_merge(schema_service($slug, [
                'name' => 'Window Cleaning & Gutter Cleaning in ' . $t['name'] . ', MA',
                'description' => $page['description'],
            ], $t['name'] . ', MA'), []),
            schema_faq($faqs),
        ];
    } elseif ($slug === 'about') {
        $page = [
            'template' => 'about',
            'title' => 'About Busy Bee Window & Gutter Cleaning | Northborough, MA',
            'description' => 'Meet Busy Bee — a locally owned, fully insured window and gutter cleaning company based in Northborough, MA, serving Central Massachusetts since ' . $s['founded'] . '.',
            'h1' => 'About Busy Bee',
            'page_type' => 'AboutPage',
            'breadcrumbs' => [['Home', '/'], ['About', '/about']],
        ];
    } elseif ($slug === 'reviews') {
        $page = [
            'template' => 'reviews',
            'title' => 'Busy Bee Reviews | 5-Star Window & Gutter Cleaning in MA',
            'description' => 'See why homeowners and businesses across Massachusetts rate Busy Bee ' . $s['rating_value'] . ' stars for window cleaning, gutter cleaning and power washing.',
            'h1' => 'Busy Bee Reviews',
            'breadcrumbs' => [['Home', '/'], ['Reviews', '/reviews']],
        ];
    } elseif ($slug === 'contact' || $slug === 'free-estimate') {
        $page = [
            'template' => 'contact',
            'title' => $slug === 'contact'
                ? 'Contact Busy Bee | Window Cleaning & Gutter Services in MA'
                : 'Get a Free Estimate | Busy Bee Window & Gutter Cleaning',
            'description' => 'Contact Busy Bee for a free, no-obligation estimate on window cleaning, gutter cleaning and power washing. Call ' . $s['phone'] . ' or send us a message.',
            'h1' => $slug === 'contact' ? 'Contact Busy Bee' : 'Get Your Free Estimate',
            'page_type' => 'ContactPage',
            'breadcrumbs' => [['Home', '/'], [$slug === 'contact' ? 'Contact' : 'Free Estimate', '/' . $slug]],
        ];
    } elseif ($slug === 'faq') {
        $page = [
            'template' => 'faq',
            'title' => 'Frequently Asked Questions | Busy Bee Window & Gutter Cleaning',
            'description' => 'Answers to common questions about Busy Bee window cleaning, gutter cleaning, gutter guards, power washing, pricing, insurance and service areas.',
            'h1' => 'Frequently Asked Questions',
            'page_type' => 'WebPage',
            'breadcrumbs' => [['Home', '/'], ['FAQ', '/faq']],
        ];
        $all = general_faqs();
        foreach (services() as $svc) {
            $all = array_merge($all, $svc['faqs']);
        }
        $page['all_faqs'] = $all;
        $page['extra_schema'] = [schema_faq($all)];
    } elseif ($slug === 'blog') {
        $page = [
            'template' => 'blog',
            'title' => 'Busy Bee Blog | Window, Gutter & Exterior Cleaning Tips',
            'description' => 'Tips, seasonal guides and expert advice from Busy Bee to help Massachusetts homeowners keep windows, gutters and exteriors in great shape.',
            'h1' => 'The Busy Bee Blog',
            'page_type' => 'CollectionPage',
            'breadcrumbs' => [['Home', '/'], ['Blog', '/blog']],
        ];
        $page['extra_schema'] = [[
            '@type' => 'Blog',
            'name' => 'The Busy Bee Blog',
            'url' => abs_url('/blog'),
            'publisher' => ['@id' => org_id()],
            'blogPost' => array_map(fn($sl, $p) => ['@type' => 'BlogPosting', 'headline' => $p['title'], 'url' => abs_url('/blog/' . $sl), 'datePublished' => $p['date']], array_keys(blog_posts()), blog_posts()),
        ]];
    } elseif (str_starts_with($slug, 'blog/') && isset(blog_posts()[substr($slug, 5)])) {
        $bs = substr($slug, 5);
        $post = blog_posts()[$bs];
        $page = [
            'template' => 'post',
            'post' => $post,
            'slug' => $bs,
            'title' => $post['title'] . ' | Busy Bee Blog',
            'description' => $post['description'],
            'h1' => $post['title'],
            'og_type' => 'article',
            'breadcrumbs' => [['Home', '/'], ['Blog', '/blog'], [$post['title'], '/blog/' . $bs]],
            'extra_schema' => [schema_blog_post($bs, $post)],
        ];
    } elseif ($slug === 'privacy-policy') {
        $page = [
            'template' => 'privacy',
            'title' => 'Privacy Policy | ' . $biz,
            'description' => 'How ' . $biz . ' collects, uses and protects the information you share with us.',
            'h1' => 'Privacy Policy',
            'breadcrumbs' => [['Home', '/'], ['Privacy Policy', '/privacy-policy']],
        ];
    }

    if ($page === null) {
        return null;
    }
    $page = apply_overrides($key, $page);
    if ($page === null) {
        return null;
    }
    $page['canonical'] = $path;
    $page['key'] = $key;
    $page['schema'] = array_merge(base_nodes($page), $page['extra_schema'] ?? []);
    return $page;
}
