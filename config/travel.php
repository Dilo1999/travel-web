<?php

return [

    'brand' => [
        'name' => 'Nio Travel and Tours',
        'legal_name' => 'Nio Travel and Tours (Pvt) Ltd',
        'tagline' => 'Sri Lanka, arranged properly.',
        'logo' => 'images/logo/nio-logo.png',
        'email' => 'hello@niotravels.lk',
        'address' => "No. 42, Galle Road\nColombo 03, Sri Lanka",
        'hours' => 'Mon – Sat, 08:30 – 19:00 IST. Sunday: WhatsApp only.',
        'founded_copy' => 'We started in 2011 with one van and a Colombo phone number. Today we run inbound tours across every province of Sri Lanka with our own guides and vehicles, and we book outbound holidays for the same travellers, mostly families, couples and groups from India who want one company answerable for the whole trip.',
        'whatsapp_message' => 'Hello Nio Travel and Tours, I would like to plan a trip.',
    ],

    // Floating WhatsApp widget desks
    'contacts' => [
        ['name' => 'Nadeesha Perera', 'role' => 'Reservations', 'country' => 'Sri Lanka', 'cc' => 'LK', 'number' => '+94 77 000 0000'],
        ['name' => 'Dilani Jayawardena', 'role' => 'Groups & MICE', 'country' => 'Sri Lanka', 'cc' => 'LK', 'number' => '+94 76 000 0000'],
        ['name' => 'Ramesh Krishnan', 'role' => 'India desk', 'country' => 'India', 'cc' => 'IN', 'number' => '+91 00000 00000'],
    ],

    'themes' => [
        'Honeymoon', 'Wildlife', 'Reef & diving', 'Culture & heritage',
        'Beach', 'Adventure', 'Pilgrimage', 'City break',
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

    'packages' => [
        ['id' => 'p1', 'slug' => 'emerald-coast-honeymoon', 'title' => 'Emerald Coast Honeymoon', 'theme' => 'Honeymoon', 'where' => 'Galle · Mirissa · Ella', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 6, 'pax' => '2 pax', 'season' => 'December to April on the south coast; the sea is calm and the evenings dry.', 'blurb' => 'Private villa nights on the south coast, a hill-country train morning and a sunset whale cruise from Mirissa.', 'img' => 'niop1'],
        ['id' => 'p2', 'slug' => 'yala-udawalawe-safari', 'title' => 'Yala & Udawalawe Safari', 'theme' => 'Wildlife', 'where' => 'Yala · Udawalawe', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 5, 'pax' => '2–14 pax', 'season' => 'February to July, when the waterholes shrink and sightings peak.', 'blurb' => 'Two parks, four game drives and a naturalist who knows which waterhole the leopards are using this month.', 'img' => 'niop2'],
        ['id' => 'p3', 'slug' => 'pigeon-island-reef-dive', 'title' => 'Pigeon Island Reef & Dive', 'theme' => 'Reef & diving', 'where' => 'Trincomalee · Nilaveli', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 4, 'pax' => '2–10 pax', 'season' => 'May to September on the east coast, flat water, clear visibility.', 'blurb' => 'Snorkel the reef flats, two guided dives at Swami Rock, and a PADI discover-scuba session for first-timers.', 'img' => 'niop3'],
        ['id' => 'p4', 'slug' => 'cultural-triangle-explorer', 'title' => 'Cultural Triangle Explorer', 'theme' => 'Culture & heritage', 'where' => 'Sigiriya · Polonnaruwa · Kandy', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 7, 'pax' => '2–24 pax', 'season' => 'All year; climb Sigiriya at first light in any season.', 'blurb' => 'Sigiriya at dawn, the Polonnaruwa ruins by bicycle, cave temples at Dambulla and evening drumming in Kandy.', 'img' => 'niop4'],
        ['id' => 'p5', 'slug' => 'ramayana-heritage-circuit', 'title' => 'Ramayana Heritage Circuit', 'theme' => 'Pilgrimage', 'where' => 'Chilaw · Nuwara Eliya · Ella', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 7, 'pax' => '20–60 pax', 'season' => 'January to March, ideal for large groups in the hills.', 'blurb' => 'The island\'s Ramayana sites with a Hindi-speaking manager, pure-veg catering and temple arrangements for large groups.', 'img' => 'niop5'],
        ['id' => 'p6', 'slug' => 'knuckles-trek-kitulgala-rafting', 'title' => 'Knuckles Trek & Kitulgala Rafting', 'theme' => 'Adventure', 'where' => 'Knuckles · Kitulgala', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 5, 'pax' => '4–16 pax', 'season' => 'January to March and July to September for the driest trails.', 'blurb' => 'Two days on the Knuckles ridges, a night in a tented camp and grade-3 rapids on the Kelani river.', 'img' => 'niop7'],
        ['id' => 'p7', 'slug' => 'southern-beaches-escape', 'title' => 'Southern Beaches Escape', 'theme' => 'Beach', 'where' => 'Bentota · Unawatuna', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 5, 'pax' => '2–20 pax', 'season' => 'November to April.', 'blurb' => 'Beach days either side of a Galle fort evening, with a river safari and a turtle hatchery stop for the children.', 'img' => 'niop8'],
        ['id' => 'p8', 'slug' => 'minneriya-elephant-gathering', 'title' => 'Minneriya Elephant Gathering', 'theme' => 'Wildlife', 'where' => 'Habarana · Minneriya', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 3, 'pax' => '2–18 pax', 'season' => 'August and September, when hundreds gather at the tank.', 'blurb' => 'A short trip timed to the Gathering, with an afternoon jeep and a village lunch in Habarana.', 'img' => 'niop9'],
        ['id' => 'p9', 'slug' => 'maldives-overwater-getaway', 'title' => 'Maldives Overwater Getaway', 'theme' => 'Honeymoon', 'where' => 'Male · North Ari Atoll', 'country' => 'Maldives', 'kind' => 'Outbound', 'days' => 4, 'pax' => '2 pax', 'season' => 'January to April for the clearest lagoons.', 'blurb' => 'Seaplane transfer, three nights in an overwater villa, a sandbank dinner and a manta snorkel morning.', 'img' => 'niop10'],
        ['id' => 'p10', 'slug' => 'singapore-sentosa-family-break', 'title' => 'Singapore & Sentosa Family Break', 'theme' => 'City break', 'where' => 'Singapore · Sentosa', 'country' => 'Singapore', 'kind' => 'Outbound', 'days' => 5, 'pax' => '2–12 pax', 'season' => 'All year; February to April is driest.', 'blurb' => 'Gardens by the Bay, Universal Studios and a river cruise, with family rooms near Orchard Road.', 'img' => 'niop11'],
        ['id' => 'p11', 'slug' => 'thailand-islands-bangkok', 'title' => 'Thailand Islands & Bangkok', 'theme' => 'Beach', 'where' => 'Bangkok · Krabi', 'country' => 'Thailand', 'kind' => 'Outbound', 'days' => 6, 'pax' => '2–16 pax', 'season' => 'November to March.', 'blurb' => 'Two city nights and four on the Andaman coast, with island hopping and a longtail trip to Railay.', 'img' => 'niop12'],
        ['id' => 'p12', 'slug' => 'dubai-city-desert', 'title' => 'Dubai City & Desert', 'theme' => 'City break', 'where' => 'Dubai · Al Marmoom', 'country' => 'UAE', 'kind' => 'Outbound', 'days' => 5, 'pax' => '2–20 pax', 'season' => 'November to March.', 'blurb' => 'Burj Khalifa, a dhow dinner, an evening desert safari and a day trip to Abu Dhabi\'s Grand Mosque.', 'img' => 'niop13'],
    ],

    // Featured on the home page (first 3 shown)
    'featured_packages' => ['p1', 'p2', 'p4'],

    'destinations' => [
        ['name' => 'Colombo & the west', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'blurb' => 'Arrivals, city sightseeing and the springboard for every circuit we run.', 'tags' => ['City', 'Food', 'Shopping'], 'img' => 'niod1'],
        ['name' => 'Kandy & the hill country', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'blurb' => 'Tea estates, the Temple of the Tooth and the Ella train through the gap.', 'tags' => ['Culture', 'Train', 'Tea'], 'img' => 'niod2'],
        ['name' => 'Yala & Udawalawe', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'blurb' => 'Leopards, elephants and the best-run game drives on the island.', 'tags' => ['Wildlife', 'Safari'], 'img' => 'niod3'],
        ['name' => 'Galle & the south coast', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'blurb' => 'Fort evenings, whale cruises from Mirissa and quiet honeymoon beaches.', 'tags' => ['Beach', 'Honeymoon', 'Whales'], 'img' => 'niod4'],
        ['name' => 'Trincomalee & the east', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'blurb' => 'Pigeon Island reef, Swami Rock dives and flat May-to-September seas.', 'tags' => ['Reef', 'Diving'], 'img' => 'niod5'],
        ['name' => 'Cultural Triangle', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'blurb' => 'Sigiriya, Dambulla, Polonnaruwa and Anuradhapura in one loop.', 'tags' => ['Heritage', 'UNESCO'], 'img' => 'niod6'],
        ['name' => 'Maldives', 'country' => 'Maldives', 'kind' => 'Outbound', 'blurb' => 'Overwater villas an hour from Colombo, our most-booked honeymoon add-on.', 'tags' => ['Honeymoon', 'Reef'], 'img' => 'niod7'],
        ['name' => 'Thailand', 'country' => 'Thailand', 'kind' => 'Outbound', 'blurb' => 'Bangkok, Phuket and Krabi, with Indian-friendly dining arranged.', 'tags' => ['Beach', 'City'], 'img' => 'niod8'],
        ['name' => 'Singapore & Malaysia', 'country' => 'Singapore', 'kind' => 'Outbound', 'blurb' => 'The family favourite: theme parks, gardens and easy transfers.', 'tags' => ['Family', 'City'], 'img' => 'niod9'],
        ['name' => 'Dubai & Abu Dhabi', 'country' => 'UAE', 'kind' => 'Outbound', 'blurb' => 'City sightseeing, desert evenings and shopping weeks.', 'tags' => ['City', 'Desert'], 'img' => 'niod10'],
        ['name' => 'Nepal', 'country' => 'Nepal', 'kind' => 'Outbound', 'blurb' => 'Kathmandu, Pokhara and the Annapurna foothills for walking groups.', 'tags' => ['Mountains', 'Pilgrimage'], 'img' => 'niod11'],
        ['name' => 'Vietnam', 'country' => 'Vietnam', 'kind' => 'Outbound', 'blurb' => 'Hanoi, Ha Long Bay and Da Nang, our fastest-growing outbound route.', 'tags' => ['Culture', 'Beach'], 'img' => 'niod12'],
    ],

    // Generic sample itinerary shown on every package detail page
    'sample_itinerary' => [
        ['n' => 1, 'title' => 'Arrival & transfer', 'body' => 'Met at the airport with a name-board, SIM card and cold towels. Transfer to the first hotel, welcome dinner and a route briefing with your tour manager.', 'stay' => 'Negombo / Colombo', 'meals' => 'Dinner'],
        ['n' => 2, 'title' => 'On the road', 'body' => 'The first full touring day, timed to avoid the coach crowds. Lunch at a place we actually eat at, and an afternoon at a slower pace.', 'stay' => 'En route', 'meals' => 'B · L · D'],
        ['n' => 3, 'title' => 'The main experience', 'body' => 'The centrepiece of this tour, booked and permitted in advance so there is no queueing on the day.', 'stay' => 'En route', 'meals' => 'B · L · D'],
        ['n' => 4, 'title' => 'A free morning', 'body' => 'Deliberately unscheduled. Spa, market, beach or a second game drive, your manager arranges whichever you pick at breakfast.', 'stay' => 'En route', 'meals' => 'B · D'],
        ['n' => 5, 'title' => 'Return & departure', 'body' => 'A relaxed drive back with one last stop, then the airport with time to spare. Written trip record handed over.', 'stay' => 'Departure', 'meals' => 'B'],
    ],

    'inclusions' => [
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
        ['slug' => 'yala-safari', 'theme' => 'Wildlife', 'title' => 'Yala Safari', 'where' => 'Yala National Park', 'when' => 'Feb 2026', 'count' => 12, 'seed' => 'nioalb1'],
        ['slug' => 'maldives-overwater', 'theme' => 'Honeymoon', 'title' => 'Maldives Overwater', 'where' => 'North Ari Atoll', 'when' => 'Jan 2026', 'count' => 9, 'seed' => 'nioalb2'],
        ['slug' => 'cultural-triangle', 'theme' => 'Culture & heritage', 'title' => 'Cultural Triangle', 'where' => 'Sigiriya & Polonnaruwa', 'when' => 'Dec 2025', 'count' => 14, 'seed' => 'nioalb3'],
        ['slug' => 'pigeon-island-reef', 'theme' => 'Reef & diving', 'title' => 'Pigeon Island Reef', 'where' => 'Nilaveli, Trincomalee', 'when' => 'Aug 2025', 'count' => 8, 'seed' => 'nioalb4'],
        ['slug' => 'kandy-esala-perahera', 'theme' => 'Culture & heritage', 'title' => 'Kandy Esala Perahera', 'where' => 'Kandy', 'when' => 'Aug 2025', 'count' => 11, 'seed' => 'nioalb5'],
        ['slug' => 'hill-country-ella', 'theme' => 'Beach', 'title' => 'Hill Country & Ella', 'where' => 'Nuwara Eliya to Ella', 'when' => 'Mar 2026', 'count' => 10, 'seed' => 'nioalb6'],
        ['slug' => 'group-of-42-on-tour', 'theme' => 'Pilgrimage', 'title' => 'Group of 42 on tour', 'where' => 'Nuwara Eliya', 'when' => 'Mar 2026', 'count' => 13, 'seed' => 'nioalb7'],
        ['slug' => 'singapore-family-week', 'theme' => 'City break', 'title' => 'Singapore family week', 'where' => 'Singapore & Sentosa', 'when' => 'Jun 2025', 'count' => 9, 'seed' => 'nioalb8'],
    ],

    'videos' => [
        ['title' => 'Morning game drive, Yala', 'url' => 'https://www.youtube.com/watch?v=aqz-KE-bpKQ', 'meta' => 'Yala · Feb 2026', 'source' => 'YouTube', 'seed' => 'niovid0'],
        ['title' => 'Overwater villa walk-through', 'url' => 'https://www.facebook.com/watch/?v=1093831991017273', 'meta' => 'Maldives · Jan 2026', 'source' => 'Facebook', 'seed' => 'niovid1'],
        ['title' => 'Sigiriya at sunrise', 'url' => 'https://www.tiktok.com/@niotravels/video/7231234567890123456', 'meta' => 'Sigiriya · Dec 2025', 'source' => 'TikTok', 'seed' => 'niovid2'],
        ['title' => 'Ella train, window seat', 'url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4', 'meta' => 'Hill country · Mar 2026', 'source' => 'YouTube', 'seed' => 'niovid3'],
    ],

    'testimonials' => [
        ['text' => 'Our Maldives leg, the Yala safari and both airport transfers were handled by one person on WhatsApp. That is all we wanted.', 'who' => 'Priya & Arun', 'meta' => 'Bengaluru · honeymoon · Feb 2026', 'tour' => 'Honeymoon', 'seed' => 'nioq1'],
        ['text' => 'Two children under ten, a grandmother, and nobody was bored or exhausted. The free mornings were the best idea.', 'who' => 'The Iyer family', 'meta' => 'Chennai · 6 pax · Dec 2025', 'tour' => 'Culture', 'seed' => 'nioq2'],
        ['text' => 'Three game drives, one leopard on the first morning. Our naturalist knew exactly where to wait.', 'who' => 'Rahul Menon', 'meta' => 'Kochi · 4 pax · Mar 2026', 'tour' => 'Wildlife', 'seed' => 'nioq3'],
        ['text' => 'Forty-two of us, three generations, one coach. Everything was arranged before we landed.', 'who' => 'Sri Ramanuja Seva Samithi', 'meta' => 'Coimbatore · 42 pax · Mar 2026', 'tour' => 'Group', 'seed' => 'nioq4'],
    ],

    'staff' => [
        ['name' => 'Nuwan Fernando', 'role' => 'Founder & managing director', 'note' => 'Drove the first Nio van in 2011.', 'seed' => 'niostaff1'],
        ['name' => 'Nadeesha Perera', 'role' => 'Head of reservations', 'note' => 'Answers most first enquiries herself.', 'seed' => 'niostaff2'],
        ['name' => 'Ramesh Krishnan', 'role' => 'India desk, Chennai', 'note' => 'Hindi, Tamil and Telugu.', 'seed' => 'niostaff3'],
        ['name' => 'Dilani Jayawardena', 'role' => 'Groups & MICE', 'note' => 'Handles parties of twenty and more.', 'seed' => 'niostaff4'],
        ['name' => 'Sanjeewa Bandara', 'role' => 'Chief naturalist', 'note' => 'Twenty seasons in Yala and Wilpattu.', 'seed' => 'niostaff5'],
        ['name' => 'Aisha Rahman', 'role' => 'Outbound & ticketing', 'note' => 'Maldives, Thailand, Dubai and Singapore.', 'seed' => 'niostaff6'],
    ],

    'pillars' => [
        ['title' => 'One person, start to finish', 'body' => 'The coordinator who answers your first message stays with your booking to the airport.', 'icon' => 'M20 21a8 8 0 0 0-16 0M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z'],
        ['title' => 'Our own guides and vehicles', 'body' => 'Inbound tours are run by Nio staff, not subcontracted to whoever is free that week.', 'icon' => 'M5 17h14M6 17V9l2-4h8l2 4v8M8 21v-2M16 21v-2'],
        ['title' => 'Indian-traveller ready', 'body' => 'Hindi and Tamil guides, pure-veg and Jain catering, and rupee-friendly quoting.', 'icon' => 'M4 5h16M4 12h10M4 19h7M17 15l3 4-3 4'],
        ['title' => 'Written quotes, no pressure', 'body' => 'You get the plan and the price in writing before any payment is discussed.', 'icon' => 'M8 3h8l4 4v14H4V3h4Zm0 0v4h8M8 13h8M8 17h5'],
    ],

    'licences' => [
        ['registration' => 'Inbound tour operator', 'body' => 'Sri Lanka Tourism Development Authority', 'reference' => 'SLTDA / TO / 0000', 'status' => 'Active'],
        ['registration' => 'Outbound travel agent', 'body' => 'IATA accreditation', 'reference' => 'IATA 00-0 0000', 'status' => 'Active'],
        ['registration' => 'Association member', 'body' => 'SLAITO', 'reference' => 'M-0000', 'status' => 'Active'],
        ['registration' => 'Passenger transport', 'body' => 'National Transport Commission', 'reference' => 'NTC / 0000', 'status' => 'On file'],
    ],

    // Enquiry / contact form options
    'interests' => [
        'Honeymoon', 'Family holiday', 'Wildlife safari', 'Reef & diving',
        'Culture & heritage', 'Group pilgrimage', 'Outbound holiday', 'Not sure yet',
    ],

    'countries' => [
        'India', 'Sri Lanka', 'United Arab Emirates', 'Singapore', 'Malaysia',
        'United Kingdom', 'Australia', 'United States', 'Other',
    ],

    'dial_codes' => [
        '+91' => 'IN +91', '+94' => 'LK +94', '+971' => 'AE +971', '+65' => 'SG +65',
        '+60' => 'MY +60', '+44' => 'UK +44', '+61' => 'AU +61', '+1' => 'US +1',
    ],

];
