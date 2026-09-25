<?php

// Prose/content fields below are locale-keyed (['en' => ...]) and resolved at render time via the
// travel_t() / travel_label() helpers (app/helpers.php). Write English only: the Translator page in
// the admin panel translates it into the other locales and saves them in the translations table.
// An inline value such as 'hi' => '...' overrides the saved translation for that one field.
// Proper nouns (brand name, staff names, official body names, address, email) and
// stable filter keys ('theme', 'kind' values) are intentionally left as plain strings —
// see config/laravellocalization.php and PackageController/DestinationController for why.

return [

    'brand' => [
        'name' => 'Nio Travel and Tours',
        'legal_name' => 'Nio Travel and Tours (Pvt) Ltd',
        'tagline' => [
            'en' => 'Sri Lanka, arranged properly.',
        ],
        'logo' => 'images/logo/nio-logo.png',
        'email' => 'hello@niotravels.lk',
        'address' => "No. 42, Galle Road\nColombo 03, Sri Lanka",
        'hours' => [
            'en' => 'Mon – Sat, 08:30 – 19:00 IST. Sunday: WhatsApp only.',
        ],
        'founded_copy' => [
            'en' => 'We started in 2011 with one van and a Colombo phone number. Today we run inbound tours across every province of Sri Lanka with our own guides and vehicles, and we book outbound holidays for the same travellers, mostly families, couples and groups from India who want one company answerable for the whole trip.',
        ],
        'whatsapp_message' => [
            'en' => 'Hello Nio Travel and Tours, I would like to plan a trip.',
        ],
    ],

    // Floating WhatsApp widget desks
    'contacts' => [
        ['name' => 'Nadeesha Perera', 'role' => ['en' => 'Reservations'], 'country' => ['en' => 'Sri Lanka'], 'cc' => 'LK', 'number' => '+94 77 000 0000'],
        ['name' => 'Dilani Jayawardena', 'role' => ['en' => 'Groups & MICE'], 'country' => ['en' => 'Sri Lanka'], 'cc' => 'LK', 'number' => '+94 76 000 0000'],
        ['name' => 'Ramesh Krishnan', 'role' => ['en' => 'India desk'], 'country' => ['en' => 'India'], 'cc' => 'IN', 'number' => '+91 00000 00000'],
    ],

    // Stable filter keys — used in URLs and filtering logic (PackageController, HomeController). Do not translate in place.
    'themes' => [
        'Honeymoon', 'Wildlife', 'Reef & diving', 'Culture & heritage',
        'Beach', 'Adventure', 'Pilgrimage', 'City break',
    ],

    // Display labels for the stable theme keys above, resolved via travel_label().
    'theme_labels' => [
        'Honeymoon' => ['en' => 'Honeymoon'],
        'Wildlife' => ['en' => 'Wildlife'],
        'Reef & diving' => ['en' => 'Reef & diving'],
        'Culture & heritage' => ['en' => 'Culture & heritage'],
        'Beach' => ['en' => 'Beach'],
        'Adventure' => ['en' => 'Adventure'],
        'Pilgrimage' => ['en' => 'Pilgrimage'],
        'City break' => ['en' => 'City break'],
    ],

    // Display labels for the stable 'kind' key used across packages/destinations filters.
    'kind_labels' => [
        'Inbound' => ['en' => 'Inbound'],
        'Outbound' => ['en' => 'Outbound'],
    ],

    // Display labels for the package-list duration filter chips.
    'duration_labels' => [
        'All' => ['en' => 'All'],
        '3–4' => ['en' => '3–4'],
        '5–6' => ['en' => '5–6'],
        '7+' => ['en' => '7+'],
    ],

    // Display labels for destination-card tags. Keys are the stable strings stored in each destination's 'tags' array.
    'tag_labels' => [
        'City' => ['en' => 'City'],
        'Food' => ['en' => 'Food'],
        'Shopping' => ['en' => 'Shopping'],
        'Culture' => ['en' => 'Culture'],
        'Train' => ['en' => 'Train'],
        'Tea' => ['en' => 'Tea'],
        'Wildlife' => ['en' => 'Wildlife'],
        'Safari' => ['en' => 'Safari'],
        'Beach' => ['en' => 'Beach'],
        'Honeymoon' => ['en' => 'Honeymoon'],
        'Whales' => ['en' => 'Whales'],
        'Reef' => ['en' => 'Reef'],
        'Diving' => ['en' => 'Diving'],
        'Heritage' => ['en' => 'Heritage'],
        'UNESCO' => ['en' => 'UNESCO'],
        'Family' => ['en' => 'Family'],
        'Desert' => ['en' => 'Desert'],
        'Mountains' => ['en' => 'Mountains'],
        'Pilgrimage' => ['en' => 'Pilgrimage'],
    ],

    // Display labels for the destination-card country caption.
    'country_labels' => [
        'Sri Lanka' => ['en' => 'Sri Lanka'],
        'Maldives' => ['en' => 'Maldives'],
        'Thailand' => ['en' => 'Thailand'],
        'Singapore' => ['en' => 'Singapore'],
        'UAE' => ['en' => 'UAE'],
        'Nepal' => ['en' => 'Nepal'],
        'Vietnam' => ['en' => 'Vietnam'],
    ],

    'theme_images' => [
        'Honeymoon' => 'nioth-honey',
        'Wildlife' => 'nioth-wild',
        'Reef & diving' => 'nioth-reef',
        'Culture & heritage' => 'nioth-cult',
        'Beach' => 'nioth-beach',
        'Adventure' => 'nioth-adv',
        'Pilgrimage' => 'nioth-pilg',
        'City break' => 'nioth-city',
    ],

    // Image-search keywords for the theme cards on the home page, so each
    // placeholder photo actually resembles the theme instead of being random.
    'theme_photo_keywords' => [
        'Honeymoon' => 'honeymoon,tropical,beach',
        'Wildlife' => 'safari,leopard,wildlife',
        'Reef & diving' => 'coral,scuba diving',
        'Culture & heritage' => 'heritage,carving',
        'Beach' => 'tropical,beach',
        'Adventure' => 'jungle,rainforest',
        'Pilgrimage' => 'temple,pilgrimage',
        'City break' => 'city,skyline',
    ],

    // Real, freely-licensed photos (Wikimedia Commons) matched to the places/
    // themes used across the site, resolved via travel_img()'s keyword lookup
    // in app/helpers.php. Keys are matched as substrings against the keyword
    // string passed at each call site — longest key wins on overlap. Falls
    // back to a random placeholder (picsum) for anything not listed here.
    'stock_photos' => [
        'colombo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/07/Colombo_Skyline_Jan_2022.jpg/1920px-Colombo_Skyline_Jan_2022.jpg',
        'kandy' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/SL_Kandy_asv2020-01_img34_Sacred_Tooth_Temple.jpg/1920px-SL_Kandy_asv2020-01_img34_Sacred_Tooth_Temple.jpg',
        'yala' => 'https://upload.wikimedia.org/wikipedia/commons/6/60/Leopard_in_Yala_National_Park.jpg',
        'galle' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/ff/Dutch_Galle_Fort%2C_Sri_Lanka.jpg/1920px-Dutch_Galle_Fort%2C_Sri_Lanka.jpg',
        'trincomalee' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Main_Rock_in_Pigeon_Island_National_Park.jpg/1920px-Main_Rock_in_Pigeon_Island_National_Park.jpg',
        'sigiriya' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Sigiriya%2C_Rock_Fortress.jpg/1920px-Sigiriya%2C_Rock_Fortress.jpg',
        'cultural triangle' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Sigiriya%2C_Rock_Fortress.jpg/1920px-Sigiriya%2C_Rock_Fortress.jpg',
        'maldives' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/82/MaldivesBungalows.jpg/1920px-MaldivesBungalows.jpg',
        'male' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/82/MaldivesBungalows.jpg/1920px-MaldivesBungalows.jpg',
        'atoll' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/82/MaldivesBungalows.jpg/1920px-MaldivesBungalows.jpg',
        'thailand' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/Temple_of_the_Emerald_Buddha.jpg/1920px-Temple_of_the_Emerald_Buddha.jpg',
        'bangkok' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/Temple_of_the_Emerald_Buddha.jpg/1920px-Temple_of_the_Emerald_Buddha.jpg',
        'singapore' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/ArtScience_Museum%2C_Marina_Bay_Sands%2C_Singapore.jpg/1920px-ArtScience_Museum%2C_Marina_Bay_Sands%2C_Singapore.jpg',
        'city' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/ArtScience_Museum%2C_Marina_Bay_Sands%2C_Singapore.jpg/1920px-ArtScience_Museum%2C_Marina_Bay_Sands%2C_Singapore.jpg',
        'dubai' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/75/Burj_Khalifa_Dubai%2C_UAE_at_Sunset_001_by_Eric_Chamchoum.jpg/1920px-Burj_Khalifa_Dubai%2C_UAE_at_Sunset_001_by_Eric_Chamchoum.jpg',
        'nepal' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c4/Kathmandu_Durbar_Square%2C_Shiva_Parvati_Temple%2C_Nepal_%28edit%29.jpg/1920px-Kathmandu_Durbar_Square%2C_Shiva_Parvati_Temple%2C_Nepal_%28edit%29.jpg',
        'vietnam' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/75/Constellation_of_Literature_pavilion%2C_Temple_of_Literature%2C_Hanoi%2C_Vietnam%2C_20240123_0939_3103.jpg/1920px-Constellation_of_Literature_pavilion%2C_Temple_of_Literature%2C_Hanoi%2C_Vietnam%2C_20240123_0939_3103.jpg',
        'nuwara eliya' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b3/Sri_Lanka%2C_Tea_plantations%2C_Nuwara_Eliya%2C_Picking_tea_leaves.jpg/1920px-Sri_Lanka%2C_Tea_plantations%2C_Nuwara_Eliya%2C_Picking_tea_leaves.jpg',
        'ella' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/70/Nine-Arch_Bridge_in_Sri_Lanka.jpg/1920px-Nine-Arch_Bridge_in_Sri_Lanka.jpg',
        'hill country' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/70/Nine-Arch_Bridge_in_Sri_Lanka.jpg/1920px-Nine-Arch_Bridge_in_Sri_Lanka.jpg',
        'bentota' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1d/Bentota_beach_in_evening.jpg/1920px-Bentota_beach_in_evening.jpg',
        'minneriya' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/85/Elephants_gather_for_water_in_the_plains_at_Minneriya_National_Park_in_Sri_Lanka._It_is_one_of_the_largest_gathering_of_-_Flickr_-_Al_Jazeera_English.jpg/1920px-Elephants_gather_for_water_in_the_plains_at_Minneriya_National_Park_in_Sri_Lanka._It_is_one_of_the_largest_gathering_of_-_Flickr_-_Al_Jazeera_English.jpg',
        'habarana' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/85/Elephants_gather_for_water_in_the_plains_at_Minneriya_National_Park_in_Sri_Lanka._It_is_one_of_the_largest_gathering_of_-_Flickr_-_Al_Jazeera_English.jpg/1920px-Elephants_gather_for_water_in_the_plains_at_Minneriya_National_Park_in_Sri_Lanka._It_is_one_of_the_largest_gathering_of_-_Flickr_-_Al_Jazeera_English.jpg',
        'knuckles' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Knuckles_Mountain_Range_5.jpg/1920px-Knuckles_Mountain_Range_5.jpg',
        'chilaw' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/Chilaw_Sand_Spits%2C_Sri_Lanka.jpg/1920px-Chilaw_Sand_Spits%2C_Sri_Lanka.jpg',
        'coast' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1d/Bentota_beach_in_evening.jpg/1920px-Bentota_beach_in_evening.jpg',
        'landscape' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e8/Ella_-_Sri_lanka_-_Flickr_-_Damith_Danthanarayana_Photography.jpg/1920px-Ella_-_Sri_lanka_-_Flickr_-_Damith_Danthanarayana_Photography.jpg',
        'camera' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/70/Nine-Arch_Bridge_in_Sri_Lanka.jpg/1920px-Nine-Arch_Bridge_in_Sri_Lanka.jpg',
        'honeymoon' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d5/Koh_Mak_%28island%29%2C_Thailand%2C_Palm_trees_on_the_beach.jpg/1920px-Koh_Mak_%28island%29%2C_Thailand%2C_Palm_trees_on_the_beach.jpg',
        'tropical' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d5/Koh_Mak_%28island%29%2C_Thailand%2C_Palm_trees_on_the_beach.jpg/1920px-Koh_Mak_%28island%29%2C_Thailand%2C_Palm_trees_on_the_beach.jpg',
        'safari' => 'https://upload.wikimedia.org/wikipedia/commons/6/60/Leopard_in_Yala_National_Park.jpg',
        'jeep' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/46/Kapama_Game_Reserve_safari_photo_en_Jeep.jpg/1920px-Kapama_Game_Reserve_safari_photo_en_Jeep.jpg',
        'coral' => 'https://upload.wikimedia.org/wikipedia/commons/7/7b/Elkhorn_coral_Horseshoe_Reef_with_diver.png',
        'heritage' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/SL_Kandy_asv2020-01_img34_Sacred_Tooth_Temple.jpg/1920px-SL_Kandy_asv2020-01_img34_Sacred_Tooth_Temple.jpg',
        'jungle' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Inside_the_tropical_rainforest_%2811464713995%29.jpg/1920px-Inside_the_tropical_rainforest_%2811464713995%29.jpg',
        'temple' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c4/Kathmandu_Durbar_Square%2C_Shiva_Parvati_Temple%2C_Nepal_%28edit%29.jpg/1920px-Kathmandu_Durbar_Square%2C_Shiva_Parvati_Temple%2C_Nepal_%28edit%29.jpg',
        'office' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f0/Computer_keyboard_placed_on_a_black_desk_in_a_modern_workspace.jpg/1920px-Computer_keyboard_placed_on_a_black_desk_in_a_modern_workspace.jpg',
        'portrait' => 'https://upload.wikimedia.org/wikipedia/commons/6/67/Scott_James_Reeves_Portrait_%E2%80%93_Professional_Headshot_of_Scott_James_Reeves_in_Blue_Blazer.jpg',
    ],

    // Packages and destinations are stored in the database and edited in the admin panel
    // (App\Models\Package, App\Models\Destination).

    // Included/excluded rows a new package starts with in the admin panel. Plain English on purpose:
    // it is copied into the package, which is translated there (not by the site Translator run).
    'default_inclusions' => [
        ['item' => 'Accommodation', 'note' => 'Twin-share; upgrades quoted on request', 'included' => true],
        ['item' => 'Airport transfers', 'note' => 'Private vehicle, meet and greet', 'included' => true],
        ['item' => 'AC vehicle & driver-guide', 'note' => 'Dedicated for your party throughout', 'included' => true],
        ['item' => 'Entrance fees', 'note' => 'All sites named in the itinerary', 'included' => true],
        ['item' => 'Daily breakfast', 'note' => 'Half or full board quoted on request', 'included' => true],
        ['item' => 'Airfare', 'note' => 'We block-book from Chennai, Trichy, Mumbai or Delhi', 'included' => false],
        ['item' => 'Visa fee', 'note' => 'ETA assistance and invitation letters provided', 'included' => false],
        ['item' => 'Travel insurance', 'note' => 'Strongly recommended; mandatory over 70', 'included' => false],
    ],

    'albums' => [
        ['slug' => 'yala-safari', 'theme' => 'Wildlife', 'title' => ['en' => 'Yala Safari'], 'where' => 'Yala National Park', 'when' => 'Feb 2026', 'count' => 12, 'seed' => 'nioalb1'],
        ['slug' => 'maldives-overwater', 'theme' => 'Honeymoon', 'title' => ['en' => 'Maldives Overwater'], 'where' => 'North Ari Atoll', 'when' => 'Jan 2026', 'count' => 9, 'seed' => 'nioalb2'],
        ['slug' => 'cultural-triangle', 'theme' => 'Culture & heritage', 'title' => ['en' => 'Cultural Triangle'], 'where' => 'Sigiriya & Polonnaruwa', 'when' => 'Dec 2025', 'count' => 14, 'seed' => 'nioalb3'],
        ['slug' => 'pigeon-island-reef', 'theme' => 'Reef & diving', 'title' => ['en' => 'Pigeon Island Reef'], 'where' => 'Nilaveli, Trincomalee', 'when' => 'Aug 2025', 'count' => 8, 'seed' => 'nioalb4'],
        ['slug' => 'kandy-esala-perahera', 'theme' => 'Culture & heritage', 'title' => ['en' => 'Kandy Esala Perahera'], 'where' => 'Kandy', 'when' => 'Aug 2025', 'count' => 11, 'seed' => 'nioalb5'],
        ['slug' => 'hill-country-ella', 'theme' => 'Beach', 'title' => ['en' => 'Hill Country & Ella'], 'where' => 'Nuwara Eliya to Ella', 'when' => 'Mar 2026', 'count' => 10, 'seed' => 'nioalb6'],
        ['slug' => 'group-of-42-on-tour', 'theme' => 'Pilgrimage', 'title' => ['en' => 'Group of 42 on tour'], 'where' => 'Nuwara Eliya', 'when' => 'Mar 2026', 'count' => 13, 'seed' => 'nioalb7'],
        ['slug' => 'singapore-family-week', 'theme' => 'City break', 'title' => ['en' => 'Singapore family week'], 'where' => 'Singapore & Sentosa', 'when' => 'Jun 2025', 'count' => 9, 'seed' => 'nioalb8'],
    ],

    'videos' => [
        ['title' => ['en' => 'Morning game drive, Yala'], 'url' => 'https://www.youtube.com/watch?v=aqz-KE-bpKQ', 'meta' => 'Yala · Feb 2026', 'source' => 'YouTube', 'seed' => 'niovid0'],
        ['title' => ['en' => 'Overwater villa walk-through'], 'url' => 'https://www.facebook.com/watch/?v=1093831991017273', 'meta' => 'Maldives · Jan 2026', 'source' => 'Facebook', 'seed' => 'niovid1'],
        ['title' => ['en' => 'Sigiriya at sunrise'], 'url' => 'https://www.tiktok.com/@niotravels/video/7231234567890123456', 'meta' => 'Sigiriya · Dec 2025', 'source' => 'TikTok', 'seed' => 'niovid2'],
        ['title' => ['en' => 'Ella train, window seat'], 'url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4', 'meta' => 'Hill country · Mar 2026', 'source' => 'YouTube', 'seed' => 'niovid3'],
    ],

    'testimonials' => [
        [
            'text' => ['en' => 'Our Maldives leg, the Yala safari and both airport transfers were handled by one person on WhatsApp. That is all we wanted.'],
            'who' => 'Priya & Arun', 'meta' => 'Bengaluru · honeymoon · Feb 2026',
            'tour' => ['en' => 'Honeymoon'], 'seed' => 'nioq1',
        ],
        [
            'text' => ['en' => 'Two children under ten, a grandmother, and nobody was bored or exhausted. The free mornings were the best idea.'],
            'who' => 'The Iyer family', 'meta' => 'Chennai · 6 pax · Dec 2025',
            'tour' => ['en' => 'Culture'], 'seed' => 'nioq2',
        ],
        [
            'text' => ['en' => 'Three game drives, one leopard on the first morning. Our naturalist knew exactly where to wait.'],
            'who' => 'Rahul Menon', 'meta' => 'Kochi · 4 pax · Mar 2026',
            'tour' => ['en' => 'Wildlife'], 'seed' => 'nioq3',
        ],
        [
            'text' => ['en' => 'Forty-two of us, three generations, one coach. Everything was arranged before we landed.'],
            'who' => 'Sri Ramanuja Seva Samithi', 'meta' => 'Coimbatore · 42 pax · Mar 2026',
            'tour' => ['en' => 'Group'], 'seed' => 'nioq4',
        ],
    ],

    'staff' => [
        ['name' => 'Nuwan Fernando', 'role' => ['en' => 'Founder & managing director'], 'note' => ['en' => 'Drove the first Nio van in 2011.'], 'seed' => 'niostaff1'],
        ['name' => 'Nadeesha Perera', 'role' => ['en' => 'Head of reservations'], 'note' => ['en' => 'Answers most first enquiries herself.'], 'seed' => 'niostaff2'],
        ['name' => 'Ramesh Krishnan', 'role' => ['en' => 'India desk, Chennai'], 'note' => ['en' => 'Hindi, Tamil and Telugu.'], 'seed' => 'niostaff3'],
        ['name' => 'Dilani Jayawardena', 'role' => ['en' => 'Groups & MICE'], 'note' => ['en' => 'Handles parties of twenty and more.'], 'seed' => 'niostaff4'],
        ['name' => 'Sanjeewa Bandara', 'role' => ['en' => 'Chief naturalist'], 'note' => ['en' => 'Twenty seasons in Yala and Wilpattu.'], 'seed' => 'niostaff5'],
        ['name' => 'Aisha Rahman', 'role' => ['en' => 'Outbound & ticketing'], 'note' => ['en' => 'Maldives, Thailand, Dubai and Singapore.'], 'seed' => 'niostaff6'],
    ],

    'pillars' => [
        [
            'title' => ['en' => 'One person, start to finish'],
            'body' => ['en' => 'The coordinator who answers your first message stays with your booking to the airport.'],
            'icon' => 'M20 21a8 8 0 0 0-16 0M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z',
        ],
        [
            'title' => ['en' => 'Our own guides and vehicles'],
            'body' => ['en' => 'Inbound tours are run by Nio staff, not subcontracted to whoever is free that week.'],
            'icon' => 'M5 17h14M6 17V9l2-4h8l2 4v8M8 21v-2M16 21v-2',
        ],
        [
            'title' => ['en' => 'Indian-traveller ready'],
            'body' => ['en' => 'Hindi and Tamil guides, pure-veg and Jain catering, and rupee-friendly quoting.'],
            'icon' => 'M4 5h16M4 12h10M4 19h7M17 15l3 4-3 4',
        ],
        [
            'title' => ['en' => 'Written quotes, no pressure'],
            'body' => ['en' => 'You get the plan and the price in writing before any payment is discussed.'],
            'icon' => 'M8 3h8l4 4v14H4V3h4Zm0 0v4h8M8 13h8M8 17h5',
        ],
    ],

    // 'registration' and 'body' are official regulatory/association names — kept as-is across locales; only 'status' is translated.
    'licences' => [
        ['registration' => 'Inbound tour operator', 'body' => 'Sri Lanka Tourism Development Authority', 'reference' => 'SLTDA / TO / 0000', 'status' => ['en' => 'Active']],
        ['registration' => 'Outbound travel agent', 'body' => 'IATA accreditation', 'reference' => 'IATA 00-0 0000', 'status' => ['en' => 'Active']],
        ['registration' => 'Association member', 'body' => 'SLAITO', 'reference' => 'M-0000', 'status' => ['en' => 'Active']],
        ['registration' => 'Passenger transport', 'body' => 'National Transport Commission', 'reference' => 'NTC / 0000', 'status' => ['en' => 'On file']],
    ],

    // Enquiry / contact form options. Stable English keys are used as <option value>; travel_t() resolves the display label.
    'interests' => [
        'Honeymoon' => ['en' => 'Honeymoon'],
        'Family holiday' => ['en' => 'Family holiday'],
        'Wildlife safari' => ['en' => 'Wildlife safari'],
        'Reef & diving' => ['en' => 'Reef & diving'],
        'Culture & heritage' => ['en' => 'Culture & heritage'],
        'Group pilgrimage' => ['en' => 'Group pilgrimage'],
        'Outbound holiday' => ['en' => 'Outbound holiday'],
        'Not sure yet' => ['en' => 'Not sure yet'],
    ],

    'countries' => [
        'India' => ['en' => 'India'],
        'Sri Lanka' => ['en' => 'Sri Lanka'],
        'United Arab Emirates' => ['en' => 'United Arab Emirates'],
        'Singapore' => ['en' => 'Singapore'],
        'Malaysia' => ['en' => 'Malaysia'],
        'United Kingdom' => ['en' => 'United Kingdom'],
        'Australia' => ['en' => 'Australia'],
        'United States' => ['en' => 'United States'],
        'Other' => ['en' => 'Other'],
    ],

    'dial_codes' => [
        '+91' => 'IN +91', '+94' => 'LK +94', '+971' => 'AE +971', '+65' => 'SG +65',
        '+60' => 'MY +60', '+44' => 'UK +44', '+61' => 'AU +61', '+1' => 'US +1',
    ],

];
