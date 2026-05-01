<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Admin panel — Rezervacije — Teniski klub Winner</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" media="print" onload="this.media='all'">
	<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"></noscript>

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
			--line: #e7e5e4;
			--success: #16a34a;
			--success-soft: #dcfce7;
			--danger: #dc2626;
			--danger-soft: #fee2e2;
		}
		html, body { min-height: 100%; }
		body {
			font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
			color: var(--ink);
			background: var(--surface);
			line-height: 1.5;
			-webkit-font-smoothing: antialiased;
		}
		a { color: inherit; text-decoration: none; }
		button { font: inherit; cursor: pointer; border: 0; background: transparent; }

		.topbar { background: #0c0a09; color: #fff; padding: 14px 0; position: sticky; top: 0; z-index: 30; }
		.topbar-inner { max-width: 1200px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; }
		.brand { display: flex; align-items: center; gap: 12px; color: #fff; }
		.admin-nav { display: flex; gap: 4px; align-items: center; }
		.admin-nav a { color: rgba(255,255,255,.75); font-size: 14px; font-weight: 500; padding: 8px 14px; border-radius: 10px; transition: background .15s, color .15s; }
		.admin-nav a:hover { background: rgba(255,255,255,.08); color: #fff; }
		.admin-nav a.active { background: rgba(255,255,255,.12); color: #fff; }
		.topbar-right { display: flex; align-items: center; gap: 6px; }
		.logout-form { margin: 0; display: flex; align-items: center; }
		.btn-logout { color: rgba(255,255,255,.8); font-size: 14px; font-weight: 500; padding: 8px 14px; border-radius: 10px; transition: background .15s, color .15s; }
		.btn-logout:hover { background: rgba(255,255,255,.08); color: #fff; }
		.admin-nav-toggle { display: none; color: #fff; padding: 8px; border-radius: 8px; flex-shrink: 0; }
		.admin-nav-toggle:hover { background: rgba(255,255,255,.08); }
		.admin-nav-toggle svg { width: 24px; height: 24px; display: block; }
		@media (max-width: 720px) {
			.topbar { position: relative; }
			.admin-nav-toggle { display: inline-flex; }
			.topbar-right { display: none; }
			.topbar-right.open { display: flex; position: absolute; top: 100%; left: 0; right: 0; flex-direction: column; align-items: stretch; gap: 4px; background: rgba(12,10,9,.97); backdrop-filter: blur(14px); padding: 12px 16px 20px; border-bottom: 1px solid rgba(255,255,255,.08); z-index: 20; }
			.topbar-right.open .admin-nav { flex-direction: column; gap: 2px; }
			.topbar-right.open .admin-nav a { padding: 12px 14px; font-size: 15px; border-radius: 10px; }
			.topbar-right.open .logout-form { display: flex; border-top: 1px solid rgba(255,255,255,.08); padding-top: 10px; margin-top: 6px; }
			.topbar-right.open .btn-logout { width: 100%; text-align: left; padding: 12px 14px; font-size: 15px; border-radius: 10px; }
		}

		.container { max-width: 1200px; margin: 0 auto; padding: 24px 24px 56px; }
		h1 { font-size: 24px; font-weight: 800; letter-spacing: -.02em; margin-bottom: 4px; }
		.page-sub { color: var(--muted); font-size: 14px; margin-bottom: 18px; }

		.toolbar { background: #fff; border: 1px solid var(--line); border-radius: 14px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap; margin-bottom: 16px; box-shadow: 0 1px 2px rgba(12,10,9,.04); }
		.date-nav { display: flex; align-items: center; gap: 10px; flex-wrap: nowrap; min-width: 0; flex: 1 1 auto; }
		.nav-btn { flex: 0 0 auto; display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 10px; border: 1.5px solid var(--line); color: var(--ink-2); background: #fff; transition: background .15s, border-color .15s, color .15s; }
		.nav-btn:hover { background: var(--brand-soft); border-color: var(--brand); color: var(--brand); }
		.current-date { flex: 1 1 auto; min-width: 0; font-weight: 700; font-size: 15px; text-align: center; color: var(--ink); padding: 0 6px; }
		.current-date small { display: block; font-size: 11px; font-weight: 500; color: var(--muted); text-transform: uppercase; letter-spacing: .08em; margin-top: 2px; }
		.today-pill { display: inline-block; background: var(--success-soft); color: var(--success); font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 8px; margin-left: 8px; letter-spacing: .04em; text-transform: uppercase; white-space: nowrap; }
		.date-form { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
		#todayBtnWrap { display: inline-flex; }
		.date-form input[type="date"] { padding: 8px 10px; border: 1.5px solid var(--line); border-radius: 10px; font: inherit; font-size: 14px; color: var(--ink); background: #fff; -webkit-appearance: none; appearance: none; min-width: 0; }
		.date-form input[type="date"]:focus { outline: 0; border-color: var(--brand); box-shadow: 0 0 0 3px rgba(234,88,12,.15); }
		.btn-today { padding: 8px 14px; border-radius: 10px; border: 1.5px solid var(--line); background: #fff; font-size: 14px; font-weight: 600; color: var(--ink-2); transition: background .15s, border-color .15s, color .15s; }
		.btn-today:hover { background: var(--brand-soft); border-color: var(--brand); color: var(--brand); }

		.flash { padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; font-size: 14px; font-weight: 500; }
		.flash-success { background: var(--success-soft); color: var(--success); }
		.flash-error { background: var(--danger-soft); color: var(--danger); }

		.grid-card { background: #fff; border: 1px solid var(--line); border-radius: 14px; overflow: hidden; box-shadow: 0 1px 2px rgba(12,10,9,.04); }
		.grid-head { padding: 14px 18px; border-bottom: 1px solid var(--line); display: flex; align-items: center; justify-content: space-between; gap: 12px; background: var(--surface); flex-wrap: wrap; }
		.grid-head-title { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); }
		.count-pill { background: var(--brand); color: #fff; font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 10px; }
		.legend { display: flex; gap: 14px; font-size: 12px; color: var(--muted); align-items: center; flex-wrap: wrap; }
		.legend-item { display: inline-flex; align-items: center; gap: 6px; }
		.legend-dot { width: 12px; height: 12px; border-radius: 4px; }
		.legend-dot.free { background: #fff; border: 1.5px dashed #d6d3d1; }
		.legend-dot.busy { background: linear-gradient(135deg, var(--brand), var(--brand-2)); }
		.legend-dot.past { background: #ededed; border: 1.5px solid #e0dfdd; }

		.empty { padding: 56px 24px; text-align: center; color: var(--muted); }
		.empty-icon { width: 56px; height: 56px; border-radius: 50%; background: var(--brand-soft); color: var(--brand); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 14px; }

		.grid-scroll { width: 100%; overflow: auto; max-height: calc(100dvh - 240px); -webkit-overflow-scrolling: touch; }
		.grid-table { width: 100%; min-width: 320px; border-collapse: collapse; table-layout: fixed; font-size: 13px; }
		.grid-table thead th { position: sticky; top: 0; z-index: 4; background: #fff; border-bottom: 2px solid var(--line); padding: 10px 8px; text-align: center; font-weight: 700; font-size: 13px; color: var(--ink); }
		.grid-table thead th.col-time { background: var(--surface); width: 64px; min-width: 64px; left: 0; z-index: 5; }
		.court-name { font-weight: 700; font-size: 13px; color: var(--ink); line-height: 1.2; }
		.court-loc { font-weight: 500; font-size: 11px; color: var(--muted); margin-top: 2px; }
		.grid-table td { border-bottom: 1px solid #f1efed; vertical-align: top; }
		.grid-table tr.hour-row td { border-bottom: 1px solid var(--line); }
		.grid-table td.cell-time {
			width: 64px; min-width: 64px;
			text-align: center; padding: 4px 6px;
			font-variant-numeric: tabular-nums; font-weight: 600; color: var(--muted);
			background: var(--surface);
			position: sticky; left: 0; z-index: 2;
			font-size: 12px;
		}
		.grid-table.grid-multi td:not(.cell-time),
		.grid-table.grid-multi th:not(.col-time) { border-left: 1px solid var(--line); }
		.grid-table:not(.grid-multi) td.cell-time,
		.grid-table:not(.grid-multi) th.col-time { border-right: 1px solid var(--line); }
		.grid-table tr.hour-row td.cell-time { color: var(--ink); font-weight: 700; font-size: 13px; }
		.grid-table tr.row-past td.cell-time { color: #b8b3ad; }
		.grid-table tr.row-past td.cell-empty { background: #fafafa; }

		.cell-empty {
			padding: 0; height: 36px;
			background: #fff;
		}
		.cell-empty-inner {
			display: flex; align-items: center; justify-content: center;
			height: 100%;
			font-size: 11px; color: #b8b3ad; font-weight: 500;
		}
		tr.row-past .cell-empty-inner { color: #d4d0cb; }

		.cell-reservation {
			padding: 4px;
			background: #fff;
			height: 1px; /* enables 100% height on inner button */
		}
		.res-card {
			width: 100%; height: 100%; min-height: 100%;
			background: linear-gradient(135deg, var(--brand), var(--brand-2));
			color: #fff;
			border-radius: 8px;
			padding: 8px 10px;
			display: flex; flex-direction: column; justify-content: center;
			text-align: left;
			cursor: pointer;
			transition: transform .12s, box-shadow .12s, filter .12s;
			border: 0;
			box-shadow: 0 2px 6px rgba(234,88,12,.18);
			overflow: hidden;
		}
		.res-card:hover { transform: translateY(-1px); box-shadow: 0 6px 14px rgba(234,88,12,.28); }
		.res-card:active { transform: translateY(0); }
		.res-card.is-past { background: #d6d3d1; color: #44403c; box-shadow: none; }
		.res-card.is-past:hover { transform: none; box-shadow: none; filter: brightness(.98); }
		.res-name { font-weight: 700; font-size: 13px; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
		.res-time { font-size: 11px; opacity: .92; margin-top: 3px; font-variant-numeric: tabular-nums; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
		.res-tap-hint { font-size: 10px; opacity: .75; margin-top: 4px; text-transform: uppercase; letter-spacing: .04em; }

		/* Modal — details */
		.modal { position: fixed; inset: 0; background: rgba(0,0,0,0.55); display: none; align-items: center; justify-content: center; z-index: 1000; padding: 16px; }
		.modal.open { display: flex; }
		.modal-card { background: #fff; border-radius: 16px; max-width: 480px; width: 100%; max-height: calc(100dvh - 32px); overflow-y: auto; -webkit-overflow-scrolling: touch; overscroll-behavior: contain; box-shadow: 0 20px 60px rgba(0,0,0,0.25); }
		html.modal-open, body.modal-open { overflow: hidden; height: 100%; }
		body.modal-open { position: fixed; left: 0; right: 0; width: 100%; }
		.modal-header { display: flex; justify-content: space-between; align-items: center; padding: 18px 20px 12px; border-bottom: 1px solid var(--line); }
		.modal-header h2 { margin: 0; font-size: 18px; font-weight: 800; letter-spacing: -.01em; }
		.modal-close { background: transparent; border: 0; font-size: 24px; cursor: pointer; color: var(--muted); width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; line-height: 1; }
		.modal-close:hover { background: var(--surface); color: var(--ink); }
		.modal-body { padding: 16px 20px; }
		.detail-row { display: flex; gap: 12px; padding: 10px 0; border-bottom: 1px solid var(--line); }
		.detail-row:last-child { border-bottom: 0; }
		.detail-label { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); width: 90px; flex-shrink: 0; padding-top: 2px; }
		.detail-value { flex: 1; min-width: 0; font-size: 14px; color: var(--ink); overflow-wrap: anywhere; word-break: break-word; }
		.detail-value a { color: var(--brand); font-weight: 600; overflow-wrap: anywhere; word-break: break-word; }
		.detail-value.nowrap { white-space: nowrap; overflow-x: auto; -webkit-overflow-scrolling: touch; word-break: normal; overflow-wrap: normal; }
		.detail-value.nowrap a { white-space: nowrap; word-break: normal; overflow-wrap: normal; }
		.detail-value a:hover { text-decoration: underline; }
		.detail-value .muted { color: var(--muted); font-size: 12px; margin-top: 2px; display: block; font-weight: 500; }
		.modal-footer { padding: 14px 20px; border-top: 1px solid var(--line); display: flex; gap: 10px; flex-wrap: wrap; justify-content: flex-end; }
		.btn { padding: 9px 14px; border-radius: 10px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: background .15s, border-color .15s, color .15s, transform .15s, box-shadow .15s; border: 0; }
		.btn-cancel { background: var(--danger); color: #fff; }
		.btn-cancel:hover { transform: translateY(-1px); box-shadow: 0 6px 14px rgba(220,38,38,.28); }
		.btn-message { background: #fff; border: 1.5px solid var(--line); color: var(--ink-2); padding: 7.5px 14px; }
		.btn-message:hover { background: var(--brand-soft); border-color: var(--brand); color: var(--brand); }
		.btn-secondary { background: #fff; border: 1.5px solid var(--line); color: var(--ink-2); padding: 7.5px 14px; }
		.btn-secondary:hover { background: var(--surface); }
		.past-pill { font-size: 11px; color: var(--muted); font-weight: 600; background: var(--line); padding: 4px 10px; border-radius: 8px; align-self: center; }

		#msgText { width: 100%; min-height: 130px; padding: 12px 14px; border: 1.5px solid var(--line); border-radius: 10px; font: inherit; font-size: 16px; resize: vertical; box-sizing: border-box; color: var(--ink); }
		#msgText:focus { outline: 0; border-color: var(--brand); box-shadow: 0 0 0 3px rgba(234,88,12,.15); }
		.msg-modal-recipient { color: var(--muted); font-size: 13px; padding: 0 0 12px; border-bottom: 1px solid var(--line); margin-bottom: 12px; }
		.msg-modal-recipient strong { color: var(--ink); font-weight: 700; }
		.msg-modal-error { color: var(--danger); font-size: 13px; margin-top: 8px; min-height: 18px; font-weight: 500; }

		.admin-toast { position: fixed; top: 24px; right: 24px; z-index: 1100; padding: 14px 20px; background: var(--success); color: #fff; border-radius: 12px; font-weight: 600; font-size: 14px; box-shadow: 0 8px 24px rgba(0,0,0,0.2); transform: translateX(calc(100% + 40px)); transition: transform .3s ease; max-width: 360px; }
		.admin-toast.show { transform: translateX(0); }
		.admin-toast.error { background: var(--danger); }

		@media (max-width: 720px) {
			.container { padding: 16px 12px 48px; }
			.toolbar { padding: 12px; gap: 10px; }
			.grid-head { padding: 12px 14px; }
			.legend { font-size: 11px; gap: 10px; }
			.grid-scroll { max-height: calc(100dvh - 220px); }

			.grid-table { font-size: 12px; }
			.grid-table thead th { padding: 8px 4px; font-size: 12px; }
			.grid-table thead th.col-time { width: 50px; min-width: 50px; }
			.grid-table td.cell-time { width: 50px; min-width: 50px; padding: 2px 4px; font-size: 11px; }
			.grid-table tr.hour-row td.cell-time { font-size: 12px; }
			.court-name { font-size: 12px; }
			.court-loc { font-size: 10px; }
			.cell-empty { height: 32px; }
			.cell-empty-inner { font-size: 10px; }
			.res-card { padding: 6px 8px; border-radius: 6px; }
			.res-name { font-size: 12px; }
			.res-time { font-size: 10px; margin-top: 2px; }
			.res-tap-hint { display: none; }
		}

		@media (max-width: 480px) {
			.current-date { font-size: 13px; }
			.current-date small { font-size: 10px; }
			.today-pill { margin-left: 6px; font-size: 10px; padding: 1px 6px; }
			.date-form { flex-direction: column; align-items: stretch; min-width: 0; width: 100%; }
			.date-form input[type="date"] { width: 100%; }
			.btn-today { width: 100%; text-align: center; box-sizing: border-box; }
			.detail-label { width: 78px; font-size: 11px; }
			.modal-footer { flex-direction: column-reverse; align-items: stretch; }
			.modal-footer .btn { justify-content: center; width: 100%; }
		}
	</style>
</head>
<body>
	<div class="topbar">
		<div class="topbar-inner">
			<a href="{{ route('admin.dashboard') }}" class="brand">
                <img src="{{ asset('images/logo.svg') }}" alt="tK Winner Logo" style="height: 55px;">
			</a>
			<button type="button" class="admin-nav-toggle" id="adminNavToggle" aria-label="Meni">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
			</button>
			<div class="topbar-right" id="adminTopbarRight">
				<nav class="admin-nav">
					<a href="{{ route('admin.dashboard') }}" class="active">Rezervacije</a>
					<a href="{{ route('admin.blocked.index') }}">Blokirani</a>
					<a href="{{ route('admin.courts.index') }}">Tereni</a>
				</nav>
				<form method="post" action="{{ route('admin.logout') }}" class="logout-form">
					@csrf
					<button type="submit" class="btn-logout">Odjavi se</button>
				</form>
			</div>
		</div>
	</div>

	<div class="container">
		<h1>Rezervacije</h1>
		<p class="page-sub">Tabelarni pregled termina po terenima — prazna polja označavaju slobodne termine.</p>

		@if (session('success'))
			<div class="flash flash-success">{{ session('success') }}</div>
		@endif
		@if (session('error'))
			<div class="flash flash-error">{{ session('error') }}</div>
		@endif

		<div class="toolbar">
			<div class="date-nav">
				<a href="{{ route('admin.dashboard', ['date' => $prevDate->toDateString()]) }}" id="navPrev" class="nav-btn" aria-label="Prethodni dan" title="Prethodni dan" data-nav-date="{{ $prevDate->toDateString() }}">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
				</a>
				<div class="current-date" id="currentDate">
					{{ $date->locale('sr')->isoFormat('dddd, D. MMMM YYYY.') }}
					@if ($date->isSameDay($today))
						<span class="today-pill">Danas</span>
					@endif
					<small>{{ $date->toDateString() }}</small>
				</div>
				<a href="{{ route('admin.dashboard', ['date' => $nextDate->toDateString()]) }}" id="navNext" class="nav-btn" aria-label="Sledeći dan" title="Sledeći dan" data-nav-date="{{ $nextDate->toDateString() }}">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
				</a>
			</div>

			<form method="get" action="{{ route('admin.dashboard') }}" class="date-form" id="dateForm">
				<input type="date" name="date" id="dateInput" value="{{ $date->toDateString() }}">
				<span id="todayBtnWrap">
					@unless ($date->isSameDay($today))
						<a href="{{ route('admin.dashboard') }}" class="btn-today" data-nav-today>Danas</a>
					@endunless
				</span>
			</form>
		</div>

		<div class="grid-card" id="gridCard">
			<div class="grid-head">
				<div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
					<span class="grid-head-title">Raspored za izabrani dan</span>
					<span class="count-pill" id="countPill">{{ $reservationsTotal }}</span>
				</div>
				<div class="legend">
					<span class="legend-item"><span class="legend-dot busy"></span> Zauzeto</span>
					<span class="legend-item"><span class="legend-dot free"></span> Slobodno</span>
					<span class="legend-item"><span class="legend-dot past"></span> Prošlo</span>
				</div>
			</div>

			<div id="gridBody">
				@include('admin._dashboard_grid', [
					'courts' => $courts,
					'hours' => $hours,
					'grid' => $grid,
					'reservations' => $reservations,
					'nowMinutes' => $nowMinutes,
				])
			</div>
		</div>
	</div>

	<!-- Reservation details modal -->
	<div class="modal" id="detailsModal" role="dialog" aria-modal="true" aria-labelledby="detailsModalTitle">
		<div class="modal-card">
			<div class="modal-header">
				<h2 id="detailsModalTitle">Detalji rezervacije</h2>
				<button type="button" class="modal-close" id="detailsModalClose" aria-label="Zatvori">×</button>
			</div>
			<div class="modal-body" id="detailsModalBody"></div>
			<div class="modal-footer" id="detailsModalFooter"></div>
		</div>
	</div>

	<!-- Send message modal -->
	<div class="modal" id="msgModal" role="dialog" aria-modal="true" aria-labelledby="msgModalTitle">
		<div class="modal-card">
			<div class="modal-header">
				<h2 id="msgModalTitle">Pošalji poruku</h2>
				<button type="button" class="modal-close" id="msgModalClose" aria-label="Zatvori">×</button>
			</div>
			<div class="modal-body">
				<div class="msg-modal-recipient">Za: <strong id="msgRecipient"></strong></div>
				<form id="msgForm">
					<textarea id="msgText" placeholder="Unesite poruku... (npr. Molim vas ponesite svoje loptice.)" rows="6" maxlength="2000" required></textarea>
					<div class="msg-modal-error" id="msgError"></div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" id="msgCancel">Odustani</button>
				<button type="button" class="btn btn-cancel" id="msgSend" style="background: var(--brand);">Pošalji</button>
			</div>
		</div>
	</div>

	<div class="admin-toast" id="adminToast"><span id="adminToastText"></span></div>

	<script>
		const dashboardBase = '{{ route('admin.dashboard') }}';
		const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
		let reservationsById = {};

		function buildReservationsMap(list) {
			const map = {};
			(list || []).forEach(r => { map[r.id] = r; });
			return map;
		}

		// Initial reservation map (server-rendered)
		reservationsById = (function () {
			const map = {};
			@foreach ($reservations as $r)
				@php
					$start = $r->startAt();
					$end = $start->addMinutes((int) $r->timeSlot->duration_minutes);
				@endphp
				map[{{ $r->id }}] = {
					id: {{ $r->id }},
					startTime: '{{ $start->format('H:i') }}',
					endTime: '{{ $end->format('H:i') }}',
					durationLabel: @json($r->timeSlot->label),
					durationMinutes: {{ (int) $r->timeSlot->duration_minutes }},
					courtId: {{ $r->court_id }},
					courtName: @json($r->court->name),
					courtLocation: @json((string) $r->court->location),
					firstName: @json($r->first_name),
					lastName: @json($r->last_name),
					phone: @json($r->phone),
					email: @json($r->email),
					isFuture: {{ $start->greaterThan($now) ? 'true' : 'false' }},
					cancelUrl: @json(route('admin.reservations.cancel', ['reservation' => $r->id])),
					messageUrl: @json(route('admin.reservations.message', ['reservation' => $r->id])),
				};
			@endforeach
			return map;
		})();

		// Mobile nav toggle
		const adminNavToggle = document.getElementById('adminNavToggle');
		const adminTopbarRight = document.getElementById('adminTopbarRight');
		if (adminNavToggle && adminTopbarRight) {
			adminNavToggle.addEventListener('click', () => adminTopbarRight.classList.toggle('open'));
		}

		function esc(s) {
			return String(s ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
		}

		function escAttr(s) { return esc(s); }

		let currentDate = '{{ $date->toDateString() }}';

		function navToDate(dateStr) {
			currentDate = dateStr || '';
			const url = dateStr ? dashboardBase + '?date=' + encodeURIComponent(dateStr) : dashboardBase;
			history.pushState({ date: dateStr }, '', url);
			loadDate(dateStr);
		}

		async function loadDate(dateStr) {
			currentDate = dateStr || '';
			const url = dateStr ? dashboardBase + '?date=' + encodeURIComponent(dateStr) : dashboardBase;
			document.getElementById('gridBody').style.opacity = '0.5';
			try {
				const res = await fetch(url, {
					headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
				});
				if (!res.ok) { window.location.reload(); return; }
				renderDate(await res.json());
			} catch {
				window.location.reload();
			}
		}

		function renderDate(data) {
			const navPrev = document.getElementById('navPrev');
			const navNext = document.getElementById('navNext');
			navPrev.href = dashboardBase + '?date=' + data.prevDate;
			navPrev.dataset.navDate = data.prevDate;
			navNext.href = dashboardBase + '?date=' + data.nextDate;
			navNext.dataset.navDate = data.nextDate;

			const todayPill = data.isToday ? ' <span class="today-pill">Danas</span>' : '';
			document.getElementById('currentDate').innerHTML =
				esc(data.dateFormatted) + todayPill + '<small>' + esc(data.date) + '</small>';

			document.getElementById('dateInput').value = data.date;

			const todayWrap = document.getElementById('todayBtnWrap');
			todayWrap.innerHTML = data.isToday
				? ''
				: '<a href="' + dashboardBase + '" class="btn-today" data-nav-today>Danas</a>';

			document.getElementById('countPill').textContent = data.total;

			reservationsById = buildReservationsMap(data.reservations);
			renderGrid(data);
			document.getElementById('gridBody').style.opacity = '';
		}

		function browserNowMinutesFor(dateStr) {
			const d = new Date();
			const today = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
			if (dateStr !== today) return null;
			return d.getHours() * 60 + d.getMinutes();
		}

		function timeToMinutes(t) {
			const [h, m] = String(t || '').split(':');
			return (parseInt(h, 10) || 0) * 60 + (parseInt(m, 10) || 0);
		}

		function renderGrid(data) {
			const body = document.getElementById('gridBody');
			if (!data.courts || data.courts.length === 0) {
				body.innerHTML = '<div class="empty">'
					+ '<div class="empty-icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>'
					+ '<p>Nema aktivnih terena. Aktivirajte teren u sekciji "Tereni".</p>'
					+ '</div>';
				return;
			}

			const nowMin = browserNowMinutesFor(data.date);
			const pastDay = !!data.pastDay;

			const multiClass = data.courts.length > 1 ? ' grid-multi' : '';
			let html = '<div class="grid-scroll"><table class="grid-table' + multiClass + '"><thead><tr>';
			html += '<th class="col-time">Vreme</th>';
			data.courts.forEach(c => {
				html += '<th><div class="court-name">' + esc(c.name) + '</div>'
					+ (c.location ? '<div class="court-loc">' + esc(c.location) + '</div>' : '')
					+ '</th>';
			});
			html += '</tr></thead><tbody>';

			const rows = data.hours.length;
			const stepMin = 30;
			const openMin = 8 * 60;
			for (let i = 0; i < rows; i++) {
				const slotMin = openMin + i * stepMin;
				const isHourRow = (slotMin % 60 === 0);
				const isPast = pastDay || (nowMin !== null && nowMin >= slotMin);
				let rowClass = '';
				if (isHourRow) rowClass += ' hour-row';
				if (isPast) rowClass += ' row-past';
				html += '<tr class="' + rowClass.trim() + '">';
				html += '<td class="cell-time">' + esc(data.hours[i]) + '</td>';
				data.courts.forEach(c => {
					const cell = data.grid[c.id] && data.grid[c.id][i];
					if (!cell) {
						html += '<td class="cell-empty"><div class="cell-empty-inner">' + (isPast ? '' : 'Slobodno') + '</div></td>';
						return;
					}
					if (cell.type === 'skip') return;
					if (cell.type === 'reservation') {
						const r = reservationsById[cell.reservationId];
						if (!r) {
							html += '<td class="cell-empty" rowspan="' + (cell.rowspan || 1) + '"><div class="cell-empty-inner">—</div></td>';
							return;
						}
						const startMin = timeToMinutes(r.startTime);
						const past = pastDay || (nowMin !== null ? nowMin >= startMin : !r.isFuture);
						html += '<td class="cell-reservation" rowspan="' + (cell.rowspan || 1) + '">'
							+ '<button type="button" class="res-card' + (past ? ' is-past' : '') + '" data-reservation-id="' + r.id + '">'
							+ '<div class="res-name">' + esc(r.firstName) + ' ' + esc(r.lastName) + '</div>'
							+ '<div class="res-time">' + esc(r.startTime) + ' – ' + esc(r.endTime) + '</div>'
							+ '</button></td>';
						return;
					}
					html += '<td class="cell-empty"><div class="cell-empty-inner">' + (isPast ? '' : 'Slobodno') + '</div></td>';
				});
				html += '</tr>';
			}
			html += '</tbody></table></div>';
			body.innerHTML = html;
		}


		document.addEventListener('click', function (e) {
			const navBtn = e.target.closest('[data-nav-date]');
			if (navBtn) { e.preventDefault(); navToDate(navBtn.dataset.navDate); return; }
			const todayBtn = e.target.closest('[data-nav-today]');
			if (todayBtn) { e.preventDefault(); navToDate(''); return; }
			const resBtn = e.target.closest('[data-reservation-id]');
			if (resBtn) { e.preventDefault(); openDetailsModal(+resBtn.dataset.reservationId); return; }
		});

		document.getElementById('dateInput').addEventListener('change', function () {
			navToDate(this.value);
		});

		window.addEventListener('popstate', function () {
			const date = new URLSearchParams(window.location.search).get('date') ?? '';
			loadDate(date);
		});

		// ===== DETAILS MODAL =====
		const detailsModal = document.getElementById('detailsModal');
		const detailsModalBody = document.getElementById('detailsModalBody');
		const detailsModalFooter = document.getElementById('detailsModalFooter');
		let modalLockScrollY = 0;

		function lockScroll() {
			modalLockScrollY = window.scrollY || window.pageYOffset || 0;
			document.body.style.top = '-' + modalLockScrollY + 'px';
			document.documentElement.classList.add('modal-open');
			document.body.classList.add('modal-open');
		}
		function unlockScroll() {
			if (!document.body.classList.contains('modal-open')) return;
			document.body.classList.remove('modal-open');
			document.documentElement.classList.remove('modal-open');
			document.body.style.top = '';
			window.scrollTo({ top: modalLockScrollY, left: 0, behavior: 'instant' });
		}
		function anyModalOpen() {
			return detailsModal.classList.contains('open') || msgModal.classList.contains('open');
		}

		function openDetailsModal(id) {
			const r = reservationsById[id];
			if (!r) return;

			const fullName = (r.firstName + ' ' + r.lastName).trim();
			detailsModalBody.innerHTML = ''
				+ row('Klijent', '<strong>' + esc(fullName) + '</strong>')
				+ row('Termin', esc(r.startTime) + ' – ' + esc(r.endTime) + ' <span class="muted">' + esc(r.durationLabel) + '</span>')
				+ row('Teren', esc(r.courtName) + (r.courtLocation ? ' <span class="muted">' + esc(r.courtLocation) + '</span>' : ''))
				+ row('Telefon', '<a href="tel:' + esc(r.phone) + '">' + esc(r.phone) + '</a>')
				+ row('Email', '<a href="mailto:' + esc(r.email) + '">' + esc(r.email) + '</a>', 'nowrap');

			let footer = '<button type="button" class="btn btn-secondary" data-details-close>Zatvori</button>';
			footer += '<button type="button" class="btn btn-message" data-details-message="' + r.id + '">'
				+ '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>'
				+ ' Pošalji poruku</button>';
			if (r.isFuture) {
				footer += '<button type="button" class="btn btn-cancel" data-details-cancel="' + r.id + '">'
					+ '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>'
					+ ' Otkaži termin</button>';
			} else {
				footer += '<span class="past-pill">Termin je prošao</span>';
			}
			detailsModalFooter.innerHTML = footer;

			lockScroll();
			detailsModal.classList.add('open');
		}

		function row(label, value, valueClass) {
			const cls = 'detail-value' + (valueClass ? ' ' + valueClass : '');
			return '<div class="detail-row">'
				+ '<div class="detail-label">' + esc(label) + '</div>'
				+ '<div class="' + cls + '">' + value + '</div>'
				+ '</div>';
		}

		function closeDetailsModal() {
			if (!detailsModal.classList.contains('open')) return;
			detailsModal.classList.remove('open');
			if (!anyModalOpen()) unlockScroll();
		}

		document.getElementById('detailsModalClose').addEventListener('click', closeDetailsModal);
		detailsModal.addEventListener('click', function (e) {
			if (e.target === detailsModal) closeDetailsModal();
			const closeBtn = e.target.closest('[data-details-close]');
			if (closeBtn) { closeDetailsModal(); return; }
			const msgBtn = e.target.closest('[data-details-message]');
			if (msgBtn) {
				const id = +msgBtn.dataset.detailsMessage;
				const r = reservationsById[id];
				if (!r) return;
				closeDetailsModal();
				openMsgModal(r.messageUrl, r.firstName + ' ' + r.lastName, r.email);
				return;
			}
			const cancelBtn = e.target.closest('[data-details-cancel]');
			if (cancelBtn) {
				const id = +cancelBtn.dataset.detailsCancel;
				const r = reservationsById[id];
				if (!r) return;
				if (!confirm('Otkazati termin za ' + r.firstName + ' ' + r.lastName + ' u ' + r.startTime + '?')) return;
				submitCancel(r);
			}
		});

		function submitCancel(r) {
			const form = document.createElement('form');
			form.method = 'POST';
			form.action = r.cancelUrl;
			form.style.display = 'none';
			const tokenInput = document.createElement('input');
			tokenInput.type = 'hidden';
			tokenInput.name = '_token';
			tokenInput.value = csrfToken;
			form.appendChild(tokenInput);
			document.body.appendChild(form);
			form.submit();
		}

		// ===== MESSAGE MODAL =====
		const msgModal = document.getElementById('msgModal');
		const msgForm = document.getElementById('msgForm');
		const msgText = document.getElementById('msgText');
		const msgError = document.getElementById('msgError');
		const msgSend = document.getElementById('msgSend');
		const msgRecipient = document.getElementById('msgRecipient');
		const adminToast = document.getElementById('adminToast');
		const adminToastText = document.getElementById('adminToastText');
		let msgCurrentUrl = null;
		let adminToastTimer = null;

		function openMsgModal(url, name, email) {
			msgCurrentUrl = url;
			msgRecipient.textContent = name + ' (' + email + ')';
			msgText.value = '';
			msgError.textContent = '';
			msgSend.disabled = false;
			lockScroll();
			msgModal.classList.add('open');
			setTimeout(() => msgText.focus(), 50);
		}

		function closeMsgModal() {
			if (!msgModal.classList.contains('open')) return;
			msgModal.classList.remove('open');
			if (!anyModalOpen()) unlockScroll();
			msgCurrentUrl = null;
		}

		function showAdminToast(text, type) {
			adminToast.classList.toggle('error', type === 'error');
			adminToastText.textContent = text;
			adminToast.classList.add('show');
			clearTimeout(adminToastTimer);
			adminToastTimer = setTimeout(() => adminToast.classList.remove('show'), 3500);
		}

		document.getElementById('msgModalClose').addEventListener('click', closeMsgModal);
		document.getElementById('msgCancel').addEventListener('click', closeMsgModal);
		msgModal.addEventListener('click', function (e) { if (e.target === msgModal) closeMsgModal(); });
		document.addEventListener('keydown', function (e) {
			if (e.key !== 'Escape') return;
			if (msgModal.classList.contains('open')) { closeMsgModal(); return; }
			if (detailsModal.classList.contains('open')) closeDetailsModal();
		});

		msgSend.addEventListener('click', sendMessage);
		msgForm.addEventListener('submit', function (e) { e.preventDefault(); sendMessage(); });

		async function sendMessage() {
			if (!msgCurrentUrl) return;
			const body = msgText.value.trim();
			if (body.length < 3) {
				msgError.textContent = 'Poruka mora imati najmanje 3 karaktera.';
				return;
			}
			msgSend.disabled = true;
			msgError.textContent = '';
			const fd = new FormData();
			fd.append('message', body);
			try {
				const res = await fetch(msgCurrentUrl, {
					method: 'POST',
					headers: {
						'Accept': 'application/json',
						'X-Requested-With': 'XMLHttpRequest',
						'X-CSRF-TOKEN': csrfToken,
					},
					body: fd,
				});
				const data = await res.json().catch(() => ({}));
				if (res.ok) {
					closeMsgModal();
					showAdminToast(data.message || 'Poruka je poslata.', 'success');
				} else if (res.status === 419) {
					msgError.textContent = 'Sesija je istekla. Osvežite stranicu i pokušajte ponovo.';
					msgSend.disabled = false;
				} else {
					let errMsg = data.message || 'Greška pri slanju poruke.';
					if (data.errors) {
						const first = Object.values(data.errors)[0];
						if (Array.isArray(first) && first.length) errMsg = first[0];
					}
					msgError.textContent = errMsg;
					msgSend.disabled = false;
				}
			} catch {
				msgError.textContent = 'Greška u komunikaciji sa serverom.';
				msgSend.disabled = false;
			}
		}
	</script>
</body>
</html>
