<?php
/**
 * Site content: services, service areas, blog posts and FAQs.
 * Titles/descriptions/H1s can be overridden per page in the admin panel.
 */
declare(strict_types=1);

function services(): array
{
    return [
        'residential-window-cleaning' => [
            'name'  => 'Residential Window Cleaning',
            'short' => 'Window Cleaning',
            'icon'  => 'window',
            'title' => 'Residential Window Cleaning in Worcester County, MA | Busy Bee',
            'description' => 'Streak-free residential window cleaning inside and out — tracks, sills, storm windows and skylights. Fully insured, free estimates. Call Busy Bee: (508) 499-9193.',
            'h1'    => 'Professional Residential Window Cleaning',
            'lead'  => 'Crystal-clear glass, inside and out, from a local crew that sweats the details — tracks, sills, frames and all.',
            'link_phrases' => ['residential window cleaning', 'window cleaning', 'window washing'],
            'body'  => <<<HTML
<p>Clean windows change the way your whole home feels. More daylight gets in, the view looks sharper, and the outside of the house instantly looks cared for. Busy Bee's residential window cleaning service is built for Massachusetts homes — from Cape and Colonial to modern builds with oversized picture windows — and we clean every pane by hand with purified water, professional squeegees and lint-free microfiber.</p>
<h2>What's included in every window cleaning</h2>
<p>We don't just wipe the glass and leave. A standard visit covers interior and exterior glass, a detail wipe of frames and sills, and a vacuum and wipe-down of the window tracks where dirt, pollen and dead bugs collect. We also clean storm windows, glass doors and slider tracks, and we can add screen washing and skylight cleaning to the same appointment.</p>
<ul class="checks">
<li>Interior and exterior glass cleaned by hand for a streak-free finish</li>
<li>Frames, sills and tracks detailed and vacuumed</li>
<li>Storm windows, sliders, French doors and hard-to-reach panes</li>
<li>Drop cloths and shoe covers used inside your home</li>
<li>Hard-water spot and paint-overspray removal on request</li>
</ul>
<h2>Why homeowners hire a pro instead of DIY</h2>
<p>Second- and third-story windows are where most homeowners draw the line — and for good reason. Ladders on uneven ground are one of the most common causes of at-home injuries. Our technicians are trained on ladder safety, carry the right extension poles, and are fully insured, so you get spotless glass without anyone in your family climbing up to get it. We also spot small problems while we work, like failed seals, cracked glazing or torn screens, and let you know before they get worse.</p>
<h2>How often should you clean your windows?</h2>
<p>For most homes in Central Massachusetts we recommend a full inside-and-out cleaning twice a year: once in spring to wash away winter salt and road film, and once in fall to clear summer pollen before the dark months. Homes near busy roads, lakes or construction may benefit from quarterly exterior service. Ask about pairing your window cleaning with gutter cleaning in the fall — one visit, one bill, and your whole exterior is ready for winter.</p>
HTML,
            'steps' => [
                ['Free estimate', 'Tell us about your home and we\'ll give you a clear, up-front price — no pressure, no obligation.'],
                ['Protect & prep', 'We lay drop cloths, wear shoe covers and move blinds or small items with care.'],
                ['Hand-detailed cleaning', 'Glass, frames, sills and tracks cleaned inside and out for a streak-free shine.'],
                ['Walk-through', 'We check every window with you before we pack up. Not happy? We make it right.'],
            ],
            'faqs' => [
                ['Do you clean both the inside and outside of windows?', 'Yes. Our standard residential service includes interior and exterior glass, frames, sills and tracks. You can also book exterior-only service if you prefer.'],
                ['Do I need to be home during the window cleaning?', 'Only for interior work. Exterior-only cleanings can be done while you\'re at work — we\'ll text you when we\'re finished.'],
                ['What if it rains on my appointment day?', 'Light rain doesn\'t affect the result — rain itself is clean water, and the dirt we remove is what causes spots. In heavy storms we\'ll reschedule at no charge.'],
            ],
            'related' => ['screen-cleaning-and-repair', 'skylight-and-chandelier-cleaning', 'gutter-cleaning'],
        ],

        'commercial-window-cleaning' => [
            'name'  => 'Commercial Window Cleaning',
            'short' => 'Commercial Windows',
            'icon'  => 'building',
            'title' => 'Commercial Window Cleaning & Storefront Washing | Busy Bee MA',
            'description' => 'Storefront and low- to mid-rise commercial window cleaning on a schedule that fits your business. Fully insured crew serving Worcester & Middlesex County, MA.',
            'h1'    => 'Commercial Window Cleaning & Storefront Service',
            'lead'  => 'First impressions happen at the front door. We keep your storefront, office and mid-rise glass spotless on a schedule that works around your hours.',
            'link_phrases' => ['commercial window cleaning', 'storefront window cleaning', 'storefront'],
            'body'  => <<<HTML
<p>Customers notice smudged glass, water spots and cobwebs before they notice anything else about your business. Busy Bee provides commercial window cleaning for retail storefronts, restaurants, medical and dental offices, property-managed buildings, churches, schools and low- to mid-rise office buildings throughout Central Massachusetts.</p>
<h2>Flexible schedules for busy businesses</h2>
<p>We set you up on a recurring route — weekly, bi-weekly, monthly or quarterly — so you never have to remember to call. Early-morning and after-hours cleanings are available so we're never in the way of your customers or staff. You'll always know when we're coming and what was done.</p>
<ul class="checks">
<li>Storefront glass, entry doors and display windows</li>
<li>Low- and mid-rise exterior glass using water-fed poles and ladders</li>
<li>Interior office glass, partitions and glass railings</li>
<li>Frames, sills and door hardware wiped down</li>
<li>Certificates of insurance available on request</li>
</ul>
<h2>Water-fed pole technology</h2>
<p>For many commercial buildings we use a water-fed pole system that delivers purified, de-ionized water to a soft brush at heights of several stories. Because the water contains no minerals, it dries to a spot-free finish without chemicals or squeegee marks — and our crew stays safely on the ground. It's faster, safer and gentler on your building.</p>
<h2>One vendor for the whole exterior</h2>
<p>Many of our commercial customers bundle window washing with power washing of sidewalks, entryways and dumpster pads, and seasonal gutter cleaning. One trusted, insured vendor, one invoice, and a building that always looks open for business.</p>
HTML,
            'steps' => [
                ['Site walk', 'We look at your building, access points and glass count, then send a written quote.'],
                ['Set a schedule', 'Pick a frequency and time window that fits your hours — early morning, evening or weekend.'],
                ['Clean & report', 'Our insured crew handles the work and confirms completion after every visit.'],
                ['Stay consistent', 'Recurring service keeps glass spotless year-round with no reminders needed.'],
            ],
            'faqs' => [
                ['Do you provide a certificate of insurance?', 'Yes. We are fully insured and can send a certificate of insurance to your property manager or landlord before the first visit.'],
                ['Can you clean before or after business hours?', 'Absolutely. Early-morning and after-hours slots are available so your customers never have to work around us.'],
                ['How tall of a building can you clean?', 'We service storefronts and low- to mid-rise buildings reachable by water-fed pole and ladders. Contact us with your address and we\'ll confirm.'],
            ],
            'related' => ['power-washing', 'residential-window-cleaning', 'gutter-cleaning'],
        ],

        'gutter-cleaning' => [
            'name'  => 'Gutter Cleaning',
            'short' => 'Gutter Cleaning',
            'icon'  => 'gutter',
            'title' => 'Gutter Cleaning in Worcester County, MA | Affordable & Insured | Busy Bee',
            'description' => 'Affordable gutter and downspout cleaning that protects your roof, siding and foundation. Hand-cleaned, flushed and bagged. Free estimates — (508) 499-9193.',
            'h1'    => 'Affordable Gutter Cleaning for a Safe & Protected Home',
            'lead'  => 'Clogged gutters send water where it doesn\'t belong. We clean them out by hand, flush every downspout and haul the mess away.',
            'link_phrases' => ['gutter cleaning', 'clean your gutters', 'gutters cleaned'],
            'body'  => <<<HTML
<p>Your gutters have one job: move rainwater and snowmelt away from your house. When they fill with leaves, pine needles, shingle grit and seedlings, that water spills over the edge — soaking siding, eroding landscaping, and pooling against your foundation. In Massachusetts winters, trapped water also freezes into heavy ice dams that can pull gutters off the fascia and push water under your shingles.</p>
<h2>Our gutter cleaning process</h2>
<p>Busy Bee technicians clean every gutter run by hand, bag the debris, and then flush the gutters and downspouts with water to confirm everything flows freely. If a downspout is packed, we clear it from the top and bottom. Before we leave, we clean up any debris that fell during the job — your yard should look better than when we arrived.</p>
<ul class="checks">
<li>All gutters hand-cleaned and debris bagged and removed</li>
<li>Downspouts flushed and unclogged</li>
<li>Roof edges and valleys cleared of loose debris within reach</li>
<li>Quick inspection for loose hangers, leaks and sagging runs</li>
<li>Before-and-after photos on request</li>
</ul>
<h2>When to schedule gutter cleaning in Massachusetts</h2>
<p>Most homes need gutter cleaning at least twice a year: in late spring after the trees drop their seeds and blossoms, and in late fall after the last leaves come down. Homes surrounded by oak, maple or pine trees often need a third cleaning. Waiting until winter is risky — frozen debris is much harder to remove and ice damage is expensive. See our <a href="/blog/how-often-should-you-clean-your-gutters-in-massachusetts">seasonal gutter guide</a> for a month-by-month breakdown.</p>
<h2>Tired of cleaning gutters every year?</h2>
<p>If your home sits under heavy tree cover, professionally installed gutter guards can dramatically cut down on clogs. We clean your gutters first, then install guards sized to your system so you get years of low-maintenance protection.</p>
HTML,
            'steps' => [
                ['Book online or call', 'Get a fast, free quote based on your home\'s size and roofline.'],
                ['Hand-clean & bag', 'Every gutter run is cleaned by hand and the debris is bagged — not dumped in your yard.'],
                ['Flush downspouts', 'We run water through the system to confirm it drains freely.'],
                ['Inspect & report', 'We point out loose hangers, leaks or damage and quote any repairs up front.'],
            ],
            'faqs' => [
                ['How long does gutter cleaning take?', 'Most single-family homes take one to two hours depending on the size of the house, the roof pitch and how full the gutters are.'],
                ['Do you haul away the debris?', 'Yes. We bag the leaves and gunk from your gutters and take it with us, and we clean up anything that lands on your lawn or driveway.'],
                ['Can you clean gutters on a steep or three-story roof?', 'In most cases, yes. Our team is trained and equipped for taller homes. We\'ll confirm access during your free estimate.'],
            ],
            'related' => ['gutter-guard-installation-and-gutter-cleaning', 'gutter-repair', 'power-washing'],
        ],

        'gutter-guard-installation-and-gutter-cleaning' => [
            'name'  => 'Gutter Guard Installation',
            'short' => 'Gutter Guards',
            'icon'  => 'guard',
            'title' => 'Gutter Guard Installation & Gutter Cleaning Experts | Busy Bee MA',
            'description' => 'Professional gutter guard installation that stops leaf buildup and protects your foundation. We clean your gutters first, then install guards built for New England weather.',
            'h1'    => 'Gutter Guard Installation & Gutter Cleaning Experts',
            'lead'  => 'Stop climbing ladders every fall. Our gutter guards keep leaves out and let water flow — installed by the same crew that cleans your gutters.',
            'link_phrases' => ['gutter guard installation', 'gutter guards', 'gutter guard', 'leaf guards'],
            'body'  => <<<HTML
<p>If your house is surrounded by trees, you already know the cycle: the gutters get cleaned, the leaves fall, and a few weeks later they're overflowing again. Gutter guards break that cycle. A quality guard lets rainwater pour through while blocking leaves, twigs and pine needles from settling in the trough — which means fewer clogs, fewer overflows, and far less time on a ladder.</p>
<h2>Clean first, then protect</h2>
<p>Installing guards over dirty gutters just traps the problem underneath. Every Busy Bee gutter guard installation starts with a full hand-cleaning and downspout flush. We then check that your gutters are properly pitched and securely fastened, make any small adjustments, and fit the guards to your exact gutter size and roofline.</p>
<ul class="checks">
<li>Complete gutter cleaning and downspout flush before installation</li>
<li>Guards sized to your gutters — including 5" and 6" K-style systems</li>
<li>Options for leafy yards, pine needles and heavy seed drop</li>
<li>Secure installation that stands up to snow load and wind</li>
<li>Protects fascia, siding, landscaping and foundation</li>
</ul>
<h2>Are gutter guards worth it?</h2>
<p>For most homes under heavy tree cover, yes. Guards reduce how often you need service, lower the risk of ice dams forming in clogged troughs, and keep pests from nesting in standing water. They're not a "never touch again" product — we still recommend a quick check once a year — but they turn a frustrating chore into routine maintenance. Read more in our post on <a href="/blog/are-gutter-guards-worth-it-in-new-england">whether gutter guards are worth it in New England</a>.</p>
HTML,
            'steps' => [
                ['Inspect', 'We measure your gutters, check the pitch and look at the trees around your home.'],
                ['Clean', 'Full hand-cleaning and downspout flush so nothing is trapped under the guards.'],
                ['Install', 'Guards are cut and fastened to fit your system securely.'],
                ['Test', 'We run water through the system to confirm it drains perfectly.'],
            ],
            'faqs' => [
                ['Will gutter guards work with pine needles?', 'Yes — we recommend fine-mesh guards for homes near pine trees, since needles can slip through standard screens.'],
                ['Do gutter guards cause ice dams?', 'Properly installed guards don\'t cause ice dams. Ice dams come from heat loss through the roof; guards actually help by keeping debris from trapping water in the gutter.'],
                ['Can you install guards on my existing gutters?', 'In most cases, yes. If a section is damaged or pitched incorrectly, we\'ll repair or re-hang it first.'],
            ],
            'related' => ['gutter-cleaning', 'gutter-repair', 'residential-window-cleaning'],
        ],

        'power-washing' => [
            'name'  => 'Power Washing',
            'short' => 'Power Washing',
            'icon'  => 'wash',
            'title' => 'Affordable Power Washing for Home Exteriors in MA | Busy Bee',
            'description' => 'House washing, driveway, deck, patio and fence power washing that removes dirt, mildew and stains safely. Worcester & Middlesex County. Free estimates.',
            'h1'    => 'Affordable Power Washing for Pristine Home Exteriors',
            'lead'  => 'Siding, driveways, decks, patios and fences — we lift away dirt, mildew and stains with the right pressure for every surface.',
            'link_phrases' => ['power washing', 'pressure washing', 'house washing', 'soft washing'],
            'body'  => <<<HTML
<p>New England weather is tough on a home's exterior. Shady north walls grow green algae, vinyl siding picks up black mildew streaks, and driveways collect oil, tire marks and rust. Busy Bee's power washing service restores that just-built look — safely. We match the method to the surface: gentle low-pressure soft washing for siding and roofs, and higher-pressure surface cleaning for concrete and pavers.</p>
<h2>Surfaces we clean</h2>
<ul class="checks">
<li>Vinyl, aluminum, wood and fiber-cement siding</li>
<li>Concrete driveways, walkways and garage floors</li>
<li>Brick and paver patios, pool decks and steps</li>
<li>Wood and composite decks, railings and fences</li>
<li>Commercial sidewalks, entryways and dumpster pads</li>
</ul>
<h2>Soft washing vs. pressure washing</h2>
<p>High pressure isn't always better. Blasting siding or wood at close range can etch surfaces, force water behind panels and strip paint. For siding we use a soft-wash approach — a biodegradable cleaning solution that kills mildew and algae at the root, followed by a low-pressure rinse. Concrete and stone can handle more pressure, so we use a surface cleaner that delivers even, stripe-free results. Learn more in our guide to <a href="/blog/power-washing-vs-soft-washing-what-your-home-needs">power washing vs. soft washing</a>.</p>
<h2>Protecting your plants and property</h2>
<p>Before we start, we pre-wet and cover delicate plantings, close windows and vents, and check for loose siding or damaged trim. When the job is done we rinse everything down so your landscaping stays healthy. Pair your power washing with window cleaning for the ultimate exterior refresh — clean siding makes clean glass look even better.</p>
HTML,
            'steps' => [
                ['Assess surfaces', 'We identify each material and choose soft wash or pressure wash accordingly.'],
                ['Protect', 'Plants are pre-wet and covered; windows, vents and outlets are secured.'],
                ['Wash & treat', 'Dirt, mildew and algae are lifted and treated at the root.'],
                ['Rinse & review', 'Everything is rinsed clean and we walk the property with you.'],
            ],
            'faqs' => [
                ['Is power washing safe for vinyl siding?', 'Yes, when it\'s done correctly. We use low-pressure soft washing on siding to clean thoroughly without damaging panels or forcing water behind them.'],
                ['Will the cleaning solution hurt my plants?', 'We use biodegradable solutions and pre-wet, cover and rinse your landscaping to keep plants safe.'],
                ['How often should I power wash my house?', 'Most homes benefit from a house wash every one to two years; shaded or wooded lots may need it annually.'],
            ],
            'related' => ['residential-window-cleaning', 'gutter-cleaning', 'commercial-window-cleaning'],
        ],

        'screen-cleaning-and-repair' => [
            'name'  => 'Screen Cleaning & Repair',
            'short' => 'Screen Repair',
            'icon'  => 'screen',
            'title' => 'Window Screen Cleaning & Screen Repair in MA | Busy Bee',
            'description' => 'Window screen washing that removes dirt and pollen buildup, plus repairs for worn or torn screens. Add it to any window cleaning. Free estimates.',
            'h1'    => 'Window Screen Cleaning & Screen Repair',
            'lead'  => 'Dirty screens make clean windows look dull. We wash, dry and reinstall them — and fix the ones that are torn or bent.',
            'link_phrases' => ['screen cleaning', 'screen repair', 'window screens'],
            'body'  => <<<HTML
<p>Window screens catch everything the air carries — pollen, dust, road grime, cobwebs and insects. Over time that buildup blocks light and airflow and rubs right back onto your freshly cleaned glass. Busy Bee's screen service removes each screen, washes it by hand with a soft brush, rinses and dries it, and reinstalls it in the right window.</p>
<h2>Screen repair and rescreening</h2>
<p>Pets, kids, storms and time all take a toll on screens. We repair small tears, replace worn screen mesh and spline, straighten frames where possible, and replace missing hardware. Most repairs can be completed on the same visit as your window cleaning, so you're not waiting weeks for a hardware store turnaround.</p>
<ul class="checks">
<li>Hand-washed screens — dirt, pollen and cobwebs removed</li>
<li>Frames wiped and screens reinstalled in the correct windows</li>
<li>Torn or worn mesh replaced with new screen and spline</li>
<li>Bent frames and missing clips fixed where possible</li>
<li>Pet-resistant mesh available on request</li>
</ul>
<h2>Best paired with window cleaning</h2>
<p>Screen cleaning is the perfect add-on to a residential window cleaning. With both glass and screens clean, you'll see a real difference in how much light comes into your home — and the glass stays clean longer.</p>
HTML,
            'steps' => [
                ['Remove', 'We carefully remove and label each screen.'],
                ['Wash', 'Screens are hand-scrubbed, rinsed and dried.'],
                ['Repair', 'Torn mesh and missing hardware are fixed on the spot.'],
                ['Reinstall', 'Every screen goes back in its correct window.'],
            ],
            'faqs' => [
                ['Can you repair screens on the same day as my window cleaning?', 'In most cases, yes. We carry common screen mesh and spline so small repairs can be done on site.'],
                ['Do you replace entire screens?', 'For frames that are badly bent or broken, we can measure and arrange a replacement.'],
            ],
            'related' => ['residential-window-cleaning', 'skylight-and-chandelier-cleaning', 'power-washing'],
        ],

        'gutter-repair' => [
            'name'  => 'Gutter & Downspout Repair',
            'short' => 'Gutter Repair',
            'icon'  => 'wrench',
            'title' => 'Gutter & Downspout Repair in Worcester County, MA | Busy Bee',
            'description' => 'Fix sagging gutters, detached downspouts, leaky seams and bad pitch before they damage your home. Fast, affordable gutter repair from Busy Bee.',
            'h1'    => 'Gutter & Downspout Repairs',
            'lead'  => 'Hanging gutters, detached downspouts and leaky seams — we fix the small problems before they turn into big ones.',
            'link_phrases' => ['gutter repair', 'downspout repair', 'gutter repairs'],
            'body'  => <<<HTML
<p>A gutter system only works if every piece is doing its job. One loose hanger lets a section sag and hold water. One leaky seam drips onto the same spot of your foundation all season. One disconnected downspout dumps hundreds of gallons of water right next to your basement wall during a single storm. Busy Bee finds and fixes these issues quickly and affordably.</p>
<h2>Common gutter repairs we handle</h2>
<ul class="checks">
<li>Re-hanging sagging or pulled-away gutter sections</li>
<li>Replacing loose spikes with hidden hangers</li>
<li>Sealing leaky seams, corners and end caps</li>
<li>Reattaching and securing detached downspouts</li>
<li>Correcting gutter pitch so water drains to the outlet</li>
<li>Adding downspout extensions to move water away from the foundation</li>
</ul>
<h2>Repair or replace?</h2>
<p>Most gutter problems don't require a full replacement. If your gutters are structurally sound, a targeted repair restores full function at a fraction of the cost. We'll always give you an honest assessment — if a section truly needs replacing, we'll tell you why and quote it clearly. Many repair needs are spotted during routine gutter cleaning, which is one more reason to keep your gutters on a regular schedule.</p>
HTML,
            'steps' => [
                ['Diagnose', 'We find the source of leaks, sags or overflows.'],
                ['Quote', 'You get a clear price before any work begins.'],
                ['Repair', 'Hangers, seams, pitch and downspouts fixed properly.'],
                ['Test', 'We run water to make sure everything drains right.'],
            ],
            'faqs' => [
                ['Why are my gutters overflowing even though they\'re clean?', 'Overflowing clean gutters usually mean the pitch is off, a downspout is blocked, or the gutter is undersized for your roof. We can diagnose and fix all three.'],
                ['Do you repair seamless gutters?', 'Yes. We repair seamless aluminum gutters, including resealing corners and end caps and re-hanging sagging runs.'],
            ],
            'related' => ['gutter-cleaning', 'gutter-guard-installation-and-gutter-cleaning', 'power-washing'],
        ],

        'skylight-and-chandelier-cleaning' => [
            'name'  => 'Skylight & Chandelier Cleaning',
            'short' => 'Skylights & Chandeliers',
            'icon'  => 'chandelier',
            'title' => 'Skylight & Chandelier Cleaning in Central MA | Busy Bee',
            'description' => 'Careful skylight cleaning and chandelier cleaning for high ceilings and hard-to-reach glass. Insured, detail-oriented and fully cleaned up after.',
            'h1'    => 'Skylight & Chandelier Cleaning',
            'lead'  => 'High, delicate and hard to reach — the jobs most people put off. We bring the right equipment and a careful touch.',
            'link_phrases' => ['skylight cleaning', 'chandelier cleaning', 'skylights'],
            'body'  => <<<HTML
<p>Skylights and chandeliers are some of the most beautiful features in a home, and some of the hardest to keep clean. Skylights collect pollen, leaves and bird droppings on top and dust on the underside; chandeliers gather a dull film that hides their sparkle. Busy Bee has the ladders, extension tools and experience to clean both safely.</p>
<h2>Skylight cleaning</h2>
<p>We clean the exterior of your skylight from the roof when it's safe to access, clear debris from the flashing area, and clean the interior glass and frame from inside. While we're up there, we look for cracked seals or debris that could lead to leaks.</p>
<h2>Chandelier cleaning</h2>
<p>For chandeliers, we protect the floor and furniture beneath, then hand-clean crystals, arms and bulbs using a gentle, residue-free solution. Crystals are carefully wiped or removed and replaced in their exact positions. The result is a fixture that throws light the way it was designed to.</p>
<ul class="checks">
<li>Interior and exterior skylight glass and frames</li>
<li>Debris cleared from around skylight flashing</li>
<li>Crystal, glass and metal chandeliers hand-detailed</li>
<li>High foyer and cathedral-ceiling fixtures</li>
<li>Floors and furniture protected throughout</li>
</ul>
HTML,
            'steps' => [
                ['Protect', 'Drop cloths and padding go down under the work area.'],
                ['Access safely', 'We set up the right ladder or staging for your ceiling height.'],
                ['Hand-clean', 'Glass and crystals are cleaned by hand, piece by piece.'],
                ['Final polish', 'We polish, check the result with you and clean up.'],
            ],
            'faqs' => [
                ['How high of a ceiling can you reach?', 'We regularly clean fixtures in two-story foyers and cathedral ceilings. Let us know your ceiling height when you request an estimate.'],
                ['Can you add skylight cleaning to a window cleaning?', 'Yes — most customers add skylights to their regular window cleaning visit.'],
            ],
            'related' => ['residential-window-cleaning', 'screen-cleaning-and-repair', 'commercial-window-cleaning'],
        ],
    ];
}

function counties(): array
{
    return [
        'worcester-county-massachusetts' => [
            'name' => 'Worcester',
            'title' => 'Window & Gutter Cleaning in Worcester County, MA | Busy Bee',
            'description' => 'Busy Bee is based in Northborough and serves all of Worcester County, MA with window cleaning, gutter cleaning, gutter guards and power washing.',
            'intro' => 'Worcester County is home base for Busy Bee. Our shop is in Northborough, right in the middle of the county, so we can reach Worcester, the Route 9 corridor, North County and the Blackstone Valley quickly — often within the same week you call.',
            'body' => 'From triple-deckers in Worcester to colonials in Shrewsbury and farmhouses out in Boylston and Holden, homes across the county face the same challenges: tall hardwoods that fill gutters every fall, long winters that leave salt film on glass, and humid summers that grow mildew on shaded siding. We know these homes, and we built our services around them.',
            'towns' => ['worcester', 'shrewsbury', 'northborough', 'westborough', 'southborough', 'boylston', 'grafton', 'holden', 'auburn', 'milford', 'webster', 'fitchburg', 'leominster', 'gardner'],
        ],
        'middlesex-county-massachusetts' => [
            'name' => 'Middlesex',
            'title' => 'Window & Gutter Cleaning in Middlesex County, MA | Busy Bee',
            'description' => 'Professional window cleaning, gutter cleaning and power washing for homes and businesses in Framingham, Marlborough, Hudson, Natick and across Middlesex County, MA.',
            'intro' => 'Just over the line from our Northborough base, the MetroWest side of Middlesex County is one of our busiest service areas. We make regular runs to Marlborough, Hudson, Framingham and Natick for homeowners, property managers and storefronts.',
            'body' => 'MetroWest neighborhoods are full of mature trees and larger homes with lots of glass — a combination that keeps gutters full and windows hard to reach. Our crews handle multi-story window cleaning, heavy leaf-season gutter cleaning and full house washes without you ever needing to pull out a ladder.',
            'towns' => ['framingham', 'marlborough', 'hudson', 'natick'],
        ],
        'norfolk-county-massachusetts' => [
            'name' => 'Norfolk',
            'title' => 'Window & Gutter Cleaning in Norfolk County, MA | Busy Bee',
            'description' => 'Professional exterior cleaning for homes and businesses across Norfolk County, MA — serving Quincy, Brookline, Wellesley, Dedham and surrounding towns.',
            'intro' => 'Busy Bee brings the same five-star window cleaning, gutter cleaning and power washing to Norfolk County. We schedule regular service days in Quincy, Brookline, Wellesley, Dedham and the surrounding towns.',
            'body' => 'Norfolk County homes range from historic Victorians with dozens of divided-light windows to modern builds with walls of glass. Older homes often have original gutters and downspouts that need a careful hand, and coastal-leaning towns see extra grime on glass and siding. We take our time and do it right.',
            'towns' => ['quincy', 'brookline', 'wellesley', 'dedham'],
        ],
    ];
}

/**
 * Town pages. Slug pattern mirrors the existing busybeewg.com URLs:
 * {town}-{county}-county-ma-window-cleaning
 */
function towns(): array
{
    $t = [
        'worcester'    => ['Worcester', 'worcester', 'As the second-largest city in New England, Worcester has everything from three-deckers on the East Side to large homes near Tatnuck and Salisbury Street. City grime and tree-lined streets mean windows and gutters here work hard, and our Northborough crew is only a short drive down Route 9 or I-290.', ['shrewsbury', 'holden', 'auburn', 'boylston']],
        'shrewsbury'   => ['Shrewsbury', 'worcester', 'Shrewsbury sits on the shore of Lake Quinsigamond, and homes near the water deal with extra moisture, pollen and mildew. We keep Shrewsbury windows streak-free, gutters flowing and siding clean — from the lake neighborhoods to the newer developments off Route 20.', ['worcester', 'northborough', 'westborough', 'boylston', 'grafton']],
        'northborough' => ['Northborough', 'worcester', 'Northborough is our hometown — our shop is on West Main Street. That means fast scheduling, quick response when a storm clogs your gutters, and a crew that takes pride in keeping our own neighbors\' homes looking their best.', ['westborough', 'shrewsbury', 'southborough', 'boylston', 'marlborough']],
        'westborough'  => ['Westborough', 'worcester', 'Where Route 9 meets I-495, Westborough mixes established neighborhoods with office parks and businesses. We handle both — residential window and gutter cleaning for homeowners, and scheduled storefront and commercial window cleaning for local businesses.', ['northborough', 'shrewsbury', 'southborough', 'grafton', 'milford']],
        'southborough' => ['Southborough', 'worcester', 'Southborough\'s wooded lots and larger homes mean plenty of glass and plenty of leaves. Our team is equipped for tall windows, long gutter runs and full-exterior power washing on bigger properties.', ['northborough', 'westborough', 'framingham', 'marlborough']],
        'boylston'     => ['Boylston', 'worcester', 'Surrounded by the Wachusett Reservoir watershed and heavy tree cover, Boylston homes see some of the fastest gutter fill in the area. Many Boylston homeowners pair seasonal gutter cleaning with gutter guard installation to cut down on clogs.', ['northborough', 'shrewsbury', 'holden', 'worcester']],
        'grafton'      => ['Grafton', 'worcester', 'From the historic homes around Grafton Common to newer neighborhoods off Route 140, Grafton properties get the full Busy Bee treatment: careful hand-washed windows, clean-flowing gutters and gentle soft washing for older siding.', ['shrewsbury', 'westborough', 'auburn', 'milford']],
        'holden'       => ['Holden', 'worcester', 'Holden\'s hilly, heavily wooded neighborhoods are beautiful — and hard on gutters. Oaks and pines drop debris year-round, so we recommend at least two gutter cleanings per year and fine-mesh guards for homes under pines.', ['worcester', 'boylston', 'leominster', 'fitchburg']],
        'auburn'       => ['Auburn', 'worcester', 'Sitting at the crossroads of I-290, I-90 and Route 20, Auburn homes and businesses pick up extra road film on glass and siding. Our window cleaning and power washing services wash it all away and leave a streak-free shine.', ['worcester', 'grafton', 'webster']],
        'milford'      => ['Milford', 'worcester', 'Milford\'s mix of busy downtown storefronts and residential neighborhoods keeps our crews busy along the Route 16 and I-495 corridor. We offer recurring commercial window cleaning and full residential exterior cleaning.', ['westborough', 'grafton', 'framingham']],
        'webster'      => ['Webster', 'worcester', 'Homes around Webster Lake face extra moisture and pollen that leave windows spotty and siding green. We clean lakefront glass carefully and soft wash siding to remove mildew and algae without damage.', ['auburn', 'grafton']],
        'fitchburg'    => ['Fitchburg', 'worcester', 'Fitchburg\'s hills and older multi-story homes can make window and gutter cleaning a real challenge. Our trained, insured team safely handles steep lots, tall houses and multi-family properties in North County.', ['leominster', 'gardner', 'holden']],
        'leominster'   => ['Leominster', 'worcester', 'Known as the Pioneer Plastics City, Leominster has a great mix of residential neighborhoods and local businesses. We provide residential window cleaning, gutter cleaning and commercial storefront service across the city.', ['fitchburg', 'holden', 'gardner']],
        'gardner'      => ['Gardner', 'worcester', 'The Chair City sits high in North County, where winter lasts a little longer. Clean, well-draining gutters are essential here to prevent ice dams, and we help Gardner homeowners get ready well before the first freeze.', ['fitchburg', 'leominster']],
        'framingham'   => ['Framingham', 'middlesex', 'Framingham is one of the largest communities in MetroWest, with everything from downtown businesses to quiet neighborhoods around Lake Cochituate and Nobscot. We offer residential and commercial window cleaning, gutter cleaning and power washing across the city.', ['natick', 'marlborough', 'southborough', 'hudson']],
        'marlborough'  => ['Marlborough', 'middlesex', 'Right next door to Northborough, Marlborough is a quick trip for our crew. Along Route 20 and I-495 we clean storefronts and offices, and in the neighborhoods we keep homeowners\' windows, screens and gutters in top shape.', ['northborough', 'hudson', 'southborough', 'framingham']],
        'hudson'       => ['Hudson', 'middlesex', 'Hudson\'s revitalized downtown along the Assabet River is full of restaurants and shops that depend on clean storefront glass. We also serve Hudson homeowners with seasonal gutter cleaning and full exterior washing.', ['marlborough', 'northborough', 'framingham']],
        'natick'       => ['Natick', 'middlesex', 'From the neighborhoods near Lake Cochituate to the homes around Natick Center, Natick properties feature lots of mature trees and larger windows. We keep both clean, with multi-story window cleaning and leaf-season gutter service.', ['framingham', 'wellesley', 'hudson']],
        'quincy'       => ['Quincy', 'norfolk', 'The City of Presidents sits right on the coast, where salt air leaves a hazy film on glass and siding. Regular window cleaning and gentle soft washing keep Quincy homes and businesses looking sharp.', ['dedham', 'brookline']],
        'brookline'    => ['Brookline', 'norfolk', 'Brookline is full of historic homes with divided-light windows, ornate trim and original gutters. We take extra care with older glass and delicate details, and we clean up thoroughly on every job.', ['wellesley', 'dedham', 'quincy']],
        'wellesley'    => ['Wellesley', 'norfolk', 'Wellesley\'s large homes and tree-lined streets call for a detail-oriented crew. We handle multi-story window cleaning, skylights and chandeliers, and heavy-leaf gutter cleaning with care.', ['natick', 'brookline', 'dedham']],
        'dedham'       => ['Dedham', 'norfolk', 'As the Norfolk County seat, Dedham blends historic neighborhoods with busy commercial corridors. We serve both — residential window and gutter cleaning, and recurring storefront window cleaning for local businesses.', ['wellesley', 'brookline', 'quincy']],
    ];
    $out = [];
    foreach ($t as $key => [$name, $county, $blurb, $near]) {
        $slug = $key . '-' . $county . '-county-ma-window-cleaning';
        $out[$slug] = [
            'key' => $key,
            'name' => $name,
            'county' => $county,
            'county_slug' => $county . '-county-massachusetts',
            'blurb' => $blurb,
            'nearby' => $near,
        ];
    }
    return $out;
}

function town_slug(string $key): ?string
{
    foreach (towns() as $slug => $t) {
        if ($t['key'] === $key) {
            return $slug;
        }
    }
    return null;
}

function blog_posts(): array
{
    return [
        'busy-bee-s-seasonal-gutter-cleaning-guide-a-homeowner-s-must-read' => [
            'title' => "Busy Bee's Seasonal Gutter Cleaning Guide: A Homeowner's Must-Read",
            'description' => 'A season-by-season guide to gutter cleaning in Massachusetts: what to check in spring, summer, fall and winter to protect your roof and foundation.',
            'date' => '2025-09-15',
            'category' => 'Gutter Cleaning',
            'excerpt' => 'Gutters need different attention in every season. Here\'s what Massachusetts homeowners should look for — and when to call in a pro.',
            'body' => <<<HTML
<p>Gutters are easy to forget about until something goes wrong: water pouring over the edge during a storm, a stain spreading across the siding, or a wet corner in the basement. The good news is that a simple seasonal routine prevents almost all of it. Here's the approach we recommend to homeowners across Worcester County.</p>
<h2>Spring: clear the winter mess</h2>
<p>Winter leaves behind shingle grit, broken twigs and whatever the last fall cleaning missed. As trees bud, maple "helicopters" and oak tassels pile in fast. Schedule a spring gutter cleaning once the heavy seed drop is over, and check for damage from snow and ice — loose hangers, separated seams and bent downspouts.</p>
<h2>Summer: watch for overflow</h2>
<p>Summer thunderstorms dump a lot of water quickly. Walk around your home during a heavy rain: if water sheets over the edge of a gutter, there's a clog or a pitch problem. Summer is also a great time for power washing to remove the black streaks that overflowing gutters leave on siding.</p>
<h2>Fall: the most important cleaning of the year</h2>
<p>Late fall — after most of the leaves are down but before the first hard freeze — is the single most important time to clean your gutters in Massachusetts. Wet leaves that sit in gutters over winter freeze solid, block drainage and help ice dams form. If your home sits under heavy tree cover, consider gutter guards to cut down on the fall rush.</p>
<h2>Winter: prevent ice dams</h2>
<p>Don't climb a ladder in icy weather. Instead, keep an eye out for large icicles and ice buildup along the roof edge, which signal trapped water. Make sure downspout outlets aren't buried in snow so meltwater has somewhere to go.</p>
<h2>When to call a professional</h2>
<p>If your home is two or more stories, has a steep roof, or you simply don't want to spend a Saturday on a ladder, a professional gutter cleaning is fast, affordable and much safer. Busy Bee hand-cleans every run, flushes downspouts and hauls the debris away.</p>
HTML,
        ],
        'how-often-should-you-clean-your-gutters-in-massachusetts' => [
            'title' => 'How Often Should You Clean Your Gutters in Massachusetts?',
            'description' => 'Most Massachusetts homes need gutter cleaning at least twice a year. Learn how trees, roof type and weather change the schedule for your home.',
            'date' => '2025-10-02',
            'category' => 'Gutter Cleaning',
            'excerpt' => 'Twice a year is the baseline — but the trees around your house, your roof and our New England weather can change the math.',
            'body' => <<<HTML
<p>It's one of the most common questions we hear: <em>how often do I really need to clean my gutters?</em> For most homes in Central Massachusetts, the answer is at least twice a year. But the right schedule depends on a few factors.</p>
<h2>The baseline: spring and fall</h2>
<p>A late-spring cleaning clears out seeds, blossoms and winter debris. A late-fall cleaning, after the leaves drop, gets your gutters ready to handle snowmelt without freezing into ice dams. That's the minimum for a typical suburban lot.</p>
<h2>Homes with heavy tree cover: three to four times</h2>
<p>If your house sits under oaks, maples or pines, gutters can fill in a matter of weeks. Pine needles are especially tricky because they mat together and slip past basic screens. For these homes we recommend three or four cleanings a year, or professional gutter guard installation to reduce the workload.</p>
<h2>Signs you're overdue</h2>
<ul class="checks">
<li>Water spilling over the gutter edge during rain</li>
<li>Plants or seedlings growing in the gutters</li>
<li>Gutters sagging or pulling away from the fascia</li>
<li>Stains or streaks on siding beneath the gutters</li>
<li>Pooling water or erosion near your foundation</li>
</ul>
<h2>Month-by-month quick guide</h2>
<p><strong>April–June:</strong> spring cleaning after seed drop. <strong>July–August:</strong> check for overflow during storms. <strong>October–December:</strong> fall cleaning after the leaves are down. <strong>January–March:</strong> keep downspout outlets clear of snow and watch for ice dams.</p>
<p>Not sure where your home falls? Busy Bee offers free estimates and can recommend a schedule based on your roof and the trees around it.</p>
HTML,
        ],
        'are-gutter-guards-worth-it-in-new-england' => [
            'title' => 'Are Gutter Guards Worth It in New England?',
            'description' => 'Gutter guards can dramatically reduce clogs for homes under heavy tree cover. Here\'s an honest look at the pros, cons and which homes benefit most.',
            'date' => '2025-11-05',
            'category' => 'Gutter Guards',
            'excerpt' => 'An honest look at what gutter guards can and can\'t do — and which Massachusetts homes benefit the most.',
            'body' => <<<HTML
<p>Gutter guards are one of the most-asked-about upgrades we install. They can be a great investment — but they aren't magic. Here's our honest take.</p>
<h2>What gutter guards do well</h2>
<p>A good guard keeps leaves, twigs and most debris out of the gutter trough while letting water flow through. That means fewer clogs, fewer overflows, less weight on your gutters, and less standing water for mosquitoes and pests.</p>
<h2>What they don't do</h2>
<p>Guards don't eliminate maintenance entirely. Fine debris and shingle grit can still collect over time, and leaves can sit on top of some styles until wind or rain clears them. We recommend a quick inspection and rinse about once a year.</p>
<h2>Which homes benefit most?</h2>
<ul class="checks">
<li>Homes under oak, maple or pine trees</li>
<li>Two- and three-story homes where ladder work is risky</li>
<li>Homes that have had ice-dam or overflow problems</li>
<li>Owners who want to reduce annual cleaning visits</li>
</ul>
<h2>Our approach</h2>
<p>Every Busy Bee gutter guard installation starts with a full gutter cleaning and a check of the pitch and hangers — because guards on top of a clogged or sagging gutter just hide the problem. Then we fit guards to your system and test the flow.</p>
HTML,
        ],
        'power-washing-vs-soft-washing-what-your-home-needs' => [
            'title' => 'Power Washing vs. Soft Washing: What Does Your Home Need?',
            'description' => 'Power washing and soft washing are not the same. Learn which method is right for siding, roofs, decks and driveways — and why it matters.',
            'date' => '2026-04-10',
            'category' => 'Power Washing',
            'excerpt' => 'More pressure isn\'t always better. Here\'s how we decide between power washing and soft washing for every surface of your home.',
            'body' => <<<HTML
<p>When most people think about cleaning a house exterior, they picture a high-pressure wand blasting away dirt. That works great on concrete — but on siding, roofs and painted wood, it can do real damage. That's why professionals use two different methods.</p>
<h2>Power washing</h2>
<p>Power washing uses high-pressure water to physically remove dirt, grime, oil and stains. It's ideal for hard, durable surfaces like concrete driveways, sidewalks, brick and stone patios. We use a rotary surface cleaner on flat areas for even, stripe-free results.</p>
<h2>Soft washing</h2>
<p>Soft washing uses low pressure — similar to a garden hose — combined with a biodegradable cleaning solution that kills mold, mildew and algae at the root. It's the right choice for vinyl siding, painted surfaces, stucco and roofs. Because it treats the growth rather than just blasting it off, results last longer.</p>
<h2>Which surfaces get which method?</h2>
<ul class="checks">
<li><strong>Soft wash:</strong> vinyl and painted siding, roofs, stucco, painted trim</li>
<li><strong>Power wash:</strong> concrete, pavers, brick and stone</li>
<li><strong>Either, carefully:</strong> wood decks and fences (lower pressure, proper tip and distance)</li>
</ul>
<p>Busy Bee evaluates every surface before we start, so your home gets a thorough clean without the risk of etching, stripping or water intrusion.</p>
HTML,
        ],
        'how-to-keep-your-windows-streak-free-between-cleanings' => [
            'title' => 'How to Keep Your Windows Streak-Free Between Professional Cleanings',
            'description' => 'Simple tips to keep windows clearer for longer between professional window cleanings — from microfiber tricks to managing screens and sprinklers.',
            'date' => '2026-05-20',
            'category' => 'Window Cleaning',
            'excerpt' => 'A few easy habits help your windows stay clear longer after a professional cleaning.',
            'body' => <<<HTML
<p>A professional window cleaning leaves your glass spotless — and with a few simple habits, you can keep it looking that way longer.</p>
<h2>Spot-clean with microfiber, not paper towels</h2>
<p>Paper towels leave lint and push dirt around. A clean, dry microfiber cloth removes fingerprints and smudges on interior glass without streaking. For stubborn spots, lightly dampen the cloth with plain water.</p>
<h2>Keep screens clean</h2>
<p>Dirty screens shed dust back onto the glass every time the wind blows. Having your screens washed with your windows — or rinsing them gently once a season — helps glass stay clean.</p>
<h2>Adjust your sprinklers</h2>
<p>Irrigation water is full of minerals that leave hard-water spots as they dry. Point sprinkler heads away from windows to avoid spotting that's hard to remove.</p>
<h2>Keep gutters flowing</h2>
<p>Overflowing gutters drip dirty water down your siding and windows. Clean gutters mean cleaner glass.</p>
<h2>Stick to a schedule</h2>
<p>Most homes look their best with a professional cleaning in spring and fall. Regular service also makes each cleaning faster and helps protect glass from long-term etching.</p>
HTML,
        ],
    ];
}

function general_faqs(): array
{
    return [
        ['What areas does Busy Bee serve?', 'We are based in Northborough, MA and serve Worcester County, Middlesex County and Norfolk County — including Worcester, Shrewsbury, Westborough, Marlborough, Framingham, Hudson, Leominster, Fitchburg, Holden, Milford and many more towns.'],
        ['Are estimates really free?', 'Yes. Estimates are always free with no pressure and no obligation. Call, text or fill out our online form and we\'ll get back to you quickly.'],
        ['Are you insured?', 'Yes. Busy Bee is fully insured for residential and commercial work. Certificates of insurance are available on request.'],
        ['Do I have to sign a contract?', 'No. We don\'t require contracts. Many customers choose recurring service because it\'s convenient, but you can book one-time cleanings anytime.'],
        ['What if I\'m not happy with the results?', 'Your satisfaction is 100% guaranteed. If something isn\'t right, let us know and we\'ll come back and make it right at no cost.'],
        ['What are your hours?', 'We\'re available Monday through Friday, 7:00 AM to 7:00 PM. Call (508) 499-9193 or send us a message any time.'],
        ['Can I bundle services?', 'Yes. Many customers bundle window cleaning, gutter cleaning and power washing into one visit to save time and get the whole exterior done at once.'],
    ];
}

/** Top-level navigation. */
function nav_items(): array
{
    $services = [];
    foreach (services() as $slug => $s) {
        if (page_enabled($slug)) {
            $services['/' . $slug] = $s['name'];
        }
    }
    $areas = [];
    foreach (counties() as $slug => $c) {
        if (page_enabled($slug)) {
            $areas['/' . $slug] = $c['name'] . ' County';
        }
    }
    $areas['/service-areas'] = 'All Service Areas';
    $items = [
        ['/', 'Home', []],
        ['/services', 'Services', $services],
        ['/service-areas', 'Service Areas', $areas],
        ['/about', 'About', []],
        ['/reviews', 'Reviews', []],
        ['/blog', 'Blog', []],
        ['/faq', 'FAQ', []],
        ['/contact', 'Contact', []],
    ];
    return array_values(array_filter($items, fn($i) => $i[0] === '/' || page_enabled(ltrim($i[0], '/'))));
}

/** Every public page with a label, used for sitemap + admin page manager. */
function all_pages(): array
{
    $p = [
        'home' => ['/', 'Home', 'core'],
        'services' => ['/services', 'Services', 'core'],
        'service-areas' => ['/service-areas', 'Service Areas', 'core'],
        'about' => ['/about', 'About', 'core'],
        'reviews' => ['/reviews', 'Reviews', 'core'],
        'contact' => ['/contact', 'Contact', 'core'],
        'blog' => ['/blog', 'Blog', 'core'],
        'faq' => ['/faq', 'FAQ', 'core'],
        'free-estimate' => ['/free-estimate', 'Free Estimate', 'core'],
        'privacy-policy' => ['/privacy-policy', 'Privacy Policy', 'core'],
    ];
    foreach (services() as $slug => $s) {
        $p[$slug] = ['/' . $slug, $s['name'], 'service'];
    }
    foreach (counties() as $slug => $c) {
        $p[$slug] = ['/' . $slug, $c['name'] . ' County', 'county'];
    }
    foreach (towns() as $slug => $t) {
        $p[$slug] = ['/' . $slug, $t['name'] . ', MA', 'town'];
    }
    foreach (blog_posts() as $slug => $b) {
        $p['blog/' . $slug] = ['/blog/' . $slug, $b['title'], 'blog'];
    }
    return $p;
}
