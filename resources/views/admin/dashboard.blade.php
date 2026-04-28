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
			line-height: 1.6;
			-webkit-font-smoothing: antialiased;
		}
		a { color: inherit; text-decoration: none; }
		button { font: inherit; cursor: pointer; border: 0; background: transparent; }

		.topbar { background: #0c0a09; color: #fff; padding: 14px 0; position: sticky; top: 0; z-index: 10; }
		.topbar-inner { max-width: 1200px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; }
		.brand { display: flex; align-items: center; gap: 12px; color: #fff; }
		.brand-mark { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, var(--brand), var(--brand-2)); display: inline-flex; align-items: center; justify-content: center; color: #fff; font-size: 18px; }
		.brand-text { font-weight: 800; letter-spacing: -.02em; font-size: 16px; }
		.brand-text small { display: block; font-size: 10px; font-weight: 500; opacity: .7; letter-spacing: .08em; text-transform: uppercase; }
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

		.container { max-width: 1200px; margin: 0 auto; padding: 32px 24px 64px; }
		h1 { font-size: 26px; font-weight: 800; letter-spacing: -.02em; margin-bottom: 6px; }
		.page-sub { color: var(--muted); font-size: 14px; margin-bottom: 24px; }

		.toolbar { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 18px 22px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 20px; box-shadow: 0 1px 2px rgba(12,10,9,.04); }
		.date-nav { display: flex; align-items: center; gap: 10px; flex-wrap: nowrap; min-width: 0; }
		.nav-btn { flex: 0 0 auto; display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; border-radius: 10px; border: 1.5px solid var(--line); color: var(--ink-2); background: #fff; transition: background .15s, border-color .15s, color .15s; }
		.nav-btn:hover { background: var(--brand-soft); border-color: var(--brand); color: var(--brand); }
		.current-date { flex: 1 1 auto; min-width: 0; font-weight: 700; font-size: 16px; text-align: center; color: var(--ink); padding: 0 6px; }
		.current-date small { display: block; font-size: 12px; font-weight: 500; color: var(--muted); text-transform: uppercase; letter-spacing: .08em; margin-top: 2px; }
		.today-pill { display: inline-block; background: var(--success-soft); color: var(--success); font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 8px; margin-left: 8px; letter-spacing: .04em; text-transform: uppercase; white-space: nowrap; }
		.date-form { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
		#todayBtnWrap { display: inline-flex; }
		.date-form input[type="date"] { padding: 8px 10px; border: 1.5px solid var(--line); border-radius: 10px; font: inherit; font-size: 14px; color: var(--ink); background: #fff; }
		.date-form input[type="date"]:focus { outline: 0; border-color: var(--brand); box-shadow: 0 0 0 3px rgba(234,88,12,.15); }
		.btn-today { padding: 8px 14px; border-radius: 10px; border: 1.5px solid var(--line); background: #fff; font-size: 14px; font-weight: 600; color: var(--ink-2); transition: background .15s, border-color .15s, color .15s; }
		.btn-today:hover { background: var(--brand-soft); border-color: var(--brand); color: var(--brand); }

		.flash { padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 500; }
		.flash-success { background: var(--success-soft); color: var(--success); }
		.flash-error { background: var(--danger-soft); color: var(--danger); }

		.list-card { background: #fff; border: 1px solid var(--line); border-radius: 16px; overflow: hidden; box-shadow: 0 1px 2px rgba(12,10,9,.04); }
		#reservationsBody { overflow-x: auto; padding: 4px 14px 14px; }
		.list-head { padding: 16px 22px; border-bottom: 1px solid var(--line); display: flex; align-items: center; justify-content: space-between; background: var(--surface); }
		.list-head-title { font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); }
		.count-pill { background: var(--brand); color: #fff; font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 10px; }

		.empty { padding: 56px 24px; text-align: center; color: var(--muted); }
		.empty-icon { width: 56px; height: 56px; border-radius: 50%; background: var(--brand-soft); color: var(--brand); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 14px; }

		table { width: 100%; border-collapse: separate; border-spacing: 0 8px; margin-top: -4px; }
		th { text-align: left; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); padding: 10px 22px 6px 22px; background: transparent; }
		tbody tr td { padding: 16px 22px; font-size: 14px; vertical-align: middle; background: #fff; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); transition: background .15s, border-color .15s; }
		tbody tr td:first-child { border-left: 3px solid var(--brand); border-top-left-radius: 12px; border-bottom-left-radius: 12px; padding-left: 19px; }
		tbody tr td:last-child { border-right: 1px solid var(--line); border-top-right-radius: 12px; border-bottom-right-radius: 12px; }
		tbody tr:hover td { background: var(--brand-soft); }
		tbody tr:hover td:first-child { border-left-color: var(--brand-2); }
		tbody tr.row-past td { background: #fafafa; color: var(--ink-3); }
		tbody tr.row-past td:first-child { border-left-color: var(--muted); }
		tbody tr.row-past:hover td { background: #f5f5f5; }
		.time { font-weight: 700; color: var(--ink); white-space: nowrap; }
		.duration { color: var(--muted); font-size: 12px; }
		.court-name { font-weight: 600; }
		.court-loc { color: var(--muted); font-size: 12px; }
		.customer { font-weight: 600; }
		.customer-meta { color: var(--muted); font-size: 12px; }
		.customer-meta a { color: inherit; }
		.customer-meta a:hover { color: var(--brand); }
		.actions-cell { text-align: right; white-space: nowrap; }
		.action-group { display: inline-flex; gap: 8px; align-items: center; justify-content: flex-end; }
		.btn-cancel { background: var(--danger); color: #fff; padding: 8px 14px; border-radius: 10px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: transform .15s, box-shadow .15s; }
		.btn-cancel:hover { transform: translateY(-1px); box-shadow: 0 6px 14px rgba(220,38,38,.28); }
		.btn-message { background: #fff; border: 1.5px solid var(--line); color: var(--ink-2); padding: 7px 14px; border-radius: 10px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: background .15s, border-color .15s, color .15s; }
		.btn-message:hover { background: var(--brand-soft); border-color: var(--brand); color: var(--brand); }
		.past-pill { font-size: 11px; color: var(--muted); font-weight: 600; background: var(--line); padding: 4px 10px; border-radius: 8px; }

		.pag-wrap { display: flex; align-items: center; justify-content: center; gap: 14px; padding: 16px 22px; border-top: 1px solid var(--line); }
		.pag-btn { width: 36px; height: 36px; border-radius: 10px; border: 1.5px solid var(--line); background: #fff; color: var(--ink); font-size: 22px; line-height: 1; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: background .15s, border-color .15s, color .15s; text-decoration: none; }
		.pag-btn:hover:not([disabled]) { background: var(--brand-soft); border-color: var(--brand); color: var(--brand); }
		.pag-btn[disabled] { opacity: .35; cursor: not-allowed; pointer-events: none; }
		.pag-info { font-size: 14px; font-weight: 600; color: var(--ink-2); min-width: 56px; text-align: center; }

		.msg-modal { position: fixed; inset: 0; background: rgba(0,0,0,0.55); display: none; align-items: center; justify-content: center; z-index: 1000; padding: 20px; }
		.msg-modal.open { display: flex; }
		.msg-modal-card { background: #fff; border-radius: 16px; max-width: 520px; width: 100%; padding: 24px; box-shadow: 0 20px 60px rgba(0,0,0,0.25); }
		.msg-modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
		.msg-modal-header h2 { margin: 0; font-size: 20px; font-weight: 800; letter-spacing: -.01em; }
		.msg-modal-close { background: transparent; border: 0; font-size: 24px; cursor: pointer; color: var(--muted); width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; line-height: 1; }
		.msg-modal-close:hover { background: var(--surface); color: var(--ink); }
		.msg-modal-recipient { color: var(--muted); font-size: 14px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid var(--line); }
		.msg-modal-recipient strong { color: var(--ink); font-weight: 700; }
		#msgText { width: 100%; min-height: 140px; padding: 12px 14px; border: 1.5px solid var(--line); border-radius: 10px; font: inherit; font-size: 14px; resize: vertical; box-sizing: border-box; color: var(--ink); }
		#msgText:focus { outline: 0; border-color: var(--brand); box-shadow: 0 0 0 3px rgba(234,88,12,.15); }
		.msg-modal-error { color: var(--danger); font-size: 13px; margin-top: 8px; min-height: 18px; font-weight: 500; }
		.msg-modal-footer { display: flex; gap: 10px; justify-content: flex-end; margin-top: 8px; }
		.btn-msg-cancel { padding: 10px 18px; border-radius: 10px; border: 1.5px solid var(--line); background: #fff; font-weight: 600; font-size: 14px; color: var(--ink-2); transition: background .15s; }
		.btn-msg-cancel:hover { background: var(--surface); }
		.btn-msg-send { padding: 10px 20px; border-radius: 10px; background: var(--brand); color: #fff; font-weight: 600; font-size: 14px; transition: background .15s; }
		.btn-msg-send:hover { background: var(--brand-2); }
		.btn-msg-send:disabled { opacity: 0.6; cursor: not-allowed; }

		.admin-toast { position: fixed; top: 24px; right: 24px; z-index: 1100; padding: 14px 20px; background: var(--success); color: #fff; border-radius: 12px; font-weight: 600; font-size: 14px; box-shadow: 0 8px 24px rgba(0,0,0,0.2); transform: translateX(calc(100% + 40px)); transition: transform .3s ease; max-width: 360px; }
		.admin-toast.show { transform: translateX(0); }
		.admin-toast.error { background: var(--danger); }

		@media (max-width: 960px) {
			.toolbar { flex-direction: column; align-items: stretch; }
			.date-nav { justify-content: space-between; }
			.date-form { justify-content: center; }
			.date-form input[type="date"] { flex: 1 1 auto; min-width: 160px; }
			table { border-spacing: 0; margin-top: 0; }
			table thead { display: none; }
			table, tbody, tr, td { display: block; width: 100%; }
			tbody tr { background: #fff; border: 1px solid var(--line); border-left: 3px solid var(--brand); border-radius: 12px; padding: 16px 18px; margin: 12px 0; box-shadow: 0 1px 2px rgba(12,10,9,.04); }
			tbody tr td { padding: 4px 0; border: 0; background: transparent; border-radius: 0; }
			tbody tr td:first-child, tbody tr td:last-child { border: 0; border-radius: 0; padding-left: 0; padding-right: 0; }
			tbody tr:hover td { background: transparent; }
			tbody tr.row-past { border-left-color: var(--muted); background: #fafafa; }
			tbody tr.row-past td { background: transparent; }
			tbody tr.row-past:hover td { background: transparent; }
			td.actions-cell { text-align: left; margin-top: 10px; white-space: normal; }
			.action-group { flex-wrap: wrap; justify-content: flex-start; }
		}

		@media (max-width: 480px) {
			.container { padding: 20px 14px 48px; }
			.toolbar { padding: 14px; }
			.nav-btn { width: 36px; height: 36px; }
			.current-date { font-size: 14px; padding: 0 4px; }
			.current-date small { font-size: 10px; }
			.today-pill { margin-left: 6px; font-size: 10px; padding: 1px 6px; }
			.date-form { flex-direction: column; align-items: stretch; }
			.date-form input[type="date"] { width: 100%; }
			.btn-today { width: 100%; text-align: center; }
			#todayBtnWrap { display: block; }
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
		<p class="page-sub">Pregled i upravljanje rezervisanim terminima.</p>

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

		<div class="list-card" id="reservationsCard">
			<div class="list-head">
				<span class="list-head-title">Termini za izabrani dan</span>
				<span class="count-pill" id="countPill">{{ $reservationsTotal }}</span>
			</div>

			<div id="reservationsBody">
				@if ($reservations->isEmpty())
					<div class="empty">
						<div class="empty-icon">
							<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
						</div>
						<p>Nema rezervisanih termina za ovaj dan.</p>
					</div>
				@else
					<table>
						<thead>
							<tr>
								<th>Vreme</th>
								<th>Teren</th>
								<th>Klijent</th>
								<th>Kontakt</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($reservations as $reservation)
								@php
									$start = $reservation->startAt();
									$end = $start->addMinutes((int) $reservation->timeSlot->duration_minutes);
									$isFuture = $start->greaterThan($now);
								@endphp
								<tr @class(['row-past' => !$isFuture])>
									<td>
										<div class="time">{{ $start->format('H:i') }} – {{ $end->format('H:i') }}</div>
										<div class="duration">{{ $reservation->timeSlot->label }}</div>
									</td>
									<td>
										<div class="court-name">{{ $reservation->court->name }}</div>
										<div class="court-loc">{{ $reservation->court->location }}</div>
									</td>
									<td>
										<div class="customer">{{ $reservation->first_name }} {{ $reservation->last_name }}</div>
									</td>
									<td>
										<div class="customer-meta"><a href="tel:{{ $reservation->phone }}">{{ $reservation->phone }}</a></div>
										<div class="customer-meta"><a href="mailto:{{ $reservation->email }}">{{ $reservation->email }}</a></div>
									</td>
									<td class="actions-cell">
										<div class="action-group">
											<button type="button" class="btn-message"
												data-message-url="{{ route('admin.reservations.message', ['reservation' => $reservation->id]) }}"
												data-message-name="{{ $reservation->first_name }} {{ $reservation->last_name }}"
												data-message-email="{{ $reservation->email }}">
												<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
												Poruka
											</button>
											@if ($isFuture)
												<form method="post" action="{{ route('admin.reservations.cancel', ['reservation' => $reservation->id]) }}" data-confirm="Otkazati termin za {{ $reservation->first_name }} {{ $reservation->last_name }} u {{ $start->format('H:i') }}?" style="margin:0">
													@csrf
													<button type="submit" class="btn-cancel">
														<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
														Otkaži
													</button>
												</form>
											@else
												<span class="past-pill">Prošao</span>
											@endif
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				@endif
			</div>
			<div id="reservationsPagination" class="pag-wrap"@if(!$reservations->hasPages()) style="display:none"@endif>
				@if ($reservations->hasPages())
					<button class="pag-btn" data-nav-page="{{ $reservations->currentPage() - 1 }}" {{ $reservations->onFirstPage() ? 'disabled' : '' }}>&#8249;</button>
					<span class="pag-info" id="pagInfo">{{ $reservations->currentPage() }} / {{ $reservations->lastPage() }}</span>
					<button class="pag-btn" data-nav-page="{{ $reservations->currentPage() + 1 }}" {{ !$reservations->hasMorePages() ? 'disabled' : '' }}>&#8250;</button>
				@endif
			</div>
		</div>
	</div>

	<div class="msg-modal" id="msgModal" role="dialog" aria-modal="true" aria-labelledby="msgModalTitle">
		<div class="msg-modal-card">
			<div class="msg-modal-header">
				<h2 id="msgModalTitle">Pošalji poruku</h2>
				<button type="button" class="msg-modal-close" id="msgModalClose" aria-label="Zatvori">×</button>
			</div>
			<div class="msg-modal-recipient">Za: <strong id="msgRecipient"></strong></div>
			<form id="msgForm">
				<textarea id="msgText" placeholder="Unesite poruku... (npr. Molim vas ponesite svoje loptice.)" rows="6" maxlength="2000" required></textarea>
				<div class="msg-modal-error" id="msgError"></div>
				<div class="msg-modal-footer">
					<button type="button" class="btn-msg-cancel" id="msgCancel">Odustani</button>
					<button type="submit" class="btn-msg-send" id="msgSend">Pošalji</button>
				</div>
			</form>
		</div>
	</div>

	<div class="admin-toast" id="adminToast"><span id="adminToastText"></span></div>

	<script>
		const dashboardBase = '{{ route('admin.dashboard') }}';
		const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

		// Mobile nav toggle
		const adminNavToggle = document.getElementById('adminNavToggle');
		const adminTopbarRight = document.getElementById('adminTopbarRight');
		if (adminNavToggle && adminTopbarRight) {
			adminNavToggle.addEventListener('click', () => adminTopbarRight.classList.toggle('open'));
		}

		function esc(s) {
			return String(s ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
		}

		let currentDate = '{{ $date->toDateString() }}';
		let currentResPage = {{ $reservations->currentPage() }};

		function navToDate(dateStr) {
			currentDate = dateStr || '';
			currentResPage = 1;
			const url = dateStr ? dashboardBase + '?date=' + encodeURIComponent(dateStr) : dashboardBase;
			history.pushState({ date: dateStr, page: 1 }, '', url);
			loadDate(dateStr, 1);
		}

		async function loadDate(dateStr, page, scrollDir) {
			page = page || 1;
			currentDate = dateStr || '';
			currentResPage = page;
			let url = dateStr ? dashboardBase + '?date=' + encodeURIComponent(dateStr) : dashboardBase;
			if (page > 1) url += (dateStr ? '&' : '?') + 'page=' + page;
			document.getElementById('reservationsBody').style.opacity = '0.5';
			try {
				const res = await fetch(url, {
					headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
				});
				if (!res.ok) { window.location.reload(); return; }
				renderDate(await res.json(), scrollDir);
			} catch {
				window.location.reload();
			}
		}

		function renderDate(data, scrollDir) {
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

			const pagWrap = document.getElementById('reservationsPagination');
			if (data.lastPage > 1) {
				const prevDis = data.currentPage <= 1 ? ' disabled' : '';
				const nextDis = data.currentPage >= data.lastPage ? ' disabled' : '';
				pagWrap.innerHTML =
					'<button class="pag-btn" data-nav-page="' + (data.currentPage - 1) + '"' + prevDis + '>&#8249;</button>'
					+ '<span class="pag-info" id="pagInfo">' + data.currentPage + ' / ' + data.lastPage + '</span>'
					+ '<button class="pag-btn" data-nav-page="' + (data.currentPage + 1) + '"' + nextDis + '>&#8250;</button>';
				pagWrap.style.display = '';
			} else {
				pagWrap.style.display = 'none';
			}

			const body = document.getElementById('reservationsBody');
			body.style.opacity = '';
			if (data.reservations.length === 0) {
				body.innerHTML = '<div class="empty"><div class="empty-icon">'
					+ '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>'
					+ '</div><p>Nema rezervisanih termina za ovaj dan.</p></div>';
			} else {
				const cancelSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>';
				const messageSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>';
				const rows = data.reservations.map(r => {
					const messageBtn = '<button type="button" class="btn-message"'
						+ ' data-message-url="' + esc(r.messageUrl) + '"'
						+ ' data-message-name="' + esc(r.firstName) + ' ' + esc(r.lastName) + '"'
						+ ' data-message-email="' + esc(r.email) + '">'
						+ messageSvg + ' Poruka</button>';
					const tail = r.isFuture
						? '<form method="post" action="' + esc(r.cancelUrl) + '" data-confirm="Otkazati termin za ' + esc(r.firstName) + ' ' + esc(r.lastName) + ' u ' + esc(r.startTime) + '?" style="margin:0">'
						+ '<input type="hidden" name="_token" value="' + esc(csrfToken) + '">'
						+ '<button type="submit" class="btn-cancel">' + cancelSvg + ' Otkaži</button></form>'
						: '<span class="past-pill">Prošao</span>';
					const action = '<div class="action-group">' + messageBtn + tail + '</div>';
					const rowClass = r.isFuture ? '' : ' class="row-past"';
					return '<tr' + rowClass + '>'
						+ '<td><div class="time">' + esc(r.startTime) + ' – ' + esc(r.endTime) + '</div><div class="duration">' + esc(r.durationLabel) + '</div></td>'
						+ '<td><div class="court-name">' + esc(r.courtName) + '</div><div class="court-loc">' + esc(r.courtLocation) + '</div></td>'
						+ '<td><div class="customer">' + esc(r.firstName) + ' ' + esc(r.lastName) + '</div></td>'
						+ '<td><div class="customer-meta"><a href="tel:' + esc(r.phone) + '">' + esc(r.phone) + '</a></div>'
						+ '<div class="customer-meta"><a href="mailto:' + esc(r.email) + '">' + esc(r.email) + '</a></div></td>'
						+ '<td class="actions-cell">' + action + '</td>'
						+ '</tr>';
				}).join('');
				body.innerHTML = '<table><thead><tr><th>Vreme</th><th>Teren</th><th>Klijent</th><th>Kontakt</th><th></th></tr></thead><tbody>' + rows + '</tbody></table>';
			}

			const card = document.getElementById('reservationsCard');
			if (scrollDir === 'next') {
				card.scrollIntoView({ behavior: 'smooth', block: 'start' });
			} else if (scrollDir === 'prev') {
				card.scrollIntoView({ behavior: 'smooth', block: 'end' });
			}
		}

		document.addEventListener('click', function (e) {
			const navBtn = e.target.closest('[data-nav-date]');
			if (navBtn) { e.preventDefault(); navToDate(navBtn.dataset.navDate); return; }
			const todayBtn = e.target.closest('[data-nav-today]');
			if (todayBtn) { e.preventDefault(); navToDate(''); return; }
			const pagBtn = e.target.closest('[data-nav-page]');
			if (pagBtn && !pagBtn.hasAttribute('disabled')) {
				e.preventDefault();
				const newPage = +pagBtn.dataset.navPage;
				const dir = newPage > currentResPage ? 'next' : 'prev';
				loadDate(currentDate, newPage, dir);
			}
		});

		document.getElementById('dateInput').addEventListener('change', function () {
			navToDate(this.value);
		});

		window.addEventListener('popstate', function () {
			const date = new URLSearchParams(window.location.search).get('date') ?? '';
			loadDate(date);
		});

		document.addEventListener('submit', function (e) {
			const msg = e.target.dataset.confirm;
			if (msg && !confirm(msg)) e.preventDefault();
		});

		// ===== MESSAGE MODAL + TOAST =====
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
			msgModal.classList.add('open');
			setTimeout(() => msgText.focus(), 50);
		}

		function closeMsgModal() {
			msgModal.classList.remove('open');
			msgCurrentUrl = null;
		}

		function showAdminToast(text, type) {
			adminToast.classList.toggle('error', type === 'error');
			adminToastText.textContent = text;
			adminToast.classList.add('show');
			clearTimeout(adminToastTimer);
			adminToastTimer = setTimeout(() => adminToast.classList.remove('show'), 3500);
		}

		document.addEventListener('click', function (e) {
			const btn = e.target.closest('[data-message-url]');
			if (btn) {
				e.preventDefault();
				openMsgModal(btn.dataset.messageUrl, btn.dataset.messageName, btn.dataset.messageEmail);
			}
		});

		document.getElementById('msgModalClose').addEventListener('click', closeMsgModal);
		document.getElementById('msgCancel').addEventListener('click', closeMsgModal);
		msgModal.addEventListener('click', function (e) { if (e.target === msgModal) closeMsgModal(); });
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && msgModal.classList.contains('open')) closeMsgModal();
		});

		msgForm.addEventListener('submit', async function (e) {
			e.preventDefault();
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
		});
	</script>
</body>
</html>
