<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>Teniski klub Winner Smederevska Palanka | TK Winner — tereni i škola tenisa</title>
	<meta name="description" content="Teniski klub Winner u Smederevskoj Palanci — tri terena od šljake, balon za zimsku sezonu, škola tenisa za decu i odrasle, treninzi i klupski turniri. Online rezervacija termina.">
	<meta name="keywords" content="TK Winner, teniski klub Winner, tenis Smederevska Palanka, teniski klub Smederevska Palanka, škola tenisa Smederevska Palanka, rezervacija terena za tenis, balon tenis Palanka, treninzi tenisa, tereni od šljake">
	<meta name="author" content="Teniski klub Winner">
	<meta name="robots" content="index, follow, max-image-preview:large">

	{{-- Geo (Smederevska Palanka — koordinate sa Google Maps embed-a) --}}
	<meta name="geo.region" content="RS-12">
	<meta name="geo.placename" content="Smederevska Palanka">
	<meta name="geo.position" content="44.370589;20.952597">
	<meta name="ICBM" content="44.370589, 20.952597">

	<link rel="canonical" href="{{ url()->current() }}">

	{{-- Open Graph (Facebook, LinkedIn, Viber, ...) --}}
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="Teniski klub Winner">
	<meta property="og:title" content="Teniski klub Winner Smederevska Palanka — TK Winner">
	<meta property="og:description" content="Tri terena, balon za zimu, škola tenisa za sve uzraste. Online rezervacija termina u Smederevskoj Palanci.">
	<meta property="og:url" content="{{ url()->current() }}">
	<meta property="og:locale" content="sr_RS">
	<meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="630">
	<meta property="og:image:alt" content="Teniski klub Winner — Smederevska Palanka">

	{{-- Twitter Card --}}
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="Teniski klub Winner Smederevska Palanka — TK Winner">
	<meta name="twitter:description" content="Tri terena, balon za zimu, škola tenisa, online rezervacija termina.">
	<meta name="twitter:image" content="{{ asset('images/og-image.jpg') }}">

	{{-- Theme color (mobilni browseri) --}}
	<meta name="theme-color" content="#006439">

	{{-- Favicons i Web App Manifest --}}
	<link rel="icon" type="image/x-icon" href="/favicon.ico">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/svg+xml" href="/images/logo.svg">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="manifest" href="/site.webmanifest">

	{{-- JSON-LD: SportsClub structured data za bogate rezultate u pretrazi --}}
	@php
		$jsonLd = [
			'@context' => 'https://schema.org',
			'@type' => 'SportsClub',
			'name' => 'Teniski klub Winner',
			'alternateName' => ['TK Winner', 'Teniski klub Winner Smederevska Palanka'],
			'description' => 'Teniski klub Winner u Smederevskoj Palanci — tri terena od šljake, balon za zimsku sezonu, škola tenisa za decu i odrasle, treninzi i klupski turniri.',
			'url' => url('/'),
			'logo' => asset('images/logo.svg'),
			'image' => asset('images/naslovna.jpeg'),
			'telephone' => '+381642671518',
			'email' => 'goran.surjak71@gmail.com',
			'priceRange' => '$$',
			'address' => [
				'@type' => 'PostalAddress',
				'streetAddress' => 'Nadežde Petrović 27',
				'addressLocality' => 'Smederevska Palanka',
				'postalCode' => '11420',
				'addressCountry' => 'RS',
			],
			'geo' => [
				'@type' => 'GeoCoordinates',
				'latitude' => 44.370589,
				'longitude' => 20.952597,
			],
			'openingHoursSpecification' => [[
				'@type' => 'OpeningHoursSpecification',
				'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
				'opens' => '08:00',
				'closes' => '23:00',
			]],
			'sport' => 'Tennis',
			'amenityFeature' => [
				['@type' => 'LocationFeatureSpecification', 'name' => 'Tereni od šljake (otvoreni)'],
				['@type' => 'LocationFeatureSpecification', 'name' => 'Balon (zatvoreni teren za zimsku sezonu)'],
				['@type' => 'LocationFeatureSpecification', 'name' => 'Škola tenisa za decu i odrasle'],
				['@type' => 'LocationFeatureSpecification', 'name' => 'Iznajmljivanje terena i online rezervacija'],
			],
			'areaServed' => [
				['@type' => 'City', 'name' => 'Smederevska Palanka'],
				['@type' => 'City', 'name' => 'Velika Plana'],
				['@type' => 'City', 'name' => 'Kovačevac'],
				['@type' => 'AdministrativeArea', 'name' => 'Podunavski okrug'],
			],
		];
	@endphp
	<script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

	<style>
		*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
		:root {
			--brand: #ea580c;
			--brand-2: #f97316;
			--brand-soft: #fff7ed;
			--ink: #0c0a09;
			--ink-2: #292524;
			--ink-3: #44403c;
			--muted: #78716c;
			--surface: #fafaf9;
			--surface-2: #ffffff;
			--line: #e7e5e4;
			--success: #16a34a;
			--danger: #dc2626;
			--radius: 16px;
			--radius-lg: 24px;
			--shadow-sm: 0 1px 2px rgba(12,10,9,.05), 0 1px 3px rgba(12,10,9,.06);
			--shadow: 0 10px 25px -5px rgba(12,10,9,.08), 0 8px 10px -6px rgba(12,10,9,.04);
			--shadow-lg: 0 20px 40px -12px rgba(12,10,9,.18);
		}
		html { scroll-behavior: smooth; overflow-x: clip; }
		body {
			font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
			color: var(--ink);
			background: var(--surface);
			line-height: 1.6;
			-webkit-font-smoothing: antialiased;
			overflow-x: clip;
		}
		body.modal-open { position: fixed; left: 0; right: 0; width: 100%; overflow: hidden; }
		a { color: inherit; text-decoration: none; }
		img { display: block; max-width: 100%; height: auto; }
		button { font: inherit; cursor: pointer; border: 0; background: transparent; }
		section { scroll-margin-top: 80px; }
		.container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

		/* ===== NAV ===== */
		.nav { position: fixed; top: 0; left: 0; right: 0; z-index: 50; transition: background .3s ease, border-color .3s ease; }
		.nav-inner { display: flex; align-items: center; justify-content: space-between; padding: 18px 24px; max-width: 1200px; margin: 0 auto; }
		.brand { display: flex; align-items: center; gap: 12px; font-weight: 800; color: #fff; letter-spacing: -.02em; font-size: 18px; }
		.brand-mark { width: 42px; height: 42px; border-radius: 50%; background: linear-gradient(135deg, var(--brand), var(--brand-2)); display: inline-flex; align-items: center; justify-content: center; color: #fff; font-size: 20px; box-shadow: 0 8px 16px rgba(234,88,12,.35); }
		.brand small { display: block; font-size: 11px; font-weight: 500; opacity: .75; letter-spacing: .08em; text-transform: uppercase; }
		.nav-links { display: flex; gap: 28px; align-items: center; }
		.nav-link { color: rgba(255,255,255,.82); font-weight: 500; font-size: 14px; transition: color .2s; }
		.nav-link:hover { color: #fff; }
		.btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; font-weight: 600; font-size: 14px; border-radius: 999px; padding: 12px 22px; transition: transform .2s, box-shadow .2s, background .2s; white-space: nowrap; }
		.btn-primary { background: linear-gradient(135deg, var(--brand), var(--brand-2)); color: #fff; box-shadow: 0 10px 22px rgba(234,88,12,.32); }
		.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 14px 28px rgba(234,88,12,.42); }
		.btn-primary:disabled { opacity: .55; cursor: not-allowed; transform: none; box-shadow: 0 6px 16px rgba(234,88,12,.22); }
		.btn-ghost { background: rgba(255,255,255,.08); color: #fff; border: 1px solid rgba(255,255,255,.18); backdrop-filter: blur(8px); }
		.btn-ghost:hover { background: rgba(255,255,255,.14); border-color: rgba(255,255,255,.3); }
		.btn-outline { background: transparent; color: var(--ink); border: 1.5px solid var(--line); }
		.btn-outline:hover { background: #fff; border-color: var(--ink); }
		.btn-lg { padding: 16px 32px; font-size: 15px; }
		.nav.scrolled { background: rgba(12,10,9,.88); backdrop-filter: blur(14px); border-bottom: 1px solid rgba(255,255,255,.06); }
		.nav-toggle { display: none; color: #fff; padding: 8px; }
		.nav-toggle svg { width: 26px; height: 26px; }
		@media (max-width: 900px) {
			.nav-links { display: none; }
			.nav-toggle { display: block; }
			.nav-links.open {
				display: flex; flex-direction: column; align-items: stretch;
				position: absolute; top: 100%; left: 0; right: 0;
				background: rgba(12,10,9,.96); backdrop-filter: blur(14px);
				padding: 20px 24px 24px; gap: 16px; border-bottom: 1px solid rgba(255,255,255,.08);
			}
			.nav-links.open .nav-link { font-size: 16px; padding: 6px 0; }
			.nav-links.open .btn { width: 100%; }
		}

		/* ===== HERO ===== */
		.hero { position: relative; min-height: 100vh; display: flex; align-items: center; color: #fff; overflow: hidden; }
		.hero-bg { position: absolute; inset: 0; background-image: url('/images/naslovna.jpeg'); background-size: cover; background-position: center; filter: saturate(1.05); }
		.hero-overlay { position: absolute; inset: 0; background: linear-gradient(135deg, rgba(12,10,9,.82) 0%, rgba(12,10,9,.65) 55%, rgba(234,88,12,.45) 100%); }
		.hero-inner { position: relative; z-index: 2; padding: 120px 24px 80px; width: 100%; max-width: 1200px; margin: 0 auto; }
		.hero-eyebrow { display: inline-flex; align-items: center; gap: 10px; padding: 8px 16px; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); border-radius: 999px; font-size: 13px; font-weight: 500; backdrop-filter: blur(8px); margin-bottom: 24px; }
		.hero-eyebrow::before { content: ''; width: 8px; height: 8px; background: var(--brand-2); border-radius: 50%; box-shadow: 0 0 0 4px rgba(249,115,22,.25); }
		.hero h1 { font-size: clamp(40px, 7vw, 84px); font-weight: 900; line-height: 1; letter-spacing: -.03em; margin-bottom: 24px; max-width: 900px; }
		.hero h1 .accent { background: linear-gradient(135deg, #fdba74, #f97316); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
		.hero-sub { font-size: clamp(16px, 1.4vw, 19px); max-width: 620px; opacity: .92; margin-bottom: 40px; font-weight: 400; }
		.hero-actions { display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 72px; }
		.hero-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px; max-width: 780px; padding: 28px; background: rgba(255,255,255,.06); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,.14); border-radius: 20px; }
		.hero-stat { text-align: left; }
		.hero-stat-num { font-size: 32px; font-weight: 800; letter-spacing: -.02em; line-height: 1; }
		.hero-stat-num .plus { color: var(--brand-2); }
		.hero-stat-label { font-size: 13px; opacity: .8; margin-top: 6px; font-weight: 500; }
		@media (max-width: 640px) {
			.hero-inner { padding-top: 110px; padding-bottom: 60px; }
			.hero-actions { flex-direction: column; align-items: stretch; }
			.hero-actions .btn { width: 100%; }
			.hero-stats { padding: 20px; gap: 16px; }
			.hero-stat-num { font-size: 26px; }
		}

		/* ===== SECTIONS ===== */
		.section { padding: 100px 0; }
		.section-soft { background: var(--surface-2); }
		.section-cream { background: var(--brand-soft); }
		.eyebrow { display: inline-block; font-size: 13px; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: var(--brand); margin-bottom: 14px; }
		.h2 { font-size: clamp(30px, 4.2vw, 48px); font-weight: 800; letter-spacing: -.02em; line-height: 1.1; color: var(--ink); margin-bottom: 16px; }
		.lead { font-size: 17px; color: var(--muted); max-width: 640px; }
		.section-header { text-align: center; max-width: 700px; margin: 0 auto 64px; }
		.section-header .lead { margin: 0 auto; }
		@media (max-width: 640px) {
			.section { padding: 72px 0; }
			.section-header { margin-bottom: 44px; }
		}

		/* ===== ABOUT ===== */
		.about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 72px; align-items: center; }
		.about-img { position: relative; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg); aspect-ratio: 4/5; }
		.about-img img { width: 100%; height: 100%; object-fit: cover; }
		.about-img::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, transparent 50%, rgba(12,10,9,.2)); }
		.about-float { position: absolute; bottom: 24px; left: 24px; right: 24px; padding: 18px 22px; background: rgba(255,255,255,.95); backdrop-filter: blur(12px); border-radius: 16px; display: flex; align-items: center; gap: 16px; box-shadow: var(--shadow); }
		.about-float-num { font-size: 30px; font-weight: 800; color: var(--brand); line-height: 1; letter-spacing: -.02em; }
		.about-float-text { font-size: 13px; color: var(--ink-2); font-weight: 500; }
		.features { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 32px; }
		.feature { padding: 20px; border-radius: 16px; background: var(--surface); border: 1px solid var(--line); transition: transform .2s, border-color .2s; }
		.feature:hover { transform: translateY(-3px); border-color: var(--brand); }
		.feature-icon { width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, var(--brand), var(--brand-2)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 20px; margin-bottom: 12px; box-shadow: 0 6px 14px rgba(234,88,12,.25); }
		.feature h3 { font-size: 15px; font-weight: 700; margin-bottom: 4px; }
		.feature p { font-size: 13px; color: var(--muted); line-height: 1.5; }
		@media (max-width: 900px) {
			.about-grid { grid-template-columns: 1fr; gap: 48px; }
			.about-img { max-width: 520px; margin: 0 auto; aspect-ratio: 5/4; }
			.features { grid-template-columns: 1fr; }
		}

		/* ===== COURTS ===== */
		.courts-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 28px; }
		.court-card { background: #fff; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm); border: 1px solid var(--line); transition: transform .3s, box-shadow .3s; display: flex; flex-direction: column; }
		.court-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
		.court-card-img { aspect-ratio: 16/10; overflow: hidden; position: relative; }
		.court-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
		.court-card:hover .court-card-img img { transform: scale(1.05); }
		.court-card-tag { position: absolute; top: 16px; left: 16px; padding: 6px 12px; background: rgba(255,255,255,.95); backdrop-filter: blur(6px); border-radius: 999px; font-size: 12px; font-weight: 600; color: var(--brand); }
		.court-card-body { padding: 28px; display: flex; flex-direction: column; gap: 12px; flex: 1; }
		.court-card h3 { font-size: 22px; font-weight: 800; letter-spacing: -.01em; }
		.court-card p { color: var(--muted); font-size: 14px; }
		.court-card-meta { display: flex; gap: 16px; color: var(--ink-3); font-size: 13px; font-weight: 500; padding: 12px 0; border-top: 1px solid var(--line); margin-top: auto; }
		.court-card-meta span { display: inline-flex; align-items: center; gap: 6px; }
		.court-card-btn { width: 100%; margin-top: 8px; }

		/* ===== STATS ===== */
		.stats-strip { background: var(--ink); color: #fff; padding: 60px 0; }
		.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 32px; text-align: center; }
		.stats-grid .s-num { font-size: clamp(36px, 5vw, 56px); font-weight: 900; letter-spacing: -.03em; line-height: 1; background: linear-gradient(135deg, #fdba74, #f97316); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
		.stats-grid .s-label { font-size: 13px; opacity: .7; margin-top: 10px; font-weight: 500; letter-spacing: .04em; text-transform: uppercase; }

		/* ===== GALLERY ===== */
		.gallery-grid { display: grid; grid-template-columns: repeat(4, 1fr); grid-auto-rows: 220px; gap: 14px; }
		.gallery-item { border-radius: 16px; overflow: hidden; position: relative; cursor: pointer; }
		.gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
		.gallery-item:hover img { transform: scale(1.08); }
		.gallery-item::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, transparent 60%, rgba(12,10,9,.45)); opacity: 0; transition: opacity .3s; }
		.gallery-item:hover::after { opacity: 1; }
		.gallery-item.large { grid-column: span 2; grid-row: span 2; }
		.gallery-item.gallery-hidden { display: none; }
		.gallery-more-wrap { text-align: center; margin-top: 40px; }
		@media (max-width: 900px) {
			.gallery-grid { grid-template-columns: repeat(2, 1fr); grid-auto-rows: 180px; }
			.gallery-item.large { grid-column: span 2; grid-row: span 1; }
		}
		/* Lightbox */
		.lb-backdrop { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.88); z-index: 2000; align-items: center; justify-content: center; overscroll-behavior: contain; touch-action: none; }
		.lb-backdrop.open { display: flex; }
		.lb-img { max-width: 90vw; max-height: 82vh; object-fit: contain; border-radius: 10px; box-shadow: 0 8px 40px rgba(0,0,0,.6); user-select: none; display: block; }
		.lb-close { position: fixed; top: 18px; right: 22px; background: rgba(255,255,255,.15); border: none; color: #fff; font-size: 28px; width: 46px; height: 46px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background .2s; z-index: 2001; }
		.lb-close:hover { background: rgba(255,255,255,.3); }
		.lb-arrow { position: fixed; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,.15); border: none; color: #fff; font-size: 30px; line-height: 1; width: 52px; height: 52px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background .2s; z-index: 2001; }
		.lb-arrow:hover { background: rgba(255,255,255,.3); }
		.lb-prev { left: 18px; }
		.lb-next { right: 18px; }
		.lb-counter { position: fixed; bottom: 22px; left: 50%; transform: translateX(-50%); color: rgba(255,255,255,.75); font-size: 14px; letter-spacing: .5px; z-index: 2001; }
		@media (max-width: 600px) { .lb-prev { left: 8px; } .lb-next { right: 8px; } }

		/* ===== TESTIMONIALS ===== */
		.t-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 28px; }
		.t-card { background: #fff; border-radius: var(--radius-lg); padding: 32px; border: 1px solid var(--line); box-shadow: var(--shadow-sm); display: flex; flex-direction: column; gap: 18px; }
		.t-quote { font-size: 30px; color: var(--brand); line-height: 1; font-weight: 900; }
		.t-text { color: var(--ink-2); font-size: 15px; line-height: 1.65; flex: 1; }
		.t-author { display: flex; align-items: center; gap: 14px; padding-top: 18px; border-top: 1px solid var(--line); }
		.t-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }
		.t-name { font-weight: 700; font-size: 14px; }
		.t-role { font-size: 12px; color: var(--muted); }
		.t-stars { display: flex; gap: 2px; color: #f59e0b; }

		/* ===== CONTACT ===== */
		.contact-grid { display: grid; grid-template-columns: 1fr 1.2fr; gap: 48px; align-items: stretch; }
		.contact-grid > * { min-width: 0; }
		.contact-info { padding: 40px; border-radius: var(--radius-lg); background: var(--ink); color: #fff; display: flex; flex-direction: column; gap: 24px; min-width: 0; }
		.contact-info h3 { font-size: 24px; font-weight: 800; letter-spacing: -.01em; }
		.contact-info p { color: rgba(255,255,255,.75); font-size: 14px; }
		.contact-item { display: flex; gap: 16px; align-items: flex-start; padding: 14px 0; border-top: 1px solid rgba(255,255,255,.1); min-width: 0; }
		.contact-item > div:not(.contact-icon) { min-width: 0; flex: 1; }
		.contact-item:first-of-type { border-top: 0; }
		.contact-icon { width: 40px; height: 40px; border-radius: 10px; background: rgba(234,88,12,.15); color: var(--brand-2); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
		.contact-label { font-size: 12px; opacity: .65; text-transform: uppercase; letter-spacing: .08em; }
		.contact-value { font-size: 15px; font-weight: 500; margin-top: 2px; overflow-wrap: anywhere; word-break: break-word; }
		.contact-value a:hover { color: var(--brand-2); }
		.contact-map { border-radius: var(--radius-lg); overflow: hidden; min-height: 400px; border: 1px solid var(--line); background: var(--surface); min-width: 0; }
		.contact-map iframe { width: 100%; height: 100%; min-height: 400px; border: 0; display: block; }
		@media (max-width: 900px) {
			.contact-grid { grid-template-columns: 1fr; gap: 24px; }
			.contact-info { padding: 28px 22px; }
		}

		/* ===== FOOTER ===== */
		footer { background: #0c0a09; color: rgba(255,255,255,.7); padding: 60px 0 30px; }
		.footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 40px; margin-bottom: 48px; }
		footer h4 { color: #fff; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; margin-bottom: 18px; }
		footer a { display: block; padding: 4px 0; font-size: 14px; color: rgba(255,255,255,.65); transition: color .2s; }
		footer a:hover { color: var(--brand-2); }
		.footer-brand { font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 12px; display: flex; align-items: center; gap: 12px; }
		.footer-desc { font-size: 14px; line-height: 1.6; margin-bottom: 20px; max-width: 340px; }
		.social { display: flex; gap: 10px; }
		.social a { width: 38px; height: 38px; border-radius: 10px; background: rgba(255,255,255,.06); display: flex; align-items: center; justify-content: center; padding: 0; color: rgba(255,255,255,.75); }
		.social a:hover { background: var(--brand); color: #fff; }
		.footer-bottom { border-top: 1px solid rgba(255,255,255,.08); padding-top: 24px; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 12px; font-size: 13px; }
		@media (max-width: 900px) { .footer-grid { grid-template-columns: 1fr 1fr; } .footer-grid > div:first-child { grid-column: 1 / -1; } }
		@media (max-width: 560px) { .footer-grid { grid-template-columns: 1fr; gap: 32px; } .footer-grid > div:first-child { grid-column: auto; } }

		/* ===== MODAL ===== */
		.modal-backdrop { position: fixed; inset: 0; z-index: 100; background: rgba(12,10,9,.6); backdrop-filter: blur(8px); display: none; align-items: center; justify-content: center; padding: 20px; opacity: 0; transition: opacity .25s; }
		.modal-backdrop.open { display: flex; opacity: 1; }
		.modal-card { width: 100%; max-width: 720px; max-height: 92vh; background: #fff; border-radius: 24px; box-shadow: 0 30px 70px rgba(0,0,0,.35); overflow: hidden; display: flex; flex-direction: column; transform: translateY(20px); transition: transform .3s; }
		.modal-backdrop.open .modal-card { transform: translateY(0); }
		.modal-header { padding: 22px 28px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--line); flex-shrink: 0; }
		.modal-title { font-weight: 800; font-size: 20px; letter-spacing: -.01em; }
		.modal-subtitle { font-size: 13px; color: var(--muted); margin-top: 2px; }
		.modal-close { width: 38px; height: 38px; border-radius: 10px; background: var(--surface); color: var(--ink-2); display: flex; align-items: center; justify-content: center; transition: background .2s, color .2s; }
		.modal-close:hover { background: #fee2e2; color: var(--danger); }
		.modal-body { padding: 28px; overflow-y: auto; flex: 1; overscroll-behavior: contain; -webkit-overflow-scrolling: touch; }
		@media (max-width: 640px) {
			.modal-backdrop { padding: 0; align-items: stretch; height: 100vh; height: 100dvh; }
			.modal-card { max-height: 100vh; max-height: 100dvh; height: 100vh; height: 100dvh; max-width: 100%; border-radius: 0; }
			.modal-body { padding: 20px; padding-bottom: max(20px, env(safe-area-inset-bottom)); }
		}

		/* ===== BOOKING FORM (inside modal) ===== */
		.progress { display: flex; gap: 8px; margin-bottom: 24px; align-items: center; overflow-x: auto; padding-bottom: 4px; }
		.progress::-webkit-scrollbar { display: none; }
		.p-item { display: inline-flex; align-items: center; gap: 6px; font-weight: 600; font-size: 12px; color: var(--muted); padding: 8px 14px; border-radius: 999px; background: var(--surface); border: 1px solid var(--line); white-space: nowrap; flex-shrink: 0; transition: all .2s; }
		.p-item.active { color: #fff; background: linear-gradient(135deg, var(--brand), var(--brand-2)); border-color: transparent; box-shadow: 0 6px 14px rgba(234,88,12,.25); }
		.p-item.done { color: var(--brand); background: var(--brand-soft); border-color: #fed7aa; }
		.step-box { }
		.step-title { font-weight: 800; font-size: 18px; letter-spacing: -.01em; margin-bottom: 18px; color: var(--ink); }
		.row { margin-bottom: 16px; }
		.label { display: block; font-weight: 600; margin-bottom: 8px; color: var(--ink-2); font-size: 13px; }
		.select, .input { width: 100%; padding: 14px 16px; border: 1.5px solid var(--line); border-radius: 12px; background: #fff; font-size: 16px; color: var(--ink); transition: border-color .2s, box-shadow .2s; font-family: inherit; }
		.select:focus, .input:focus { outline: none; border-color: var(--brand); box-shadow: 0 0 0 4px rgba(234,88,12,.1); }
		.select { appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2378716c' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 16px center; padding-right: 44px; }
		.button-row { display: flex; gap: 12px; justify-content: space-between; align-items: center; margin-top: 20px; flex-wrap: wrap; }
		.button-row.center { justify-content: center; }
		.btn-step { padding: 13px 22px; border-radius: 12px; font-weight: 600; font-size: 14px; transition: all .2s; display: inline-flex; align-items: center; gap: 8px; }
		.btn-step-primary { background: linear-gradient(135deg, var(--brand), var(--brand-2)); color: #fff; box-shadow: 0 8px 18px rgba(234,88,12,.28); }
		.btn-step-primary:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(234,88,12,.38); }
		.btn-step-primary:disabled { opacity: .45; cursor: not-allowed; box-shadow: none; transform: none; }
		.btn-step-secondary { background: var(--surface); color: var(--ink-2); border: 1.5px solid var(--line); }
		.btn-step-secondary:hover { background: #fff; border-color: var(--ink-3); }
		.hidden { display: none !important; }
		.times-wrap { display: grid; grid-template-columns: repeat(auto-fill, minmax(92px, 1fr)); gap: 10px; margin-top: 12px; }
		.waitlist-bubble { position: relative; margin: 16px 0 4px; padding: 14px 16px 14px 48px; border-radius: 14px; background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%); border: 1px solid #fed7aa; color: #7c2d12; font-size: 13px; line-height: 1.5; box-shadow: 0 4px 12px rgba(234,88,12,.08); }
		.waitlist-bubble::before { content: '📞'; position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-size: 20px; }
		.waitlist-bubble a { color: #9a3412; font-weight: 700; text-decoration: none; white-space: nowrap; }
		.waitlist-bubble a:hover { text-decoration: underline; }
		.time-badge { padding: 12px 10px; border-radius: 12px; background: #fff; border: 1.5px solid var(--line); text-align: center; font-weight: 600; font-size: 14px; color: var(--ink-2); cursor: pointer; transition: border-color .15s, color .15s, background .15s, box-shadow .15s, transform .15s; user-select: none; -webkit-tap-highlight-color: transparent; touch-action: manipulation; }
		@media (hover: hover) and (pointer: fine) {
			.time-badge:hover { border-color: var(--brand); color: var(--brand); transform: translateY(-2px); }
		}
		.time-badge:active:not(.active) { border-color: var(--brand); color: var(--brand); background: var(--brand-soft); }
		.time-badge.active { background: linear-gradient(135deg, var(--brand), var(--brand-2)); color: #fff; border-color: transparent; box-shadow: 0 8px 18px rgba(234,88,12,.3); }
		.alert { padding: 14px 16px; border-radius: 12px; margin-bottom: 16px; font-size: 13px; font-weight: 500; }
		.alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
		.alert-info { background: var(--brand-soft); color: #9a3412; border: 1px solid #fed7aa; display: flex; align-items: center; gap: 10px; }
		.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
		@media (max-width: 520px) { .two-col { grid-template-columns: 1fr; } }
		.spinner { width: 20px; height: 20px; border: 2.5px solid var(--line); border-top-color: var(--brand); border-radius: 50%; animation: spin 1s linear infinite; display: inline-block; }
		.spinner.lg { width: 44px; height: 44px; border-width: 3px; }
		@keyframes spin { to { transform: rotate(360deg); } }
		.times-loading { display: flex; justify-content: center; padding: 28px 0; }

		/* Flatpickr overrides */
		.flatpickr-wrapper { display: block !important; width: 100%; position: relative; }
		.flatpickr-calendar { border-radius: 16px !important; box-shadow: var(--shadow-lg) !important; border: 1px solid var(--line) !important; font-family: inherit !important; z-index: 1001 !important; }
		.flatpickr-calendar.static { width: 100%; max-width: 100%; }
		.flatpickr-calendar.static.open { left: 0 !important; right: 0 !important; }
		.flatpickr-day.selected, .flatpickr-day.selected:hover { background: linear-gradient(135deg, var(--brand), var(--brand-2)) !important; border-color: transparent !important; color: #fff !important; }
		.flatpickr-day:hover { background: var(--brand-soft) !important; border-color: #fed7aa !important; }
		.flatpickr-day.today { border-color: var(--brand) !important; }
		.flatpickr-months .flatpickr-prev-month:hover svg, .flatpickr-months .flatpickr-next-month:hover svg { fill: var(--brand) !important; }

		/* TOAST */
		.toast { position: fixed; top: 24px; right: 24px; z-index: 200; padding: 16px 20px; background: #fff; border-radius: 16px; box-shadow: var(--shadow-lg); display: flex; align-items: center; gap: 14px; max-width: 380px; border-left: 4px solid var(--success); transform: translateX(calc(100% + 40px)); transition: transform .35s cubic-bezier(.2,.8,.2,1); }
		.toast.show { transform: translateX(0); }
		.toast.error { border-left-color: var(--danger); }
		.toast-icon { width: 36px; height: 36px; border-radius: 50%; background: #dcfce7; color: var(--success); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
		.toast.error .toast-icon { background: #fee2e2; color: var(--danger); }
		.toast-text { font-size: 14px; font-weight: 500; color: var(--ink); line-height: 1.4; }
		.toast-title { font-weight: 700; margin-bottom: 2px; }
		@media (max-width: 520px) { .toast { top: 16px; right: 16px; left: 16px; max-width: none; transform: translateY(calc(-100% - 20px)); } .toast.show { transform: translateY(0); } }

		/* UTIL */
		.fade-in { animation: fadeIn .6s ease both; }
		@keyframes fadeIn { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
	</style>
</head>
<body>
	{{-- ============ NAV ============ --}}
	<header class="nav" id="nav">
		<div class="nav-inner">
			<a href="#home" class="brand">
                <img src="{{ asset('images/logo.svg') }}" alt="TK Winner Logo" style="height: 55px;">
			</a>
			<nav class="nav-links" id="navLinks">
				<a href="#about" class="nav-link">O klubu</a>
				<a href="#courts" class="nav-link">Tereni</a>
				<a href="#gallery" class="nav-link">Galerija</a>
				<a href="#testimonials" class="nav-link">Recenzije</a>
				<a href="#contact" class="nav-link">Kontakt</a>
				<button type="button" class="btn btn-primary" data-open-modal>Rezerviši termin</button>
			</nav>
			<button type="button" class="nav-toggle" id="navToggle" aria-label="Meni">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></svg>
			</button>
		</div>
	</header>

	{{-- ============ HERO ============ --}}
	<section id="home" class="hero">
		<div class="hero-bg"></div>
		<div class="hero-overlay"></div>
		<div class="hero-inner">
			<span class="hero-eyebrow">Teniski klub Winner · Smederevska Palanka</span>
			<h1>Igraj tenis. Uživaj. <span class="accent">Pobedi.</span></h1>
			<p class="hero-sub">Teniski klub Winner u Smederevskoj Palanci. Tri terena od šljake, balon za zimsku sezonu i škola tenisa. Rezerviši termin online u par klikova.</p>
			<div class="hero-actions">
				<button type="button" class="btn btn-primary btn-lg" data-open-modal>
					Rezerviši termin
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
				</button>
				<a href="#about" class="btn btn-ghost btn-lg">Saznaj više</a>
			</div>

			<div class="hero-stats">
				<div class="hero-stat">
					<div class="hero-stat-num">100<span class="plus">+</span></div>
					<div class="hero-stat-label">Članova</div>
				</div>
				<div class="hero-stat">
					<div class="hero-stat-num">20<span class="plus">+</span></div>
					<div class="hero-stat-label">Godina iskustva</div>
				</div>
				<div class="hero-stat">
					<div class="hero-stat-num">3</div>
					<div class="hero-stat-label">Terena</div>
				</div>
				<div class="hero-stat">
					<div class="hero-stat-num">10<span class="plus">+</span></div>
					<div class="hero-stat-label">Turnira godišnje</div>
				</div>
			</div>
		</div>
	</section>

	{{-- ============ ABOUT ============ --}}
	<section id="about" class="section">
		<div class="container">
			<div class="about-grid">
				<div>
					<span class="eyebrow">O našem klubu</span>
					<h2 class="h2">Mesto gde tenis postaje stil života</h2>
					<p class="lead" style="margin-bottom:20px">TK Winner okuplja ljubitelje tenisa iz Smederevske Palanke i okoline već više od 20 godina. Nismo veliki klub, ali baš zato kod nas vlada opuštena i prijateljska atmosfera — svi se međusobno znamo.</p>
					<p style="color:var(--ink-3);font-size:15px">Imamo tri terena od šljake, od kojih je jedan pokriven balonom pa se igra i tokom zime. Većina naših članova počela je kao potpuni početnici, a trenere imamo upravo zato da svako pronađe svoj put kroz tenis.</p>

					<div class="features">
						<div class="feature">
							<div class="feature-icon">🏆</div>
							<h3>Iskusni treneri</h3>
						</div>
						<div class="feature">
							<div class="feature-icon">🎾</div>
							<h3>Tri terena, cele godine</h3>
						</div>
						<div class="feature">
							<div class="feature-icon">👥</div>
							<h3>Za sve uzraste</h3>
						</div>
						<div class="feature">
							<div class="feature-icon">⚡</div>
							<h3>Turniri i druženja</h3>
						</div>
					</div>
				</div>
				<div class="about-img">
					<img src="/images/oklubu.jpeg" alt="Teniski klub Winner">
					<div class="about-float">
						<div class="about-float-num">4.5</div>
						<div>
							<div class="about-float-text" style="font-weight:700;color:var(--ink)">Prosečna ocena</div>
							<div class="about-float-text">Na osnovu 32 recenzije</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	{{-- ============ COURTS ============ --}}
	<section id="courts" class="section section-soft">
		<div class="container">
			<div class="section-header">
				<span class="eyebrow">Naši tereni</span>
				<h2 class="h2">Odaberi teren po meri</h2>
				<p class="lead">Tri terena za različite potrebe i godišnja doba. Sva tri su od šljake, podloga koja se kod nas najčešće igra.</p>
			</div>

			<div class="courts-grid">
				@php
					// Redosled je alfabetski po nazivu terena (Hala (balon), Teren 1, Teren 2)
					$courtImgs = ['/images/balon.jpg', '/images/teren1.jpeg', '/images/teren2.jpeg'];
					$courtDescs = [
						'Zatvoreni teren pod balonom, otvoren tokom cele godine. Idealan za zimsku sezonu, kišne dane i kasne večernje termine kada otvoreni tereni nisu dostupni.',
						'Otvoren teren od šljake u gornjem delu kompleksa. Najsunčaniji u poslepodnevnim satima i omiljen među članovima koji vole letnju, sporiju igru.',
						'Donji teren, mirniji kraj kluba i lepo zaštićen od vetra. Često se koristi za individualne treninge i početničke časove škole tenisa.',
					];
				@endphp
				@foreach($courts as $i => $court)
					<article class="court-card">
						<div class="court-card-img">
							<img src="{{ $courtImgs[$i % count($courtImgs)] }}" alt="{{ $court->name }} — Teniski klub Winner Smederevska Palanka">
							<span class="court-card-tag">Dostupno online</span>
						</div>
						<div class="court-card-body">
							<h3>{{ $court->name }}</h3>
							<div class="court-card-meta">
								<span>📍 {{ $court->location }}</span>
								<span>⏱ 60 / 90 / 120 min</span>
							</div>
							<button type="button" class="btn btn-primary court-card-btn" data-open-modal data-court="{{ $court->id }}">Rezerviši ovaj teren</button>
						</div>
					</article>
				@endforeach
			</div>
		</div>
	</section>

	{{-- ============ STATS STRIP ============ --}}
	<section class="stats-strip">
		<div class="container">
			<div class="stats-grid">
				<div>
					<div class="s-num">100+</div>
					<div class="s-label">Aktivnih članova</div>
				</div>
				<div>
					<div class="s-num">20+</div>
					<div class="s-label">Godina rada</div>
				</div>
				<div>
					<div class="s-num">300+</div>
					<div class="s-label">Završenih treninga</div>
				</div>
				<div>
					<div class="s-num">10+</div>
					<div class="s-label">Turnira godišnje</div>
				</div>
				<div>
					<div class="s-num">3</div>
					<div class="s-label">Profi terena</div>
				</div>
			</div>
		</div>
	</section>

	{{-- ============ GALLERY ============ --}}
	<section id="gallery" class="section">
		<div class="container">
			<div class="section-header">
				<span class="eyebrow">Galerija</span>
				<h2 class="h2">Atmosfera iz našeg kluba</h2>
				<p class="lead">Slike sa terena, treninga i klupskih dešavanja. Najbolje da dođete uživo, ali i fotografije nešto kažu.</p>
			</div>
			@php
				$galleryImages = [
					'galeria32.jpeg','galeria25.jpeg','galeria11.jpeg','galeria6.jpg',
					'galeria30.jpeg','galeria28.jpeg','galeria9.jpg','galeria24.jpeg',
					'galeria15.jpeg','galeria13.jpeg','galeria29.jpeg','galeria23.jpeg',
					'galeria35.jpeg','galeria16.jpeg','galeria1.jpg','galeria20.jpeg',
					'galeria31.jpeg','galeria8.jpg','galeria22.jpeg','galeria14.jpeg',
					'galeria3.jpg','galeria7.jpg','galeria17.jpeg','galeria2.jpg',
					'galeria19.jpeg','galeria33.jpeg','galeria18.jpeg','galeria27.jpeg',
					'galeria5.jpg','galeria4.jpg','galeria26.jpeg','galeria10.jpeg',
					'galeria21.jpeg',
				];
			@endphp
			<div class="gallery-grid" id="galleryGrid">
				@foreach($galleryImages as $i => $img)
					<div class="gallery-item {{ $i === 0 ? 'large' : '' }} {{ $i >= 9 ? 'gallery-hidden' : '' }}" data-lb="{{ $i }}">
						<img src="/images/{{ $img }}" alt="Galerija TK Winner" loading="lazy">
					</div>
				@endforeach
			</div>
			<div class="gallery-more-wrap">
				<button id="galleryLoadMore" class="btn btn-primary btn-lg">Učitaj još</button>
			</div>
		</div>
	</section>

	{{-- ============ TESTIMONIALS ============ --}}
	<section id="testimonials" class="section section-cream">
		<div class="container">
			<div class="section-header">
				<span class="eyebrow">Recenzije</span>
				<h2 class="h2">Šta kažu naši članovi</h2>
				<p class="lead">Iskustva članova koji godinama dolaze na terene Teniskog kluba Winner.</p>
			</div>
			<div class="t-grid">
				@php
					$testimonials = [
						['name' => 'Goran Milicic', 'role' => 'Član kluba', 'seed' => 'p1', 'text' => 'Odličan trener i veoma ljubazno osoblje. Sjajan objekat smešten usred prirode.'],
						['name' => 'Ana Petrović', 'role' => 'Rekreativka', 'seed' => 'p2', 'text' => 'Počela sam tenis sa 35 i iskreno, prijalo mi je više nego što sam očekivala. Sad igram redovno i baš se radujem svakom dolasku na teren.'],
						['name' => 'Stefan Nikolić', 'role' => 'Takmičar', 'seed' => 'p3', 'text' => 'Tenis treniram od desete, danas imam 16. TK Winner mi je kao drugi dom — tu sam napravio prve korake i odigrao prve turnire. Vidi se napredak iz godine u godinu.'],
					];
				@endphp
				@foreach($testimonials as $t)
					<div class="t-card">
						<div class="t-stars">
							<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
						</div>
						<div class="t-quote">“</div>
						<p class="t-text">{{ $t['text'] }}</p>
						<div class="t-author">
							<img class="t-avatar" src="https://picsum.photos/seed/{{ $t['seed'] }}/100/100" alt="{{ $t['name'] }}">
							<div>
								<div class="t-name">{{ $t['name'] }}</div>
								<div class="t-role">{{ $t['role'] }}</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>

	{{-- ============ CONTACT ============ --}}
	<section id="contact" class="section">
		<div class="container">
			<div class="section-header">
				<span class="eyebrow">Kontakt</span>
				<h2 class="h2">Posetite nas ili nas kontaktirajte</h2>
				<p class="lead">Najlakše ćete nas naći na adresi Nadežde Petrović 27 u Smederevskoj Palanci. Pozovite ako imate pitanja oko termina, treninga ili učlanjenja u TK Winner.</p>
			</div>

			<div class="contact-grid">
				<div class="contact-info">
					<div>
						<h3>Teniski klub Winner</h3>
						<p>Tu smo za tebe svakog dana. Pozovi ili dođi — dogovorićemo termin, trening ili samo kafu pored terena.</p>
					</div>

					<div class="contact-item">
						<div class="contact-icon">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
						</div>
						<div>
							<div class="contact-label">Adresa</div>
							<div class="contact-value">Nadežde Petrović 27, Smederevska Palanka</div>
						</div>
					</div>

					<div class="contact-item">
						<div class="contact-icon">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.37 1.9.72 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.59 2.81.72A2 2 0 0 1 22 16.92z"/></svg>
						</div>
						<div>
							<div class="contact-label">Telefon</div>
							<div class="contact-value"><a href="tel:+381642671518">+381 64 267 15 18</a></div>
						</div>
					</div>

					<div class="contact-item">
						<div class="contact-icon">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
						</div>
						<div>
							<div class="contact-label">Email</div>
							<div class="contact-value"><a href="mailto:goran.surjak71@gmail.com">goran.surjak71@gmail.com</a></div>
						</div>
					</div>

					<div class="contact-item">
						<div class="contact-icon">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
						</div>
						<div>
							<div class="contact-label">Radno vreme</div>
							<div class="contact-value">Pon–Ned · 08:00 – 23:00</div>
						</div>
					</div>
				</div>

				<div class="contact-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d19418.198069758644!2d20.952596796427166!3d44.37058906940357!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4750cfa3b150c44d%3A0x78e0b9947539bcff!2sTenis%20klub!5e0!3m2!1sen!2srs!4v1776715669786!5m2!1sen!2srs"
                            width="600" height="450" style="border:0;"
                            allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
				</div>
			</div>
		</div>
	</section>

	{{-- ============ FOOTER ============ --}}
	<footer>
		<div class="container">
			<div class="footer-grid">
				<div>
					<div class="footer-brand">
                        <img src="{{ asset('images/logo.svg') }}" alt="TK Winner Logo" style="height: 55px;">
					</div>
					<p class="footer-desc">Teniski klub Winner — tradicionalni klub iz Smederevske Palanke. Tri terena od šljake, balon za zimsku sezonu, škola tenisa, klupski turniri i prijatna atmosfera već više od dve decenije.</p>
				</div>

				<div>
					<h4>Navigacija</h4>
					<a href="#about">O klubu</a>
					<a href="#courts">Tereni</a>
					<a href="#gallery">Galerija</a>
					<a href="#testimonials">Recenzije</a>
					<a href="#contact">Kontakt</a>
				</div>

				<div>
					<h4>Kontakt</h4>
					<a href="tel:+381642671518">+381 64 267 15 18</a>
					<a href="mailto:goran.surjak71@gmail.com">goran.surjak71@gmail.com</a>
					<a href="#">Nadežde Petrović 27</a>
					<a href="#">Smederevska Palanka</a>
				</div>
			</div>

			<div class="footer-bottom">
				<div>© {{ date('Y') }} Teniski klub Winner. Sva prava zadržana.</div>
			</div>
		</div>
	</footer>

	{{-- ============ BOOKING MODAL ============ --}}
	<div class="modal-backdrop" id="modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
		<div class="modal-card">
			<div class="modal-header">
				<div>
					<div class="modal-title" id="modal-title">🎾 Rezerviši termin</div>
					<div class="modal-subtitle">Pet koraka do tvog termina</div>
				</div>
				<button type="button" class="modal-close" id="modalClose" aria-label="Zatvori">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></svg>
				</button>
			</div>
			<div class="modal-body">
				<div class="progress" id="progress">
					<div class="p-item active">1. Teren</div>
					<div class="p-item">2. Datum</div>
					<div class="p-item">3. Trajanje</div>
					<div class="p-item">4. Termin</div>
					<div class="p-item">5. Podaci</div>
				</div>

				<div id="formError" class="alert alert-error hidden"></div>

				<div id="step1" class="step-box">
					<div class="step-title">Izaberite teren</div>
					<div class="row">
						<label class="label" for="court_id">Teren</label>
						<select id="court_id" class="select">
							<option value="">— izaberi teren —</option>
							@foreach($courts as $court)
								<option value="{{ $court->id }}">{{ $court->name }} ({{ $court->location }})</option>
							@endforeach
						</select>
					</div>
					<div class="button-row center">
						<button type="button" class="btn-step btn-step-primary" id="next1" disabled>Dalje →</button>
					</div>
				</div>

				<div id="step2" class="step-box hidden">
					<div class="step-title">Izaberite datum</div>
					<div class="row">
						<label class="label" for="date">Datum</label>
						<input id="date" type="text" class="input" placeholder="Kliknite za izbor datuma" readonly>
					</div>
					<div id="dateStatus" class="alert alert-info hidden"></div>
					<div class="button-row">
						<button type="button" class="btn-step btn-step-secondary" data-back="1">← Nazad</button>
						<button type="button" class="btn-step btn-step-primary" id="next2" disabled>Dalje →</button>
					</div>
				</div>

				<div id="step3" class="step-box hidden">
					<div class="step-title">Izaberite trajanje</div>
					<div class="row">
						<label class="label" for="duration">Trajanje</label>
						<select id="duration" class="select">
							<option value="">— izaberi trajanje —</option>
							@foreach($timeSlots as $slot)
								<option value="{{ $slot->duration_minutes }}">{{ $slot->label }}</option>
							@endforeach
						</select>
					</div>
					<div class="button-row">
						<button type="button" class="btn-step btn-step-secondary" data-back="2">← Nazad</button>
						<button type="button" class="btn-step btn-step-primary" id="next3" disabled>Dalje →</button>
					</div>
				</div>

				<div id="step4" class="step-box hidden">
					<div class="step-title">Izaberite termin</div>
					<div id="times" class="times-wrap"></div>
					<div class="waitlist-bubble">
						Ako su termini koje želite zauzeti, pozovite <a href="tel:+381642671518">064 267 1518</a> i javićemo vam ukoliko se neki termin oslobodi.
					</div>
					<div class="button-row">
						<button type="button" class="btn-step btn-step-secondary" data-back="3">← Nazad</button>
						<button type="button" class="btn-step btn-step-primary" id="next4" disabled>Dalje →</button>
					</div>
				</div>

				<div id="step5" class="step-box hidden">
					<div class="step-title">Unesite podatke i potvrdite</div>
					<form id="reserveForm" method="post" action="{{ route('reservations.store') }}" novalidate>
						@csrf
						<input type="hidden" name="court_id" id="f_court_id">
						<input type="hidden" name="date" id="f_date">
						<input type="hidden" name="time_slot_id" id="f_time_slot_id">
						<input type="hidden" name="start_time" id="f_start_time">

						<div class="two-col">
							<div class="row">
								<label class="label" for="first_name">Ime</label>
								<input class="input" type="text" id="first_name" name="first_name" required maxlength="100" placeholder="Npr. Marko">
							</div>
							<div class="row">
								<label class="label" for="last_name">Prezime</label>
								<input class="input" type="text" id="last_name" name="last_name" required maxlength="100" placeholder="Npr. Jovanović">
							</div>
						</div>
						<div class="row">
							<label class="label" for="email">Email</label>
							<input class="input" type="email" id="email" name="email" required maxlength="150" placeholder="primer@email.com">
						</div>
						<div class="row">
							<label class="label" for="phone">Telefon</label>
							<input class="input" type="text" id="phone" name="phone" required maxlength="50" pattern="^\+?[0-9\s\-()]{7,20}$" placeholder="+381 64 123 4567">
						</div>
						<div class="button-row">
							<button class="btn-step btn-step-secondary" type="button" data-back="4">← Nazad</button>
							<button class="btn-step btn-step-primary" type="submit" id="submitBtn" disabled>
								<span id="submitLabel">🎾 Rezerviši</span>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	{{-- ============ TOAST ============ --}}
	<div class="toast" id="toast">
		<div class="toast-icon" id="toastIcon">
			<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
		</div>
		<div class="toast-text">
			<div class="toast-title" id="toastTitle">Uspeh</div>
			<div id="toastMessage">Uspešno ste rezervisali termin.</div>
		</div>
	</div>

	{{-- ===== LIGHTBOX ===== --}}
	<div id="lb" class="lb-backdrop" role="dialog" aria-modal="true" aria-label="Galerija">
		<button class="lb-close" id="lbClose" aria-label="Zatvori">&times;</button>
		<button class="lb-arrow lb-prev" id="lbPrev" aria-label="Prethodna">&#8249;</button>
		<img id="lbImg" class="lb-img" src="" alt="">
		<button class="lb-arrow lb-next" id="lbNext" aria-label="Sledeća">&#8250;</button>
		<span class="lb-counter" id="lbCounter"></span>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/sr.js"></script>
	<script>
		// ===== NAV SCROLL =====
		const nav = document.getElementById('nav');
		const navToggle = document.getElementById('navToggle');
		const navLinks = document.getElementById('navLinks');
		const onScroll = () => {
			const menuOpen = navLinks.classList.contains('open');
			nav.classList.toggle('scrolled', window.scrollY > 20 || menuOpen);
		};
		onScroll();
		window.addEventListener('scroll', onScroll, { passive: true });

		// Mobile menu toggle
		navToggle.addEventListener('click', () => {
			const opening = !navLinks.classList.contains('open');
			navLinks.classList.toggle('open');
			if (opening) {
				nav.classList.add('scrolled');
			} else if (window.scrollY <= 20) {
				nav.classList.remove('scrolled');
			}
		});
		navLinks.querySelectorAll('a, button').forEach(el => {
			el.addEventListener('click', () => {
				navLinks.classList.remove('open');
				if (window.scrollY <= 20) nav.classList.remove('scrolled');
			});
		});

		// Smooth scroll bez # u URL-u
		document.querySelectorAll('a[href^="#"]').forEach(link => {
			const target = link.getAttribute('href');
			if (target === '#') return;
			link.addEventListener('click', e => {
				const el = document.querySelector(target);
				if (!el) return;
				e.preventDefault();
				el.scrollIntoView({ behavior: 'smooth' });
			});
		});

		// ===== BODY SCROLL LOCK (mobile-safe) =====
		let bodyLockCount = 0;
		let bodyLockScrollY = 0;
		function lockBodyScroll() {
			if (bodyLockCount === 0) {
				bodyLockScrollY = window.scrollY || window.pageYOffset || 0;
				document.body.style.top = `-${bodyLockScrollY}px`;
				document.body.classList.add('modal-open');
			}
			bodyLockCount++;
		}
		function unlockBodyScroll() {
			bodyLockCount = Math.max(0, bodyLockCount - 1);
			if (bodyLockCount === 0) {
				document.body.classList.remove('modal-open');
				document.body.style.top = '';
				window.scrollTo(0, bodyLockScrollY);
			}
		}

		// ===== MODAL =====
		const modal = document.getElementById('modal');
		const modalClose = document.getElementById('modalClose');
		function openModal(prefillCourtId) {
			if (prefillCourtId) {
				resetForm();
				formError.classList.add('hidden');
			}
			modal.classList.add('open');
			lockBodyScroll();
			if (prefillCourtId) {
				const sel = document.getElementById('court_id');
				sel.value = String(prefillCourtId);
				sel.dispatchEvent(new Event('change'));
			}
		}
		function closeModal() {
			if (!modal.classList.contains('open')) return;
			modal.classList.remove('open');
			unlockBodyScroll();
		}
		document.querySelectorAll('[data-open-modal]').forEach(b => {
			b.addEventListener('click', (e) => {
				e.preventDefault();
				openModal(b.dataset.court);
			});
		});
		modalClose.addEventListener('click', closeModal);
		modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
		document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && modal.classList.contains('open')) closeModal(); });

		// ===== TOAST =====
		const toast = document.getElementById('toast');
		const toastIcon = document.getElementById('toastIcon');
		const toastTitle = document.getElementById('toastTitle');
		const toastMessage = document.getElementById('toastMessage');
		let toastTimer = null;
		function showToast(type, title, message) {
			toast.classList.toggle('error', type === 'error');
			toastIcon.innerHTML = type === 'error'
				? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>'
				: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
			toastTitle.textContent = title;
			toastMessage.textContent = message;
			toast.classList.add('show');
			clearTimeout(toastTimer);
			toastTimer = setTimeout(() => toast.classList.remove('show'), 4500);
		}

		// ===== BOOKING FORM =====
		const stepEls = [
			document.getElementById('step1'),
			document.getElementById('step2'),
			document.getElementById('step3'),
			document.getElementById('step4'),
			document.getElementById('step5'),
		];
		const progress = document.getElementById('progress').children;
		function showStep(n) {
			stepEls.forEach((el, i) => el.classList.toggle('hidden', i !== n - 1));
			[...progress].forEach((p, i) => {
				p.classList.toggle('active', i === n - 1);
				p.classList.toggle('done', i < n - 1);
			});
			if (n === 4) fetchAvailability();
		}

		const courtEl = document.getElementById('court_id');
		const dateEl = document.getElementById('date');
		const dateStatus = document.getElementById('dateStatus');
		const durationEl = document.getElementById('duration');
		const timesEl = document.getElementById('times');
		const submitBtn = document.getElementById('submitBtn');
		const submitLabel = document.getElementById('submitLabel');
		const formError = document.getElementById('formError');
		const next1 = document.getElementById('next1');
		const next2 = document.getElementById('next2');
		const next3 = document.getElementById('next3');
		const next4 = document.getElementById('next4');

		let fp = null;
		let disabledSet = new Set();
		const monthAvailCache = new Map();

		const hidden = {
			court: document.getElementById('f_court_id'),
			date: document.getElementById('f_date'),
			slotId: document.getElementById('f_time_slot_id'),
			startTime: document.getElementById('f_start_time'),
		};

		const slotIdByDuration = {
			@foreach($timeSlots as $slot)
			'{{ $slot->duration_minutes }}': '{{ $slot->id }}',
			@endforeach
		};

		function ymd(date) {
			const y = date.getFullYear();
			const m = String(date.getMonth() + 1).padStart(2, '0');
			const d = String(date.getDate()).padStart(2, '0');
			return `${y}-${m}-${d}`;
		}

		async function fetchMonthAvailability(year, month) {
			if (!courtEl.value) return;
			const key = `${courtEl.value}:${year}-${String(month).padStart(2, '0')}`;
			if (monthAvailCache.has(key)) {
				disabledSet = monthAvailCache.get(key);
				if (fp) fp.set('disable', [(date) => disabledSet.has(ymd(date))]);
				return;
			}
			dateStatus.classList.remove('hidden');
			dateStatus.innerHTML = '<span class="spinner"></span><span>Učitavam dostupne dane…</span>';
			try {
				const params = new URLSearchParams({ court_id: courtEl.value, year: String(year), month: String(month) });
				const res = await fetch(`{{ route('reservations.monthAvailability') }}?${params.toString()}`);
				const data = await res.json();
				disabledSet = new Set(data.disabledDates || []);
				monthAvailCache.set(key, disabledSet);
				if (fp) fp.set('disable', [(date) => disabledSet.has(ymd(date))]);
				dateStatus.classList.add('hidden');
			} catch (e) {
				dateStatus.innerHTML = '<span>Greška pri učitavanju dostupnosti.</span>';
			}
		}

		async function initCalendar() {
			if (fp) { fp.destroy(); fp = null; }
			const today = new Date();
			await fetchMonthAvailability(today.getFullYear(), today.getMonth() + 1);
			fp = flatpickr(dateEl, {
				locale: flatpickr.l10ns.sr || 'sr',
				dateFormat: 'Y-m-d',
				minDate: 'today',
				static: true,
				disable: [(date) => disabledSet.has(ymd(date))],
				onOpen: async (_, __, inst) => { await fetchMonthAvailability(inst.currentYear, inst.currentMonth + 1); },
				onMonthChange: async (_, __, inst) => { await fetchMonthAvailability(inst.currentYear, inst.currentMonth + 1); },
				onChange: (selectedDates) => {
					if (selectedDates.length) {
						next2.disabled = false;
						hidden.date.value = ymd(selectedDates[0]);
					}
				},
			});
		}

		async function fetchAvailability() {
			timesEl.innerHTML = '<div class="times-loading"><span class="spinner lg"></span></div>';
			next4.disabled = true;
			const courtId = courtEl.value;
			const date = dateEl.value;
			const duration = durationEl.value;
			if (!courtId || !date || !duration) { timesEl.innerHTML = ''; return; }
			try {
				const params = new URLSearchParams({ court_id: courtId, date, duration_minutes: duration });
				const res = await fetch(`{{ route('reservations.availability') }}?${params.toString()}`);
				if (!res.ok) throw new Error('err');
				const data = await res.json();
				if (!Array.isArray(data.available) || data.available.length === 0) {
					timesEl.innerHTML = '<div class="alert alert-info" style="grid-column:1/-1">Nema dostupnih termina za izabrane kriterijume. Probajte drugi datum ili trajanje.</div>';
					return;
				}
				const frag = document.createDocumentFragment();
				data.available.forEach(time => {
					const span = document.createElement('div');
					span.className = 'time-badge';
					span.textContent = time;
					span.addEventListener('click', () => selectTime(time, span));
					if (hidden.startTime.value === time) { span.classList.add('active'); next4.disabled = false; }
					frag.appendChild(span);
				});
				timesEl.innerHTML = '';
				timesEl.appendChild(frag);
			} catch (e) {
				timesEl.innerHTML = '<div class="alert alert-error" style="grid-column:1/-1">Došlo je do greške. Pokušajte ponovo.</div>';
			}
		}

		function selectTime(time, el) {
			[...timesEl.children].forEach(c => c.classList.remove('active'));
			el.classList.add('active');
			hidden.startTime.value = time;
			updateHiddenFields();
			next4.disabled = false;
		}

		function updateHiddenFields() {
			hidden.court.value = courtEl.value || '';
			hidden.date.value = dateEl.value || '';
			hidden.slotId.value = slotIdByDuration[String(durationEl.value || '')] || '';
			submitBtn.disabled = !(hidden.court.value && hidden.date.value && hidden.slotId.value && hidden.startTime.value);
		}

		courtEl.addEventListener('change', () => {
			next1.disabled = !courtEl.value;
			monthAvailCache.clear();
			updateHiddenFields();
			if (courtEl.value) initCalendar();
		});
		durationEl.addEventListener('change', () => {
			next3.disabled = !durationEl.value;
			hidden.startTime.value = '';
			updateHiddenFields();
		});

		async function fetchAndPopulateDurations() {
			if (!courtEl.value || !dateEl.value) return;
			const backup = durationEl.innerHTML;
			next3.disabled = true;
			next4.disabled = true;
			hidden.startTime.value = '';
			durationEl.innerHTML = '<option>Učitavam…</option>';
			durationEl.disabled = true;
			try {
				const params = new URLSearchParams({ court_id: courtEl.value, date: dateEl.value });
				const res = await fetch(`{{ route('reservations.availableDurations') }}?${params.toString()}`);
				const data = await res.json();
				durationEl.innerHTML = '<option value="">— izaberi trajanje —</option>';
				if (data.availableDurations?.length) {
					data.availableDurations.forEach(d => {
						const o = document.createElement('option');
						o.value = d.duration_minutes;
						o.textContent = d.label;
						durationEl.appendChild(o);
					});
				} else {
					durationEl.innerHTML = '<option value="">Nema dostupnih trajanja</option>';
				}
			} catch (e) {
				durationEl.innerHTML = backup;
			} finally {
				durationEl.disabled = false;
			}
		}

		next1.addEventListener('click', () => { if (!next1.disabled) showStep(2); });
		next2.addEventListener('click', async () => { if (!next2.disabled && dateEl.value) { await fetchAndPopulateDurations(); showStep(3); } });
		next3.addEventListener('click', () => { if (!next3.disabled) showStep(4); });
		next4.addEventListener('click', () => { if (!next4.disabled) { updateHiddenFields(); showStep(5); } });
		document.querySelectorAll('[data-back]').forEach(btn => {
			btn.addEventListener('click', () => showStep(parseInt(btn.dataset.back, 10)));
		});

		// ===== AJAX SUBMIT =====
		const form = document.getElementById('reserveForm');
		form.addEventListener('submit', async (e) => {
			e.preventDefault();
			if (submitBtn.disabled) return;
			formError.classList.add('hidden');
			submitBtn.disabled = true;
			submitLabel.innerHTML = '<span class="spinner"></span> Rezervišem…';

			const fd = new FormData(form);
			try {
				const res = await fetch(form.action, {
					method: 'POST',
					headers: {
						'Accept': 'application/json',
						'X-Requested-With': 'XMLHttpRequest',
						'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
					},
					body: fd,
				});
				const data = await res.json().catch(() => ({}));
				if (res.ok) {
					resetForm();
					closeModal();
					showToast('success', 'Uspešno', data.message || 'Uspešno ste rezervisali termin. Uskoro ćete dobiti potvrdu mejlom.');
				} else if (res.status === 419) {
					const msg = 'Sesija je istekla. Molimo osvežite stranicu i pokušajte ponovo.';
					formError.textContent = msg;
					formError.classList.remove('hidden');
					showToast('error', 'Greška', msg);
				} else {
					let msg = data.message || 'Došlo je do greške. Pokušajte ponovo.';
					if (data.errors) {
						const first = Object.values(data.errors)[0];
						if (Array.isArray(first) && first.length) msg = first[0];
					}
					formError.textContent = msg;
					formError.classList.remove('hidden');
					showToast('error', 'Greška', msg);
				}
			} catch (err) {
				const msg = 'Greška u komunikaciji sa serverom. Proverite internet i pokušajte ponovo.';
				formError.textContent = msg;
				formError.classList.remove('hidden');
				showToast('error', 'Greška', msg);
			} finally {
				submitBtn.disabled = false;
				submitLabel.textContent = '🎾 Rezerviši';
				updateHiddenFields();
			}
		});

		function resetForm() {
			form.reset();
			courtEl.value = '';
			durationEl.value = '';
			if (fp) { fp.clear(); }
			dateEl.value = '';
			hidden.court.value = '';
			hidden.date.value = '';
			hidden.slotId.value = '';
			hidden.startTime.value = '';
			timesEl.innerHTML = '';
			next1.disabled = true;
			next2.disabled = true;
			next3.disabled = true;
			next4.disabled = true;
			submitBtn.disabled = true;
			monthAvailCache.clear();
			showStep(1);
		}
		// ===== LIGHTBOX =====
		const lbImages = [
			'galeria32.jpeg','galeria25.jpeg','galeria11.jpeg','galeria6.jpg',
			'galeria30.jpeg','galeria28.jpeg','galeria9.jpg','galeria24.jpeg',
			'galeria15.jpeg','galeria13.jpeg','galeria29.jpeg','galeria23.jpeg',
			'galeria35.jpeg','galeria16.jpeg','galeria1.jpg','galeria20.jpeg',
			'galeria31.jpeg','galeria8.jpg','galeria22.jpeg','galeria14.jpeg',
			'galeria3.jpg','galeria7.jpg','galeria17.jpeg','galeria2.jpg',
			'galeria19.jpeg','galeria33.jpeg','galeria18.jpeg','galeria27.jpeg',
			'galeria5.jpg','galeria4.jpg','galeria26.jpeg','galeria10.jpeg',
			'galeria21.jpeg',
		].map(f => '/images/' + f);
		let lbIdx = 0;
		const lb = document.getElementById('lb');
		const lbImgEl = document.getElementById('lbImg');
		const lbCounter = document.getElementById('lbCounter');
		function lbShow(i) {
			lbIdx = (i + lbImages.length) % lbImages.length;
			lbImgEl.src = lbImages[lbIdx];
			lbImgEl.alt = 'Galerija ' + (lbIdx + 1);
			lbCounter.textContent = (lbIdx + 1) + ' / ' + lbImages.length;
		}
		function lbOpen(i) {
			lbShow(i);
			lb.classList.add('open');
			lockBodyScroll();
		}
		function lbClose() {
			if (!lb.classList.contains('open')) return;
			lb.classList.remove('open');
			unlockBodyScroll();
		}
		document.getElementById('lbClose').addEventListener('click', lbClose);
		document.getElementById('lbPrev').addEventListener('click', () => lbShow(lbIdx - 1));
		document.getElementById('lbNext').addEventListener('click', () => lbShow(lbIdx + 1));
		lb.addEventListener('click', e => { if (e.target === lb) lbClose(); });
		document.addEventListener('keydown', e => {
			if (!lb.classList.contains('open')) return;
			if (e.key === 'ArrowLeft') lbShow(lbIdx - 1);
			else if (e.key === 'ArrowRight') lbShow(lbIdx + 1);
			else if (e.key === 'Escape') lbClose();
		});
		let lbTouchX = 0;
		lb.addEventListener('touchstart', e => { lbTouchX = e.changedTouches[0].clientX; }, { passive: true });
		lb.addEventListener('touchend', e => {
			const dx = e.changedTouches[0].clientX - lbTouchX;
			if (Math.abs(dx) > 40) lbShow(lbIdx + (dx < 0 ? 1 : -1));
		});
		document.querySelectorAll('.gallery-item[data-lb]').forEach(el => {
			el.addEventListener('click', () => lbOpen(+el.dataset.lb));
		});
		// ===== LOAD MORE =====
		const loadMoreBtn = document.getElementById('galleryLoadMore');
		loadMoreBtn.addEventListener('click', () => {
			const hidden = document.querySelectorAll('#galleryGrid .gallery-item.gallery-hidden');
			Array.from(hidden).slice(0, 3).forEach(el => el.classList.remove('gallery-hidden'));
			if (document.querySelectorAll('#galleryGrid .gallery-item.gallery-hidden').length === 0) {
				loadMoreBtn.style.display = 'none';
			}
		});
	</script>
</body>
</html>
