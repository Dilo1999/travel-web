<?php

// Prose/content fields below are locale-keyed (['en' => ..., 'hi' => ..., 'ta' => ...])
// and resolved at render time via the travel_t() / travel_label() helpers (app/helpers.php).
// Proper nouns (brand name, staff names, official body names, address, email) and
// stable filter keys ('theme', 'kind' values) are intentionally left as plain strings —
// see config/laravellocalization.php and PackageController/DestinationController for why.

return [

    'brand' => [
        'name' => 'Nio Travel and Tours',
        'legal_name' => 'Nio Travel and Tours (Pvt) Ltd',
        'tagline' => [
            'en' => 'Sri Lanka, arranged properly.',
            'hi' => 'श्रीलंका, सही तरीके से व्यवस्थित।',
            'ta' => 'இலங்கை, சரியாக ஏற்பாடு செய்யப்பட்டது.',
        ],
        'logo' => 'images/logo/nio-logo.png',
        'email' => 'hello@niotravels.lk',
        'address' => "No. 42, Galle Road\nColombo 03, Sri Lanka",
        'hours' => [
            'en' => 'Mon – Sat, 08:30 – 19:00 IST. Sunday: WhatsApp only.',
            'hi' => 'सोम – शनि, सुबह 08:30 – शाम 07:00 IST। रविवार: केवल व्हाट्सएप।',
            'ta' => 'திங்கள் – சனி, காலை 08:30 – மாலை 07:00 IST. ஞாயிறு: வாட்ஸ்அப் மட்டும்.',
        ],
        'founded_copy' => [
            'en' => 'We started in 2011 with one van and a Colombo phone number. Today we run inbound tours across every province of Sri Lanka with our own guides and vehicles, and we book outbound holidays for the same travellers, mostly families, couples and groups from India who want one company answerable for the whole trip.',
            'hi' => 'हमने 2011 में एक वैन और कोलंबो के एक फ़ोन नंबर के साथ शुरुआत की थी। आज हम अपने खुद के गाइड और वाहनों के साथ श्रीलंका के हर प्रांत में इनबाउंड टूर चलाते हैं, और उन्हीं यात्रियों—ज़्यादातर भारत से आने वाले परिवारों, जोड़ों और समूहों—के लिए आउटबाउंड हॉलिडे भी बुक करते हैं, जो पूरी यात्रा के लिए एक ही कंपनी को ज़िम्मेदार चाहते हैं।',
            'ta' => 'நாங்கள் 2011ஆம் ஆண்டு ஒரு வேன் மற்றும் கொழும்பு தொலைபேசி எண்ணுடன் தொடங்கினோம். இன்று நாங்கள் எங்களது சொந்த வழிகாட்டிகள் மற்றும் வாகனங்களுடன் இலங்கையின் ஒவ்வொரு மாகாணத்திலும் இன்பவுண்ட் பயணங்களை நடத்துகிறோம், மேலும் அதே பயணிகளுக்கு—பெரும்பாலும் இந்தியாவிலிருந்து வரும் குடும்பங்கள், தம்பதிகள் மற்றும் குழுக்களுக்கு—முழுப் பயணத்திற்கும் ஒரே நிறுவனம் பொறுப்பேற்க வேண்டும் என விரும்பும் வெளிநாட்டு விடுமுறைகளையும் நாங்கள் பதிவு செய்கிறோம்.',
        ],
        'whatsapp_message' => [
            'en' => 'Hello Nio Travel and Tours, I would like to plan a trip.',
            'hi' => 'नमस्ते Nio Travel and Tours, मैं एक यात्रा की योजना बनाना चाहता/चाहती हूँ।',
            'ta' => 'வணக்கம் Nio Travel and Tours, நான் ஒரு பயணத்தைத் திட்டமிட விரும்புகிறேன்.',
        ],
    ],

    // Floating WhatsApp widget desks
    'contacts' => [
        ['name' => 'Nadeesha Perera', 'role' => ['en' => 'Reservations', 'hi' => 'रिज़र्वेशन', 'ta' => 'முன்பதிவு'], 'country' => ['en' => 'Sri Lanka', 'hi' => 'श्रीलंका', 'ta' => 'இலங்கை'], 'cc' => 'LK', 'number' => '+94 77 000 0000'],
        ['name' => 'Dilani Jayawardena', 'role' => ['en' => 'Groups & MICE', 'hi' => 'ग्रुप्स और MICE', 'ta' => 'குழுக்கள் & MICE'], 'country' => ['en' => 'Sri Lanka', 'hi' => 'श्रीलंका', 'ta' => 'இலங்கை'], 'cc' => 'LK', 'number' => '+94 76 000 0000'],
        ['name' => 'Ramesh Krishnan', 'role' => ['en' => 'India desk', 'hi' => 'इंडिया डेस्क', 'ta' => 'இந்தியா டெஸ்க்'], 'country' => ['en' => 'India', 'hi' => 'भारत', 'ta' => 'இந்தியா'], 'cc' => 'IN', 'number' => '+91 00000 00000'],
    ],

    // Stable filter keys — used in URLs and filtering logic (PackageController, HomeController). Do not translate in place.
    'themes' => [
        'Honeymoon', 'Wildlife', 'Reef & diving', 'Culture & heritage',
        'Beach', 'Adventure', 'Pilgrimage', 'City break',
    ],

    // Display labels for the stable theme keys above, resolved via travel_label().
    'theme_labels' => [
        'Honeymoon' => ['en' => 'Honeymoon', 'hi' => 'हनीमून', 'ta' => 'தேனிலவு'],
        'Wildlife' => ['en' => 'Wildlife', 'hi' => 'वन्यजीव', 'ta' => 'வனவிலங்கு'],
        'Reef & diving' => ['en' => 'Reef & diving', 'hi' => 'रीफ़ और डाइविंग', 'ta' => 'பவளப்பாறை & நீச்சல்'],
        'Culture & heritage' => ['en' => 'Culture & heritage', 'hi' => 'संस्कृति और विरासत', 'ta' => 'பண்பாடு & பாரம்பரியம்'],
        'Beach' => ['en' => 'Beach', 'hi' => 'समुद्र तट', 'ta' => 'கடற்கரை'],
        'Adventure' => ['en' => 'Adventure', 'hi' => 'एडवेंचर', 'ta' => 'சாகச பயணம்'],
        'Pilgrimage' => ['en' => 'Pilgrimage', 'hi' => 'तीर्थयात्रा', 'ta' => 'புனிதப் பயணம்'],
        'City break' => ['en' => 'City break', 'hi' => 'सिटी ब्रेक', 'ta' => 'நகர சுற்றுலா'],
    ],

    // Display labels for the stable 'kind' key used across packages/destinations filters.
    'kind_labels' => [
        'Inbound' => ['en' => 'Inbound', 'hi' => 'इनबाउंड', 'ta' => 'இன்பவுண்ட்'],
        'Outbound' => ['en' => 'Outbound', 'hi' => 'आउटबाउंड', 'ta' => 'அவுட்பவுண்ட்'],
    ],

    // Display labels for the package-list duration filter chips.
    'duration_labels' => [
        'All' => ['en' => 'All', 'hi' => 'सभी', 'ta' => 'அனைத்தும்'],
        '3–4' => ['en' => '3–4', 'hi' => '3–4', 'ta' => '3–4'],
        '5–6' => ['en' => '5–6', 'hi' => '5–6', 'ta' => '5–6'],
        '7+' => ['en' => '7+', 'hi' => '7+', 'ta' => '7+'],
    ],

    // Display labels for destination-card tags. Keys are the stable strings stored in each destination's 'tags' array.
    'tag_labels' => [
        'City' => ['en' => 'City', 'hi' => 'शहर', 'ta' => 'நகரம்'],
        'Food' => ['en' => 'Food', 'hi' => 'भोजन', 'ta' => 'உணவு'],
        'Shopping' => ['en' => 'Shopping', 'hi' => 'शॉपिंग', 'ta' => 'ஷாப்பிங்'],
        'Culture' => ['en' => 'Culture', 'hi' => 'संस्कृति', 'ta' => 'பண்பாடு'],
        'Train' => ['en' => 'Train', 'hi' => 'ट्रेन', 'ta' => 'ரயில்'],
        'Tea' => ['en' => 'Tea', 'hi' => 'चाय', 'ta' => 'தேயிலை'],
        'Wildlife' => ['en' => 'Wildlife', 'hi' => 'वन्यजीव', 'ta' => 'வனவிலங்கு'],
        'Safari' => ['en' => 'Safari', 'hi' => 'सफारी', 'ta' => 'சஃபாரி'],
        'Beach' => ['en' => 'Beach', 'hi' => 'समुद्र तट', 'ta' => 'கடற்கரை'],
        'Honeymoon' => ['en' => 'Honeymoon', 'hi' => 'हनीमून', 'ta' => 'தேனிலவு'],
        'Whales' => ['en' => 'Whales', 'hi' => 'व्हेल', 'ta' => 'திமிங்கலம்'],
        'Reef' => ['en' => 'Reef', 'hi' => 'रीफ़', 'ta' => 'பவளப்பாறை'],
        'Diving' => ['en' => 'Diving', 'hi' => 'डाइविंग', 'ta' => 'நீச்சல்'],
        'Heritage' => ['en' => 'Heritage', 'hi' => 'विरासत', 'ta' => 'பாரம்பரியம்'],
        'UNESCO' => ['en' => 'UNESCO', 'hi' => 'यूनेस्को', 'ta' => 'யுனெஸ்கோ'],
        'Family' => ['en' => 'Family', 'hi' => 'परिवार', 'ta' => 'குடும்பம்'],
        'Desert' => ['en' => 'Desert', 'hi' => 'रेगिस्तान', 'ta' => 'பாலைவனம்'],
        'Mountains' => ['en' => 'Mountains', 'hi' => 'पहाड़', 'ta' => 'மலைகள்'],
        'Pilgrimage' => ['en' => 'Pilgrimage', 'hi' => 'तीर्थयात्रा', 'ta' => 'புனிதப் பயணம்'],
    ],

    // Display labels for the destination-card country caption.
    'country_labels' => [
        'Sri Lanka' => ['en' => 'Sri Lanka', 'hi' => 'श्रीलंका', 'ta' => 'இலங்கை'],
        'Maldives' => ['en' => 'Maldives', 'hi' => 'मालदीव', 'ta' => 'மாலத்தீவு'],
        'Thailand' => ['en' => 'Thailand', 'hi' => 'थाईलैंड', 'ta' => 'தாய்லாந்து'],
        'Singapore' => ['en' => 'Singapore', 'hi' => 'सिंगापुर', 'ta' => 'சிங்கப்பூர்'],
        'UAE' => ['en' => 'UAE', 'hi' => 'यूएई', 'ta' => 'ஐக்கிய அரபு அமீரகம்'],
        'Nepal' => ['en' => 'Nepal', 'hi' => 'नेपाल', 'ta' => 'நேபாளம்'],
        'Vietnam' => ['en' => 'Vietnam', 'hi' => 'वियतनाम', 'ta' => 'வியட்நாம்'],
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
        [
            'id' => 'p1', 'slug' => 'emerald-coast-honeymoon', 'theme' => 'Honeymoon', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 6, 'pax' => '2 pax', 'img' => 'niop1',
            'title' => ['en' => 'Emerald Coast Honeymoon', 'hi' => 'एमराल्ड कोस्ट हनीमून', 'ta' => 'எமரால்டு கடற்கரை தேனிலவு'],
            'where' => ['en' => 'Galle · Mirissa · Ella', 'hi' => 'गॉल · मिरिसा · एला', 'ta' => 'காலே · மிரிசா · எல்லா'],
            'season' => ['en' => 'December to April on the south coast; the sea is calm and the evenings dry.', 'hi' => 'दक्षिणी तट पर दिसंबर से अप्रैल तक; समुद्र शांत रहता है और शामें सूखी होती हैं।', 'ta' => 'தென் கடற்கரையில் டிசம்பர் முதல் ஏப்ரல் வரை; கடல் அமைதியாகவும் மாலை நேரங்கள் வறண்டும் இருக்கும்.'],
            'blurb' => ['en' => 'Private villa nights on the south coast, a hill-country train morning and a sunset whale cruise from Mirissa.', 'hi' => 'दक्षिणी तट पर निजी विला में रातें, पहाड़ी इलाके में एक ट्रेन यात्रा की सुबह, और मिरिसा से सूर्यास्त व्हेल क्रूज़।', 'ta' => 'தென் கடற்கரையில் தனியார் வில்லா தங்குமிடங்கள், மலைப்பகுதி ரயில் பயணம் மற்றும் மிரிசாவிலிருந்து சூரிய அஸ்தமன திமிங்கல படகுச் சவாரி.'],
        ],
        [
            'id' => 'p2', 'slug' => 'yala-udawalawe-safari', 'theme' => 'Wildlife', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 5, 'pax' => '2–14 pax', 'img' => 'niop2',
            'title' => ['en' => 'Yala & Udawalawe Safari', 'hi' => 'याला और उदावलावे सफारी', 'ta' => 'யாலா & உடவலவே சஃபாரி'],
            'where' => ['en' => 'Yala · Udawalawe', 'hi' => 'याला · उदावलावे', 'ta' => 'யாலா · உடவலவே'],
            'season' => ['en' => 'February to July, when the waterholes shrink and sightings peak.', 'hi' => 'फरवरी से जुलाई तक, जब जलाशय सिकुड़ते हैं और वन्यजीव दिखने की संभावना सबसे अधिक होती है।', 'ta' => 'பிப்ரவரி முதல் ஜூலை வரை, நீர்நிலைகள் சுருங்கி வனவிலங்கு காட்சிகள் அதிகரிக்கும் காலம்.'],
            'blurb' => ['en' => 'Two parks, four game drives and a naturalist who knows which waterhole the leopards are using this month.', 'hi' => 'दो नेशनल पार्क, चार गेम ड्राइव और एक अनुभवी नेचुरलिस्ट जो जानता है कि इस महीने तेंदुए किस जलाशय का उपयोग कर रहे हैं।', 'ta' => 'இரண்டு தேசியப் பூங்காக்கள், நான்கு சஃபாரி சவாரிகள் மற்றும் இந்த மாதம் சிறுத்தைகள் எந்த நீர்நிலையைப் பயன்படுத்துகின்றன என்பதை அறிந்த இயற்கை வழிகாட்டி.'],
        ],
        [
            'id' => 'p3', 'slug' => 'pigeon-island-reef-dive', 'theme' => 'Reef & diving', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 4, 'pax' => '2–10 pax', 'img' => 'niop3',
            'title' => ['en' => 'Pigeon Island Reef & Dive', 'hi' => 'पिजन आइलैंड रीफ़ और डाइव', 'ta' => 'பிஜியன் தீவு பவளப்பாறை & நீச்சல்'],
            'where' => ['en' => 'Trincomalee · Nilaveli', 'hi' => 'त्रिंकोमाली · निलावेली', 'ta' => 'திருகோணமலை · நிலாவெளி'],
            'season' => ['en' => 'May to September on the east coast, flat water, clear visibility.', 'hi' => 'पूर्वी तट पर मई से सितंबर तक, शांत पानी और साफ़ दृश्यता।', 'ta' => 'கிழக்கு கடற்கரையில் மே முதல் செப்டம்பர் வரை, அமைதியான நீர் மற்றும் தெளிவான பார்வை.'],
            'blurb' => ['en' => 'Snorkel the reef flats, two guided dives at Swami Rock, and a PADI discover-scuba session for first-timers.', 'hi' => 'रीफ़ फ्लैट्स पर स्नॉर्कलिंग, स्वामी रॉक पर दो गाइडेड डाइव, और पहली बार गोता लगाने वालों के लिए PADI डिस्कवर-स्कूबा सत्र।', 'ta' => 'பவளப்பாறை பகுதிகளில் ஸ்னார்க்கலிங், ஸ்வாமி ராக்கில் இரு வழிகாட்டப்பட்ட நீச்சல்கள், மற்றும் முதல் முறை முயற்சிப்பவர்களுக்கு PADI ஸ்கூபா அறிமுக அமர்வு.'],
        ],
        [
            'id' => 'p4', 'slug' => 'cultural-triangle-explorer', 'theme' => 'Culture & heritage', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 7, 'pax' => '2–24 pax', 'img' => 'niop4',
            'title' => ['en' => 'Cultural Triangle Explorer', 'hi' => 'कल्चरल ट्रायंगल एक्सप्लोरर', 'ta' => 'பண்பாட்டு முக்கோண ஆய்வு பயணம்'],
            'where' => ['en' => 'Sigiriya · Polonnaruwa · Kandy', 'hi' => 'सिगिरिया · पोलोन्नारुवा · कैंडी', 'ta' => 'சிகிரியா · பொலநறுவை · கண்டி'],
            'season' => ['en' => 'All year; climb Sigiriya at first light in any season.', 'hi' => 'पूरे वर्ष उपलब्ध; किसी भी मौसम में सुबह की पहली रोशनी में सिगिरिया चढ़ें।', 'ta' => 'ஆண்டு முழுவதும் பொருந்தும்; எந்த பருவத்திலும் அதிகாலையில் சிகிரியா ஏறலாம்.'],
            'blurb' => ['en' => 'Sigiriya at dawn, the Polonnaruwa ruins by bicycle, cave temples at Dambulla and evening drumming in Kandy.', 'hi' => 'भोर में सिगिरिया, साइकिल से पोलोन्नारुवा के खंडहर, दांबुल्ला के गुफा मंदिर और कैंडी में शाम की ढोल-प्रस्तुति।', 'ta' => 'விடியற்காலையில் சிகிரியா, சைக்கிளில் பொலநறுவை சிதைவுகள், தம்புள்ளாவில் குகைக் கோவில்கள் மற்றும் கண்டியில் மாலை மேளக் கொட்டு நிகழ்ச்சி.'],
        ],
        [
            'id' => 'p5', 'slug' => 'ramayana-heritage-circuit', 'theme' => 'Pilgrimage', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 7, 'pax' => '20–60 pax', 'img' => 'niop5',
            'title' => ['en' => 'Ramayana Heritage Circuit', 'hi' => 'रामायण हेरिटेज सर्किट', 'ta' => 'ராமாயண பாரம்பரிய சுற்றுலா'],
            'where' => ['en' => 'Chilaw · Nuwara Eliya · Ella', 'hi' => 'चिलॉ · नुवारा एलिया · एला', 'ta' => 'சிலாபம் · நுவரெலியா · எல்லா'],
            'season' => ['en' => 'January to March, ideal for large groups in the hills.', 'hi' => 'जनवरी से मार्च, पहाड़ी क्षेत्रों में बड़े समूहों के लिए आदर्श समय।', 'ta' => 'ஜனவரி முதல் மார்ச் வரை, மலைப்பகுதிகளில் பெரிய குழுக்களுக்கு ஏற்ற காலம்.'],
            'blurb' => ["en" => "The island's Ramayana sites with a Hindi-speaking manager, pure-veg catering and temple arrangements for large groups.", 'hi' => 'हिंदी बोलने वाले मैनेजर के साथ द्वीप के रामायण स्थल, शुद्ध शाकाहारी भोजन और बड़े समूहों के लिए मंदिर व्यवस्था।', 'ta' => 'இந்தி பேசும் மேலாளருடன் தீவின் ராமாயண தலங்கள், சுத்த சைவ உணவு மற்றும் பெரிய குழுக்களுக்கான கோவில் ஏற்பாடுகள்.'],
        ],
        [
            'id' => 'p6', 'slug' => 'knuckles-trek-kitulgala-rafting', 'theme' => 'Adventure', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 5, 'pax' => '4–16 pax', 'img' => 'niop7',
            'title' => ['en' => 'Knuckles Trek & Kitulgala Rafting', 'hi' => 'नकल्स ट्रेक और किटुलगला राफ्टिंग', 'ta' => 'நக்கிள்ஸ் மலையேற்றம் & கிடுல்கலா படகோட்டம்'],
            'where' => ['en' => 'Knuckles · Kitulgala', 'hi' => 'नकल्स · किटुलगला', 'ta' => 'நக்கிள்ஸ் · கிடுல்கலா'],
            'season' => ['en' => 'January to March and July to September for the driest trails.', 'hi' => 'सबसे सूखे रास्तों के लिए जनवरी से मार्च और जुलाई से सितंबर उपयुक्त हैं।', 'ta' => 'மிக உலர்ந்த பாதைகளுக்கு ஜனவரி முதல் மார்ச் மற்றும் ஜூலை முதல் செப்டம்பர் ஏற்றது.'],
            'blurb' => ['en' => 'Two days on the Knuckles ridges, a night in a tented camp and grade-3 rapids on the Kelani river.', 'hi' => 'नकल्स की पहाड़ी चोटियों पर दो दिन, टेंटेड कैंप में एक रात और केलानी नदी में ग्रेड-3 रैपिड्स।', 'ta' => 'நக்கிள்ஸ் மலைத் தொடரில் இரண்டு நாட்கள், கூடார முகாமில் ஒரு இரவு மற்றும் கெலனி நதியில் தர-3 அலைவேக படகோட்டம்.'],
        ],
        [
            'id' => 'p7', 'slug' => 'southern-beaches-escape', 'theme' => 'Beach', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 5, 'pax' => '2–20 pax', 'img' => 'niop8',
            'title' => ['en' => 'Southern Beaches Escape', 'hi' => 'साउथर्न बीचेस एस्केप', 'ta' => 'தென் கடற்கரை ஓய்வு பயணம்'],
            'where' => ['en' => 'Bentota · Unawatuna', 'hi' => 'बेंटोटा · उनावातुना', 'ta' => 'பெந்தோட்டா · உனாவத்துனா'],
            'season' => ['en' => 'November to April.', 'hi' => 'नवंबर से अप्रैल तक।', 'ta' => 'நவம்பர் முதல் ஏப்ரல் வரை.'],
            'blurb' => ['en' => 'Beach days either side of a Galle fort evening, with a river safari and a turtle hatchery stop for the children.', 'hi' => 'गॉल किले की शाम के दोनों ओर समुद्र तट के दिन, साथ में एक नदी सफारी और बच्चों के लिए कछुआ हैचरी की यात्रा।', 'ta' => 'காலே கோட்டை மாலைப் பொழுதுக்கு இருபுறமும் கடற்கரை நாட்கள், நதி சஃபாரி மற்றும் குழந்தைகளுக்கான ஆமை வளர்ப்பு மையப் பயணத்துடன்.'],
        ],
        [
            'id' => 'p8', 'slug' => 'minneriya-elephant-gathering', 'theme' => 'Wildlife', 'country' => 'Sri Lanka', 'kind' => 'Inbound', 'days' => 3, 'pax' => '2–18 pax', 'img' => 'niop9',
            'title' => ['en' => 'Minneriya Elephant Gathering', 'hi' => 'मिनेरिया एलिफेंट गैदरिंग', 'ta' => 'மின்னேரியா யானைக் கூட்டம்'],
            'where' => ['en' => 'Habarana · Minneriya', 'hi' => 'हबराना · मिनेरिया', 'ta' => 'ஹபரணை · மின்னேரியா'],
            'season' => ['en' => 'August and September, when hundreds gather at the tank.', 'hi' => 'अगस्त और सितंबर में, जब सैकड़ों हाथी जलाशय के पास इकट्ठा होते हैं।', 'ta' => 'ஆகஸ்ட் மற்றும் செப்டம்பரில், நூற்றுக்கணக்கான யானைகள் ஏரியில் கூடும் காலம்.'],
            'blurb' => ['en' => 'A short trip timed to the Gathering, with an afternoon jeep and a village lunch in Habarana.', 'hi' => 'गैदरिंग के समय पर आधारित एक छोटी यात्रा, दोपहर की जीप सफारी और हबराना में गाँव के भोजन के साथ।', 'ta' => 'யானைக் கூட்டத்திற்கு ஏற்ப திட்டமிடப்பட்ட குறுகிய பயணம், மதிய ஜீப் சவாரி மற்றும் ஹபரணையில் கிராம உணவுடன்.'],
        ],
        [
            'id' => 'p9', 'slug' => 'maldives-overwater-getaway', 'theme' => 'Honeymoon', 'country' => 'Maldives', 'kind' => 'Outbound', 'days' => 4, 'pax' => '2 pax', 'img' => 'niop10',
            'title' => ['en' => 'Maldives Overwater Getaway', 'hi' => 'मालदीव ओवरवाटर गेटअवे', 'ta' => 'மாலத்தீவு நீர்மேல் வில்லா ஓய்வு பயணம்'],
            'where' => ['en' => 'Male · North Ari Atoll', 'hi' => 'माले · नॉर्थ अरी एटोल', 'ta' => 'மாலே · வடக்கு அரி அடோல்'],
            'season' => ['en' => 'January to April for the clearest lagoons.', 'hi' => 'सबसे साफ़ लैगून के लिए जनवरी से अप्रैल तक।', 'ta' => 'தெளிவான தடாகங்களுக்கு ஜனவரி முதல் ஏப்ரல் வரை.'],
            'blurb' => ['en' => 'Seaplane transfer, three nights in an overwater villa, a sandbank dinner and a manta snorkel morning.', 'hi' => 'सीप्लेन से स्थानांतरण, ओवरवाटर विला में तीन रातें, सैंडबैंक डिनर और मंता स्नॉर्कलिंग की सुबह।', 'ta' => 'கடல்விமான பயணம், நீர்மேல் வில்லாவில் மூன்று இரவுகள், மணல்திட்டு இரவு உணவு மற்றும் மான்ட்டா மீன் ஸ்னார்க்கலிங் காலை.'],
        ],
        [
            'id' => 'p10', 'slug' => 'singapore-sentosa-family-break', 'theme' => 'City break', 'country' => 'Singapore', 'kind' => 'Outbound', 'days' => 5, 'pax' => '2–12 pax', 'img' => 'niop11',
            'title' => ['en' => 'Singapore & Sentosa Family Break', 'hi' => 'सिंगापुर और सेंटोसा फैमिली ब्रेक', 'ta' => 'சிங்கப்பூர் & சென்டோசா குடும்ப பயணம்'],
            'where' => ['en' => 'Singapore · Sentosa', 'hi' => 'सिंगापुर · सेंटोसा', 'ta' => 'சிங்கப்பூர் · சென்டோசா'],
            'season' => ['en' => 'All year; February to April is driest.', 'hi' => 'पूरे वर्ष उपयुक्त; फरवरी से अप्रैल सबसे शुष्क समय है।', 'ta' => 'ஆண்டு முழுவதும் ஏற்றது; பிப்ரவரி முதல் ஏப்ரல் வரை மிக உலர்ந்த காலம்.'],
            'blurb' => ['en' => 'Gardens by the Bay, Universal Studios and a river cruise, with family rooms near Orchard Road.', 'hi' => 'गार्डन्स बाय द बे, यूनिवर्सल स्टूडियोज़ और एक नदी क्रूज़, साथ में ऑर्चर्ड रोड के पास फैमिली रूम्स।', 'ta' => 'கார்டன்ஸ் பை தி பே, யுனிவர்சல் ஸ்டுடியோஸ் மற்றும் நதிப் படகுச் சவாரி, ஆர்ச்சர்டு சாலைக்கு அருகில் குடும்ப அறைகளுடன்.'],
        ],
        [
            'id' => 'p11', 'slug' => 'thailand-islands-bangkok', 'theme' => 'Beach', 'country' => 'Thailand', 'kind' => 'Outbound', 'days' => 6, 'pax' => '2–16 pax', 'img' => 'niop12',
            'title' => ['en' => 'Thailand Islands & Bangkok', 'hi' => 'थाईलैंड आइलैंड्स और बैंकॉक', 'ta' => 'தாய்லாந்து தீவுகள் & பாங்காக்'],
            'where' => ['en' => 'Bangkok · Krabi', 'hi' => 'बैंकॉक · क्राबी', 'ta' => 'பாங்காக் · கிராபி'],
            'season' => ['en' => 'November to March.', 'hi' => 'नवंबर से मार्च तक।', 'ta' => 'நவம்பர் முதல் மார்ச் வரை.'],
            'blurb' => ['en' => 'Two city nights and four on the Andaman coast, with island hopping and a longtail trip to Railay.', 'hi' => 'शहर में दो रातें और अंडमान तट पर चार रातें, आइलैंड हॉपिंग और रेली तक लॉन्गटेल बोट यात्रा के साथ।', 'ta' => 'நகரத்தில் இரண்டு இரவுகள் மற்றும் அந்தமான் கடற்கரையில் நான்கு இரவுகள், தீவு சுற்றுலா மற்றும் ரெய்லேவிற்கு லாங்டெயில் படகுப் பயணத்துடன்.'],
        ],
        [
            'id' => 'p12', 'slug' => 'dubai-city-desert', 'theme' => 'City break', 'country' => 'UAE', 'kind' => 'Outbound', 'days' => 5, 'pax' => '2–20 pax', 'img' => 'niop13',
            'title' => ['en' => 'Dubai City & Desert', 'hi' => 'दुबई सिटी और डेज़र्ट', 'ta' => 'துபாய் நகரம் & பாலைவனம்'],
            'where' => ['en' => 'Dubai · Al Marmoom', 'hi' => 'दुबई · अल मरमूम', 'ta' => 'துபாய் · அல் மர்மூம்'],
            'season' => ['en' => 'November to March.', 'hi' => 'नवंबर से मार्च तक।', 'ta' => 'நவம்பர் முதல் மார்ச் வரை.'],
            'blurb' => ["en" => "Burj Khalifa, a dhow dinner, an evening desert safari and a day trip to Abu Dhabi's Grand Mosque.", 'hi' => 'बुर्ज खलीफा, धाऊ डिनर क्रूज़, शाम की डेज़र्ट सफारी और अबू धाबी की ग्रैंड मस्जिद की एक दिन की यात्रा।', 'ta' => 'புர்ஜ் கலீஃபா, தோ இரவு உணவுப் படகுச் சவாரி, மாலை பாலைவனச் சஃபாரி மற்றும் அபுதாபியின் கிராண்ட் மசூதிக்கு ஒரு நாள் பயணம்.'],
        ],
    ],

    // Featured on the home page (first 3 shown)
    'featured_packages' => ['p1', 'p2', 'p4'],

    'destinations' => [
        [
            'name' => ['en' => 'Colombo & the west', 'hi' => 'कोलंबो और पश्चिमी क्षेत्र', 'ta' => 'கொழும்பு & மேற்குப் பகுதி'],
            'country' => 'Sri Lanka', 'kind' => 'Inbound',
            'blurb' => ['en' => 'Arrivals, city sightseeing and the springboard for every circuit we run.', 'hi' => 'आगमन, शहर की सैर और हमारे हर टूर की शुरुआत का बिंदु।', 'ta' => 'வருகைகள், நகரச் சுற்றுலா மற்றும் நாங்கள் நடத்தும் ஒவ்வொரு பயணத்தின் தொடக்க இடம்.'],
            'tags' => ['City', 'Food', 'Shopping'], 'img' => 'niod1',
        ],
        [
            'name' => ['en' => 'Kandy & the hill country', 'hi' => 'कैंडी और पहाड़ी क्षेत्र', 'ta' => 'கண்டி & மலைநாடு'],
            'country' => 'Sri Lanka', 'kind' => 'Inbound',
            'blurb' => ['en' => 'Tea estates, the Temple of the Tooth and the Ella train through the gap.', 'hi' => 'चाय बागान, टेम्पल ऑफ द टूथ और घाटी से गुज़रती एला ट्रेन।', 'ta' => 'தேயிலைத் தோட்டங்கள், பல் கோவில் மற்றும் மலைவழியாக செல்லும் எல்லா ரயில் பயணம்.'],
            'tags' => ['Culture', 'Train', 'Tea'], 'img' => 'niod2',
        ],
        [
            'name' => ['en' => 'Yala & Udawalawe', 'hi' => 'याला और उदावलावे', 'ta' => 'யாலா & உடவலவே'],
            'country' => 'Sri Lanka', 'kind' => 'Inbound',
            'blurb' => ['en' => 'Leopards, elephants and the best-run game drives on the island.', 'hi' => 'तेंदुए, हाथी और द्वीप की सबसे बेहतरीन गेम ड्राइव।', 'ta' => 'சிறுத்தைகள், யானைகள் மற்றும் தீவின் சிறந்த சஃபாரி சவாரிகள்.'],
            'tags' => ['Wildlife', 'Safari'], 'img' => 'niod3',
        ],
        [
            'name' => ['en' => 'Galle & the south coast', 'hi' => 'गॉल और दक्षिणी तट', 'ta' => 'காலே & தென் கடற்கரை'],
            'country' => 'Sri Lanka', 'kind' => 'Inbound',
            'blurb' => ['en' => 'Fort evenings, whale cruises from Mirissa and quiet honeymoon beaches.', 'hi' => 'किले की शामें, मिरिसा से व्हेल क्रूज़ और शांत हनीमून समुद्र तट।', 'ta' => 'கோட்டை மாலைப் பொழுதுகள், மிரிசாவிலிருந்து திமிங்கல படகுச் சவாரி மற்றும் அமைதியான தேனிலவு கடற்கரைகள்.'],
            'tags' => ['Beach', 'Honeymoon', 'Whales'], 'img' => 'niod4',
        ],
        [
            'name' => ['en' => 'Trincomalee & the east', 'hi' => 'त्रिंकोमाली और पूर्वी क्षेत्र', 'ta' => 'திருகோணமலை & கிழக்குப் பகுதி'],
            'country' => 'Sri Lanka', 'kind' => 'Inbound',
            'blurb' => ['en' => 'Pigeon Island reef, Swami Rock dives and flat May-to-September seas.', 'hi' => 'पिजन आइलैंड रीफ़, स्वामी रॉक डाइविंग और मई से सितंबर तक शांत समुद्र।', 'ta' => 'பிஜியன் தீவு பவளப்பாறை, ஸ்வாமி ராக் நீச்சல் மற்றும் மே முதல் செப்டம்பர் வரை அமைதியான கடல்.'],
            'tags' => ['Reef', 'Diving'], 'img' => 'niod5',
        ],
        [
            'name' => ['en' => 'Cultural Triangle', 'hi' => 'कल्चरल ट्रायंगल', 'ta' => 'பண்பாட்டு முக்கோணம்'],
            'country' => 'Sri Lanka', 'kind' => 'Inbound',
            'blurb' => ['en' => 'Sigiriya, Dambulla, Polonnaruwa and Anuradhapura in one loop.', 'hi' => 'एक ही यात्रा में सिगिरिया, दांबुल्ला, पोलोन्नारुवा और अनुराधापुरा।', 'ta' => 'ஒரே பயணத்தில் சிகிரியா, தம்புள்ளா, பொலநறுவை மற்றும் அனுராதபுரம்.'],
            'tags' => ['Heritage', 'UNESCO'], 'img' => 'niod6',
        ],
        [
            'name' => ['en' => 'Maldives', 'hi' => 'मालदीव', 'ta' => 'மாலத்தீவு'],
            'country' => 'Maldives', 'kind' => 'Outbound',
            'blurb' => ['en' => 'Overwater villas an hour from Colombo, our most-booked honeymoon add-on.', 'hi' => 'कोलंबो से एक घंटे की दूरी पर ओवरवाटर विला, हमारा सबसे लोकप्रिय हनीमून ऐड-ऑन।', 'ta' => 'கொழும்பிலிருந்து ஒரு மணி நேரத்தில் நீர்மேல் வில்லாக்கள், எங்களின் அதிகம் பதிவு செய்யப்படும் தேனிலவு சேர்க்கை.'],
            'tags' => ['Honeymoon', 'Reef'], 'img' => 'niod7',
        ],
        [
            'name' => ['en' => 'Thailand', 'hi' => 'थाईलैंड', 'ta' => 'தாய்லாந்து'],
            'country' => 'Thailand', 'kind' => 'Outbound',
            'blurb' => ['en' => 'Bangkok, Phuket and Krabi, with Indian-friendly dining arranged.', 'hi' => 'बैंकॉक, फुकेट और क्राबी, भारतीय स्वाद के अनुरूप भोजन व्यवस्था के साथ।', 'ta' => 'பாங்காக், பூகெட் மற்றும் கிராபி, இந்திய-நட்பு உணவு ஏற்பாடுகளுடன்.'],
            'tags' => ['Beach', 'City'], 'img' => 'niod8',
        ],
        [
            'name' => ['en' => 'Singapore & Malaysia', 'hi' => 'सिंगापुर और मलेशिया', 'ta' => 'சிங்கப்பூர் & மலேசியா'],
            'country' => 'Singapore', 'kind' => 'Outbound',
            'blurb' => ['en' => 'The family favourite: theme parks, gardens and easy transfers.', 'hi' => 'परिवारों की पसंदीदा जगह: थीम पार्क, गार्डन और आसान ट्रांसफर।', 'ta' => 'குடும்பங்களுக்கு விருப்பமான இடம்: தீம் பார்க்குகள், தோட்டங்கள் மற்றும் எளிதான போக்குவரத்து.'],
            'tags' => ['Family', 'City'], 'img' => 'niod9',
        ],
        [
            'name' => ['en' => 'Dubai & Abu Dhabi', 'hi' => 'दुबई और अबू धाबी', 'ta' => 'துபாய் & அபுதாபி'],
            'country' => 'UAE', 'kind' => 'Outbound',
            'blurb' => ['en' => 'City sightseeing, desert evenings and shopping weeks.', 'hi' => 'शहर की सैर, रेगिस्तानी शामें और शॉपिंग वीक्स।', 'ta' => 'நகரச் சுற்றுலா, பாலைவன மாலைப் பொழுதுகள் மற்றும் ஷாப்பிங் வாரங்கள்.'],
            'tags' => ['City', 'Desert'], 'img' => 'niod10',
        ],
        [
            'name' => ['en' => 'Nepal', 'hi' => 'नेपाल', 'ta' => 'நேபாளம்'],
            'country' => 'Nepal', 'kind' => 'Outbound',
            'blurb' => ['en' => 'Kathmandu, Pokhara and the Annapurna foothills for walking groups.', 'hi' => 'वॉकिंग ग्रुप्स के लिए काठमांडू, पोखरा और अन्नपूर्णा की तलहटी।', 'ta' => 'நடைபயணக் குழுக்களுக்கு காத்மாண்டு, பொக்ரா மற்றும் அன்னபூர்ணா அடிவாரப் பகுதிகள்.'],
            'tags' => ['Mountains', 'Pilgrimage'], 'img' => 'niod11',
        ],
        [
            'name' => ['en' => 'Vietnam', 'hi' => 'वियतनाम', 'ta' => 'வியட்நாம்'],
            'country' => 'Vietnam', 'kind' => 'Outbound',
            'blurb' => ['en' => 'Hanoi, Ha Long Bay and Da Nang, our fastest-growing outbound route.', 'hi' => 'हनोई, हा लॉन्ग बे और दा नांग, हमारा सबसे तेज़ी से बढ़ता आउटबाउंड रूट।', 'ta' => 'ஹனோய், ஹா லாங் விரிகுடா மற்றும் டா நாங், எங்களின் வேகமாக வளரும் வெளிநாட்டுப் பயண வழி.'],
            'tags' => ['Culture', 'Beach'], 'img' => 'niod12',
        ],
    ],

    // Generic sample itinerary shown on every package detail page.
    // 'meals' is left as the international B/L/D shorthand across all locales.
    'sample_itinerary' => [
        [
            'n' => 1,
            'title' => ['en' => 'Arrival & transfer', 'hi' => 'आगमन और स्थानांतरण', 'ta' => 'வருகை & இடமாற்றம்'],
            'body' => ['en' => 'Met at the airport with a name-board, SIM card and cold towels. Transfer to the first hotel, welcome dinner and a route briefing with your tour manager.', 'hi' => 'नेम-बोर्ड, सिम कार्ड और ठंडे तौलिये के साथ एयरपोर्ट पर स्वागत। पहले होटल में स्थानांतरण, स्वागत भोज और आपके टूर मैनेजर के साथ रूट ब्रीफिंग।', 'ta' => 'பெயர்ப் பலகை, சிம் கார்டு மற்றும் குளிர்ந்த துண்டுகளுடன் விமான நிலையத்தில் வரவேற்பு. முதல் ஹோட்டலுக்கு இடமாற்றம், வரவேற்பு இரவு உணவு மற்றும் உங்கள் பயண மேலாளருடன் பாதை விளக்கம்.'],
            'stay' => ['en' => 'Negombo / Colombo', 'hi' => 'नेगोंबो / कोलंबो', 'ta' => 'நெகும்போ / கொழும்பு'],
            'meals' => 'Dinner',
        ],
        [
            'n' => 2,
            'title' => ['en' => 'On the road', 'hi' => 'सड़क यात्रा का दिन', 'ta' => 'பயணப் பாதையில்'],
            'body' => ['en' => 'The first full touring day, timed to avoid the coach crowds. Lunch at a place we actually eat at, and an afternoon at a slower pace.', 'hi' => 'यात्रा का पहला पूरा दिन, कोच भीड़ से बचने के लिए समयबद्ध। ऐसी जगह लंच जहाँ हम खुद खाते हैं, और दोपहर धीमी गति से।', 'ta' => 'பயணத்தின் முதல் முழு நாள், பேருந்துக் கூட்டத்தைத் தவிர்க்க திட்டமிடப்பட்டது. நாங்களே சாப்பிடும் இடத்தில் மதிய உணவு, மற்றும் மெதுவான வேகத்தில் ஒரு மதியம்.'],
            'stay' => ['en' => 'En route', 'hi' => 'मार्ग में', 'ta' => 'பயணப் பாதையில்'],
            'meals' => 'B · L · D',
        ],
        [
            'n' => 3,
            'title' => ['en' => 'The main experience', 'hi' => 'मुख्य अनुभव', 'ta' => 'முக்கிய அனுபவம்'],
            'body' => ['en' => 'The centrepiece of this tour, booked and permitted in advance so there is no queueing on the day.', 'hi' => 'इस टूर का मुख्य आकर्षण, पहले से बुक और अनुमति प्राप्त, ताकि उस दिन कतार में इंतज़ार न करना पड़े।', 'ta' => 'இந்த பயணத்தின் முக்கிய அம்சம், முன்கூட்டியே பதிவு செய்யப்பட்டு அனுமதி பெறப்பட்டது, அன்று வரிசையில் காத்திருக்க வேண்டியதில்லை.'],
            'stay' => ['en' => 'En route', 'hi' => 'मार्ग में', 'ta' => 'பயணப் பாதையில்'],
            'meals' => 'B · L · D',
        ],
        [
            'n' => 4,
            'title' => ['en' => 'A free morning', 'hi' => 'एक खाली सुबह', 'ta' => 'ஒரு ஓய்வு காலை'],
            'body' => ['en' => 'Deliberately unscheduled. Spa, market, beach or a second game drive, your manager arranges whichever you pick at breakfast.', 'hi' => 'जानबूझकर खाली रखा गया समय। स्पा, बाज़ार, समुद्र तट या दूसरी गेम ड्राइव—नाश्ते पर आप जो भी चुनें, आपका मैनेजर वही व्यवस्था करेगा।', 'ta' => 'வேண்டுமென்றே திட்டமிடப்படாத நேரம். ஸ்பா, சந்தை, கடற்கரை அல்லது இரண்டாவது சஃபாரி சவாரி—காலை உணவின்போது நீங்கள் தேர்ந்தெடுப்பதை உங்கள் மேலாளர் ஏற்பாடு செய்வார்.'],
            'stay' => ['en' => 'En route', 'hi' => 'मार्ग में', 'ta' => 'பயணப் பாதையில்'],
            'meals' => 'B · D',
        ],
        [
            'n' => 5,
            'title' => ['en' => 'Return & departure', 'hi' => 'वापसी और प्रस्थान', 'ta' => 'திரும்புதல் & புறப்பாடு'],
            'body' => ['en' => 'A relaxed drive back with one last stop, then the airport with time to spare. Written trip record handed over.', 'hi' => 'अंतिम पड़ाव के साथ एक आरामदायक वापसी यात्रा, फिर पर्याप्त समय के साथ एयरपोर्ट। लिखित यात्रा रिकॉर्ड सौंपा जाएगा।', 'ta' => 'ஒரு கடைசி நிறுத்தத்துடன் ஒரு நிதானமான திரும்புப் பயணம், பின்னர் போதுமான நேரத்துடன் விமான நிலையம். எழுத்துப்பூர்வ பயணப் பதிவு வழங்கப்படும்.'],
            'stay' => ['en' => 'Departure', 'hi' => 'प्रस्थान', 'ta' => 'புறப்பாடு'],
            'meals' => 'B',
        ],
    ],

    'inclusions' => [
        ['item' => ['en' => 'Accommodation', 'hi' => 'आवास', 'ta' => 'தங்குமிடம்'], 'note' => ['en' => 'Twin-share; upgrades quoted on request', 'hi' => 'ट्विन-शेयर; अपग्रेड अनुरोध पर उपलब्ध', 'ta' => 'இரட்டைப் பகிர்வு; மேம்படுத்தல்கள் கோரிக்கையின் பேரில் கிடைக்கும்'], 'included' => true],
        ['item' => ['en' => 'Airport transfers', 'hi' => 'एयरपोर्ट ट्रांसफर', 'ta' => 'விமான நிலைய போக்குவரத்து'], 'note' => ['en' => 'Private vehicle, meet and greet', 'hi' => 'निजी वाहन, मीट एंड ग्रीट सेवा सहित', 'ta' => 'தனியார் வாகனம், வரவேற்பு சேவையுடன்'], 'included' => true],
        ['item' => ['en' => 'AC vehicle & driver-guide', 'hi' => 'एसी वाहन और ड्राइवर-गाइड', 'ta' => 'ஏசி வாகனம் & ஓட்டுநர்-வழிகாட்டி'], 'note' => ['en' => 'Dedicated for your party throughout', 'hi' => 'पूरी यात्रा के दौरान आपके समूह के लिए समर्पित', 'ta' => 'முழுப் பயணத்திலும் உங்கள் குழுவிற்கென ஒதுக்கப்பட்டது'], 'included' => true],
        ['item' => ['en' => 'Entrance fees', 'hi' => 'प्रवेश शुल्क', 'ta' => 'நுழைவுக் கட்டணங்கள்'], 'note' => ['en' => 'All sites named in the itinerary', 'hi' => 'यात्रा कार्यक्रम में शामिल सभी स्थल', 'ta' => 'பயணத்திட்டத்தில் குறிப்பிடப்பட்ட அனைத்து இடங்களும்'], 'included' => true],
        ['item' => ['en' => 'Daily breakfast', 'hi' => 'दैनिक नाश्ता', 'ta' => 'தினசரி காலை உணவு'], 'note' => ['en' => 'Half or full board quoted on request', 'hi' => 'हाफ़ या फुल बोर्ड अनुरोध पर उपलब्ध', 'ta' => 'அரை அல்லது முழு உணவு திட்டம் கோரிக்கையின் பேரில் கிடைக்கும்'], 'included' => true],
        ['item' => ['en' => 'Airfare', 'hi' => 'हवाई किराया', 'ta' => 'விமானக் கட்டணம்'], 'note' => ['en' => 'We block-book from Chennai, Trichy, Mumbai or Delhi', 'hi' => 'हम चेन्नई, त्रिची, मुंबई या दिल्ली से ब्लॉक-बुकिंग करते हैं', 'ta' => 'சென்னை, திருச்சி, மும்பை அல்லது டெல்லியிலிருந்து நாங்கள் தொகுப்பு முன்பதிவு செய்கிறோம்'], 'included' => false],
        ['item' => ['en' => 'Visa fee', 'hi' => 'वीज़ा शुल्क', 'ta' => 'விசா கட்டணம்'], 'note' => ['en' => 'ETA assistance and invitation letters provided', 'hi' => 'ETA सहायता और आमंत्रण पत्र प्रदान किए जाते हैं', 'ta' => 'ETA உதவி மற்றும் அழைப்பிதழ்கள் வழங்கப்படும்'], 'included' => false],
        ['item' => ['en' => 'Travel insurance', 'hi' => 'यात्रा बीमा', 'ta' => 'பயண காப்பீடு'], 'note' => ['en' => 'Strongly recommended; mandatory over 70', 'hi' => 'अत्यधिक अनुशंसित; 70 वर्ष से अधिक आयु वालों के लिए अनिवार्य', 'ta' => 'மிகவும் பரிந்துரைக்கப்படுகிறது; 70 வயதுக்கு மேற்பட்டவர்களுக்கு கட்டாயம்'], 'included' => false],
    ],

    'albums' => [
        ['slug' => 'yala-safari', 'theme' => 'Wildlife', 'title' => ['en' => 'Yala Safari', 'hi' => 'याला सफारी', 'ta' => 'யாலா சஃபாரி'], 'where' => 'Yala National Park', 'when' => 'Feb 2026', 'count' => 12, 'seed' => 'nioalb1'],
        ['slug' => 'maldives-overwater', 'theme' => 'Honeymoon', 'title' => ['en' => 'Maldives Overwater', 'hi' => 'मालदीव ओवरवाटर', 'ta' => 'மாலத்தீவு நீர்மேல் வில்லா'], 'where' => 'North Ari Atoll', 'when' => 'Jan 2026', 'count' => 9, 'seed' => 'nioalb2'],
        ['slug' => 'cultural-triangle', 'theme' => 'Culture & heritage', 'title' => ['en' => 'Cultural Triangle', 'hi' => 'कल्चरल ट्रायंगल', 'ta' => 'பண்பாட்டு முக்கோணம்'], 'where' => 'Sigiriya & Polonnaruwa', 'when' => 'Dec 2025', 'count' => 14, 'seed' => 'nioalb3'],
        ['slug' => 'pigeon-island-reef', 'theme' => 'Reef & diving', 'title' => ['en' => 'Pigeon Island Reef', 'hi' => 'पिजन आइलैंड रीफ़', 'ta' => 'பிஜியன் தீவு பவளப்பாறை'], 'where' => 'Nilaveli, Trincomalee', 'when' => 'Aug 2025', 'count' => 8, 'seed' => 'nioalb4'],
        ['slug' => 'kandy-esala-perahera', 'theme' => 'Culture & heritage', 'title' => ['en' => 'Kandy Esala Perahera', 'hi' => 'कैंडी एसाला पेराहेरा', 'ta' => 'கண்டி எசாலா பெரஹரா'], 'where' => 'Kandy', 'when' => 'Aug 2025', 'count' => 11, 'seed' => 'nioalb5'],
        ['slug' => 'hill-country-ella', 'theme' => 'Beach', 'title' => ['en' => 'Hill Country & Ella', 'hi' => 'पहाड़ी क्षेत्र और एला', 'ta' => 'மலைநாடு & எல்லா'], 'where' => 'Nuwara Eliya to Ella', 'when' => 'Mar 2026', 'count' => 10, 'seed' => 'nioalb6'],
        ['slug' => 'group-of-42-on-tour', 'theme' => 'Pilgrimage', 'title' => ['en' => 'Group of 42 on tour', 'hi' => '42 सदस्यों का टूर समूह', 'ta' => '42 பேர் கொண்ட சுற்றுலா குழு'], 'where' => 'Nuwara Eliya', 'when' => 'Mar 2026', 'count' => 13, 'seed' => 'nioalb7'],
        ['slug' => 'singapore-family-week', 'theme' => 'City break', 'title' => ['en' => 'Singapore family week', 'hi' => 'सिंगापुर फैमिली वीक', 'ta' => 'சிங்கப்பூர் குடும்ப வாரம்'], 'where' => 'Singapore & Sentosa', 'when' => 'Jun 2025', 'count' => 9, 'seed' => 'nioalb8'],
    ],

    'videos' => [
        ['title' => ['en' => 'Morning game drive, Yala', 'hi' => 'सुबह की गेम ड्राइव, याला', 'ta' => 'காலை சஃபாரி சவாரி, யாலா'], 'url' => 'https://www.youtube.com/watch?v=aqz-KE-bpKQ', 'meta' => 'Yala · Feb 2026', 'source' => 'YouTube', 'seed' => 'niovid0'],
        ['title' => ['en' => 'Overwater villa walk-through', 'hi' => 'ओवरवाटर विला की झलक', 'ta' => 'நீர்மேல் வில்லா சுற்றுப் பார்வை'], 'url' => 'https://www.facebook.com/watch/?v=1093831991017273', 'meta' => 'Maldives · Jan 2026', 'source' => 'Facebook', 'seed' => 'niovid1'],
        ['title' => ['en' => 'Sigiriya at sunrise', 'hi' => 'सूर्योदय पर सिगिरिया', 'ta' => 'சூரிய உதயத்தில் சிகிரியா'], 'url' => 'https://www.tiktok.com/@niotravels/video/7231234567890123456', 'meta' => 'Sigiriya · Dec 2025', 'source' => 'TikTok', 'seed' => 'niovid2'],
        ['title' => ['en' => 'Ella train, window seat', 'hi' => 'एला ट्रेन, विंडो सीट', 'ta' => 'எல்லா ரயில், ஜன்னல் இருக்கை'], 'url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4', 'meta' => 'Hill country · Mar 2026', 'source' => 'YouTube', 'seed' => 'niovid3'],
    ],

    'testimonials' => [
        [
            'text' => ['en' => 'Our Maldives leg, the Yala safari and both airport transfers were handled by one person on WhatsApp. That is all we wanted.', 'hi' => 'हमारे मालदीव के हिस्से, याला सफारी और दोनों एयरपोर्ट ट्रांसफर—सब कुछ एक ही व्यक्ति ने व्हाट्सएप पर संभाला। यही तो हम चाहते थे।', 'ta' => 'எங்கள் மாலத்தீவு பயணம், யாலா சஃபாரி மற்றும் இரண்டு விமான நிலைய போக்குவரத்துகளும் ஒரே நபரால் வாட்ஸ்அப்பில் கையாளப்பட்டன. நாங்கள் விரும்பியது இதுதான்.'],
            'who' => 'Priya & Arun', 'meta' => 'Bengaluru · honeymoon · Feb 2026',
            'tour' => ['en' => 'Honeymoon', 'hi' => 'हनीमून', 'ta' => 'தேனிலவு'], 'seed' => 'nioq1',
        ],
        [
            'text' => ['en' => 'Two children under ten, a grandmother, and nobody was bored or exhausted. The free mornings were the best idea.', 'hi' => 'दस वर्ष से कम उम्र के दो बच्चे, एक दादी—फिर भी कोई बोर या थका हुआ नहीं था। खाली सुबहें सबसे अच्छा विचार थीं।', 'ta' => 'பத்து வயதுக்குட்பட்ட இரண்டு குழந்தைகள், ஒரு பாட்டி—ஆனாலும் யாருக்கும் சலிப்பு அல்லது சோர்வு ஏற்படவில்லை. ஓய்வு காலைகள் சிறந்த யோசனையாக இருந்தது.'],
            'who' => 'The Iyer family', 'meta' => 'Chennai · 6 pax · Dec 2025',
            'tour' => ['en' => 'Culture', 'hi' => 'संस्कृति', 'ta' => 'பண்பாடு'], 'seed' => 'nioq2',
        ],
        [
            'text' => ['en' => 'Three game drives, one leopard on the first morning. Our naturalist knew exactly where to wait.', 'hi' => 'तीन गेम ड्राइव, पहली ही सुबह एक तेंदुआ दिखा। हमारे नेचुरलिस्ट को ठीक-ठीक पता था कि कहाँ इंतज़ार करना है।', 'ta' => 'மூன்று சஃபாரி சவாரிகள், முதல் காலையிலேயே ஒரு சிறுத்தை. எங்கள் இயற்கை வழிகாட்டிக்கு எங்கு காத்திருக்க வேண்டும் என்பது சரியாகத் தெரிந்திருந்தது.'],
            'who' => 'Rahul Menon', 'meta' => 'Kochi · 4 pax · Mar 2026',
            'tour' => ['en' => 'Wildlife', 'hi' => 'वन्यजीव', 'ta' => 'வனவிலங்கு'], 'seed' => 'nioq3',
        ],
        [
            'text' => ['en' => 'Forty-two of us, three generations, one coach. Everything was arranged before we landed.', 'hi' => 'हम 42 लोग, तीन पीढ़ियाँ, एक कोच। हमारे पहुँचने से पहले ही सब कुछ व्यवस्थित था।', 'ta' => 'நாங்கள் 42 பேர், மூன்று தலைமுறைகள், ஒரே பேருந்து. நாங்கள் வந்திறங்குவதற்கு முன்பே எல்லாம் ஏற்பாடு செய்யப்பட்டிருந்தது.'],
            'who' => 'Sri Ramanuja Seva Samithi', 'meta' => 'Coimbatore · 42 pax · Mar 2026',
            'tour' => ['en' => 'Group', 'hi' => 'समूह', 'ta' => 'குழு'], 'seed' => 'nioq4',
        ],
    ],

    'staff' => [
        ['name' => 'Nuwan Fernando', 'role' => ['en' => 'Founder & managing director', 'hi' => 'संस्थापक और प्रबंध निदेशक', 'ta' => 'நிறுவனர் & நிர்வாக இயக்குநர்'], 'note' => ['en' => 'Drove the first Nio van in 2011.', 'hi' => '2011 में पहली नियो वैन खुद चलाई थी।', 'ta' => '2011ஆம் ஆண்டு முதல் நியோ வேனை நேரடியாக ஓட்டியவர்.'], 'seed' => 'niostaff1'],
        ['name' => 'Nadeesha Perera', 'role' => ['en' => 'Head of reservations', 'hi' => 'रिज़र्वेशन प्रमुख', 'ta' => 'முன்பதிவுத் துறைத் தலைவர்'], 'note' => ['en' => 'Answers most first enquiries herself.', 'hi' => 'अधिकांश पहली पूछताछ का जवाब खुद देती हैं।', 'ta' => 'பெரும்பாலான முதல் விசாரணைகளுக்கு நேரடியாகவே பதிலளிக்கிறார்.'], 'seed' => 'niostaff2'],
        ['name' => 'Ramesh Krishnan', 'role' => ['en' => 'India desk, Chennai', 'hi' => 'इंडिया डेस्क, चेन्नई', 'ta' => 'இந்தியா டெஸ்க், சென்னை'], 'note' => ['en' => 'Hindi, Tamil and Telugu.', 'hi' => 'हिंदी, तमिल और तेलुगु बोलते हैं।', 'ta' => 'இந்தி, தமிழ் மற்றும் தெலுங்கு பேசுபவர்.'], 'seed' => 'niostaff3'],
        ['name' => 'Dilani Jayawardena', 'role' => ['en' => 'Groups & MICE', 'hi' => 'ग्रुप्स और MICE', 'ta' => 'குழுக்கள் & MICE'], 'note' => ['en' => 'Handles parties of twenty and more.', 'hi' => 'बीस या उससे अधिक सदस्यों के समूहों को संभालते हैं।', 'ta' => 'இருபது அல்லது அதற்கு மேற்பட்ட குழுக்களை கையாளுபவர்.'], 'seed' => 'niostaff4'],
        ['name' => 'Sanjeewa Bandara', 'role' => ['en' => 'Chief naturalist', 'hi' => 'चीफ नेचुरलिस्ट', 'ta' => 'தலைமை இயற்கை வழிகாட்டி'], 'note' => ['en' => 'Twenty seasons in Yala and Wilpattu.', 'hi' => 'याला और विल्पत्तु में बीस सीज़न का अनुभव।', 'ta' => 'யாலா மற்றும் வில்பத்துவில் இருபது பருவங்களின் அனுபவம்.'], 'seed' => 'niostaff5'],
        ['name' => 'Aisha Rahman', 'role' => ['en' => 'Outbound & ticketing', 'hi' => 'आउटबाउंड और टिकटिंग', 'ta' => 'அவுட்பவுண்ட் & டிக்கெட்டிங்'], 'note' => ['en' => 'Maldives, Thailand, Dubai and Singapore.', 'hi' => 'मालदीव, थाईलैंड, दुबई और सिंगापुर संभालती हैं।', 'ta' => 'மாலத்தீவு, தாய்லாந்து, துபாய் மற்றும் சிங்கப்பூரைக் கையாளுபவர்.'], 'seed' => 'niostaff6'],
    ],

    'pillars' => [
        [
            'title' => ['en' => 'One person, start to finish', 'hi' => 'शुरू से अंत तक एक ही व्यक्ति', 'ta' => 'தொடக்கம் முதல் முடிவு வரை ஒருவரே'],
            'body' => ['en' => 'The coordinator who answers your first message stays with your booking to the airport.', 'hi' => 'आपके पहले संदेश का जवाब देने वाला समन्वयक ही आपकी बुकिंग को एयरपोर्ट तक साथ निभाता है।', 'ta' => 'உங்கள் முதல் செய்திக்கு பதிலளிக்கும் ஒருங்கிணைப்பாளரே உங்கள் முன்பதிவை விமான நிலையம் வரை பராமரிக்கிறார்.'],
            'icon' => 'M20 21a8 8 0 0 0-16 0M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z',
        ],
        [
            'title' => ['en' => 'Our own guides and vehicles', 'hi' => 'अपने खुद के गाइड और वाहन', 'ta' => 'எங்களது சொந்த வழிகாட்டிகள் & வாகனங்கள்'],
            'body' => ['en' => 'Inbound tours are run by Nio staff, not subcontracted to whoever is free that week.', 'hi' => 'इनबाउंड टूर नियो के अपने स्टाफ द्वारा संचालित होते हैं, न कि उस सप्ताह जो भी उपलब्ध हो उसे सबकॉन्ट्रैक्ट किया जाता है।', 'ta' => 'இன்பவுண்ட் பயணங்கள் நியோவின் சொந்த ஊழியர்களால் நடத்தப்படுகின்றன, அந்த வாரம் யார் கிடைக்கிறார்களோ அவர்களிடம் ஒப்படைக்கப்படுவதில்லை.'],
            'icon' => 'M5 17h14M6 17V9l2-4h8l2 4v8M8 21v-2M16 21v-2',
        ],
        [
            'title' => ['en' => 'Indian-traveller ready', 'hi' => 'भारतीय यात्रियों के लिए तैयार', 'ta' => 'இந்திய பயணிகளுக்கு ஏற்றது'],
            'body' => ['en' => 'Hindi and Tamil guides, pure-veg and Jain catering, and rupee-friendly quoting.', 'hi' => 'हिंदी और तमिल बोलने वाले गाइड, शुद्ध शाकाहारी और जैन भोजन, और रुपये में सुविधाजनक कोटेशन।', 'ta' => 'இந்தி மற்றும் தமிழ் பேசும் வழிகாட்டிகள், சுத்த சைவ மற்றும் ஜைன உணவு, மற்றும் ரூபாயில் வசதியான மேற்கோள்.'],
            'icon' => 'M4 5h16M4 12h10M4 19h7M17 15l3 4-3 4',
        ],
        [
            'title' => ['en' => 'Written quotes, no pressure', 'hi' => 'लिखित कोटेशन, कोई दबाव नहीं', 'ta' => 'எழுத்துப்பூர்வ மேற்கோள், அழுத்தம் இல்லை'],
            'body' => ['en' => 'You get the plan and the price in writing before any payment is discussed.', 'hi' => 'किसी भी भुगतान पर चर्चा से पहले आपको योजना और कीमत लिखित में दी जाती है।', 'ta' => 'எந்தவொரு கட்டணம் குறித்து பேசுவதற்கு முன்பே, திட்டமும் விலையும் எழுத்துப்பூர்வமாக உங்களுக்கு வழங்கப்படும்.'],
            'icon' => 'M8 3h8l4 4v14H4V3h4Zm0 0v4h8M8 13h8M8 17h5',
        ],
    ],

    // 'registration' and 'body' are official regulatory/association names — kept as-is across locales; only 'status' is translated.
    'licences' => [
        ['registration' => 'Inbound tour operator', 'body' => 'Sri Lanka Tourism Development Authority', 'reference' => 'SLTDA / TO / 0000', 'status' => ['en' => 'Active', 'hi' => 'सक्रिय', 'ta' => 'செயலில் உள்ளது']],
        ['registration' => 'Outbound travel agent', 'body' => 'IATA accreditation', 'reference' => 'IATA 00-0 0000', 'status' => ['en' => 'Active', 'hi' => 'सक्रिय', 'ta' => 'செயலில் உள்ளது']],
        ['registration' => 'Association member', 'body' => 'SLAITO', 'reference' => 'M-0000', 'status' => ['en' => 'Active', 'hi' => 'सक्रिय', 'ta' => 'செயலில் உள்ளது']],
        ['registration' => 'Passenger transport', 'body' => 'National Transport Commission', 'reference' => 'NTC / 0000', 'status' => ['en' => 'On file', 'hi' => 'रिकॉर्ड में', 'ta' => 'பதிவில் உள்ளது']],
    ],

    // Enquiry / contact form options. Stable English keys are used as <option value>; travel_t() resolves the display label.
    'interests' => [
        'Honeymoon' => ['en' => 'Honeymoon', 'hi' => 'हनीमून', 'ta' => 'தேனிலவு'],
        'Family holiday' => ['en' => 'Family holiday', 'hi' => 'फैमिली हॉलिडे', 'ta' => 'குடும்ப விடுமுறை'],
        'Wildlife safari' => ['en' => 'Wildlife safari', 'hi' => 'वाइल्डलाइफ सफारी', 'ta' => 'வனவிலங்கு சஃபாரி'],
        'Reef & diving' => ['en' => 'Reef & diving', 'hi' => 'रीफ़ और डाइविंग', 'ta' => 'பவளப்பாறை & நீச்சல்'],
        'Culture & heritage' => ['en' => 'Culture & heritage', 'hi' => 'संस्कृति और विरासत', 'ta' => 'பண்பாடு & பாரம்பரியம்'],
        'Group pilgrimage' => ['en' => 'Group pilgrimage', 'hi' => 'समूह तीर्थयात्रा', 'ta' => 'குழு புனிதப் பயணம்'],
        'Outbound holiday' => ['en' => 'Outbound holiday', 'hi' => 'आउटबाउंड हॉलिडे', 'ta' => 'வெளிநாட்டு விடுமுறை'],
        'Not sure yet' => ['en' => 'Not sure yet', 'hi' => 'अभी तय नहीं', 'ta' => 'இன்னும் முடிவு செய்யவில்லை'],
    ],

    'countries' => [
        'India' => ['en' => 'India', 'hi' => 'भारत', 'ta' => 'இந்தியா'],
        'Sri Lanka' => ['en' => 'Sri Lanka', 'hi' => 'श्रीलंका', 'ta' => 'இலங்கை'],
        'United Arab Emirates' => ['en' => 'United Arab Emirates', 'hi' => 'संयुक्त अरब अमीरात', 'ta' => 'ஐக்கிய அரபு அமீரகம்'],
        'Singapore' => ['en' => 'Singapore', 'hi' => 'सिंगापुर', 'ta' => 'சிங்கப்பூர்'],
        'Malaysia' => ['en' => 'Malaysia', 'hi' => 'मलेशिया', 'ta' => 'மலேசியா'],
        'United Kingdom' => ['en' => 'United Kingdom', 'hi' => 'यूनाइटेड किंगडम', 'ta' => 'ஐக்கிய இராச்சியம்'],
        'Australia' => ['en' => 'Australia', 'hi' => 'ऑस्ट्रेलिया', 'ta' => 'ஆஸ்திரேலியா'],
        'United States' => ['en' => 'United States', 'hi' => 'संयुक्त राज्य अमेरिका', 'ta' => 'அமெரிக்க ஐக்கிய நாடுகள்'],
        'Other' => ['en' => 'Other', 'hi' => 'अन्य', 'ta' => 'மற்றவை'],
    ],

    'dial_codes' => [
        '+91' => 'IN +91', '+94' => 'LK +94', '+971' => 'AE +971', '+65' => 'SG +65',
        '+60' => 'MY +60', '+44' => 'UK +44', '+61' => 'AU +61', '+1' => 'US +1',
    ],

];
