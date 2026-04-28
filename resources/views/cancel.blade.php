<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Otkazivanje rezervacije — Teniski klub Winner</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
			--warn: #d97706;
			--warn-soft: #fef3c7;
		}
		html, body { min-height: 100%; }
		body {
			font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
			color: var(--ink);
			background: linear-gradient(180deg, var(--brand-soft) 0%, var(--surface) 100%);
			line-height: 1.6;
			-webkit-font-smoothing: antialiased;
			display: flex;
			min-height: 100vh;
			justify-content: center;
			padding: 24px;
		}
		a { color: var(--brand); }
		a:hover { color: var(--brand-2); }
		.shell { width: 100%; max-width: 620px; margin: auto; }
		.brand-top { display: flex; align-items: center; gap: 12px; margin-bottom: 28px; justify-content: center; }
		.brand-mark { width: 52px; height: 52px; border-radius: 50%; overflow: hidden; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }
		.brand-mark img { width: 100%; height: 100%; object-fit: contain; }
		.brand-text { font-weight: 800; letter-spacing: -.02em; font-size: 18px; color: var(--ink); }
		.brand-text small { display: block; font-size: 11px; font-weight: 500; color: var(--muted); letter-spacing: .08em; text-transform: uppercase; }
		.card { background: #fff; border-radius: 24px; box-shadow: 0 20px 50px -12px rgba(12,10,9,.16); overflow: hidden; }
		.card-top { padding: 36px 36px 28px; text-align: center; border-bottom: 1px solid var(--line); }
		.status-icon { width: 72px; height: 72px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 18px; }
		.status-icon svg { width: 36px; height: 36px; stroke-width: 2.4; }
		.status-icon.ok { background: var(--success-soft); color: var(--success); }
		.status-icon.warn { background: var(--warn-soft); color: var(--warn); }
		.status-icon.err { background: var(--danger-soft); color: var(--danger); }
		.status-icon.neutral { background: var(--brand-soft); color: var(--brand); }
		h1 { font-size: 26px; font-weight: 800; letter-spacing: -.02em; color: var(--ink); line-height: 1.2; margin-bottom: 10px; }
		.sub { font-size: 15px; color: var(--ink-3); max-width: 440px; margin: 0 auto; }
		.sub strong { color: var(--ink); }
		.card-body { padding: 28px 36px 36px; }
		.details { background: var(--surface); border: 1px solid var(--line); border-radius: 16px; padding: 22px; margin-bottom: 24px; }
		.details-title { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: var(--muted); margin-bottom: 14px; }
		.detail-row { display: flex; justify-content: space-between; gap: 12px; padding: 10px 0; border-top: 1px solid var(--line); font-size: 14px; }
		.detail-row:first-of-type { border-top: 0; padding-top: 0; }
		.detail-row:last-of-type { padding-bottom: 0; }
		.detail-label { color: var(--muted); font-weight: 500; }
		.detail-value { color: var(--ink); font-weight: 600; text-align: right; }
		.actions { display: flex; gap: 12px; flex-wrap: wrap; }
		.btn { flex: 1; min-width: 160px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; font-weight: 600; font-size: 15px; border-radius: 12px; padding: 14px 22px; cursor: pointer; transition: transform .2s, box-shadow .2s, background .2s; text-decoration: none; border: 0; }
		.btn-danger { background: var(--danger); color: #fff; box-shadow: 0 8px 20px rgba(220,38,38,.28); }
		.btn-danger:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(220,38,38,.38); color: #fff; }
		.btn-secondary { background: var(--surface); color: var(--ink-2); border: 1.5px solid var(--line); }
		.btn-secondary:hover { background: #fff; border-color: var(--ink-3); color: var(--ink); }
		.btn-primary { background: linear-gradient(135deg, var(--brand), var(--brand-2)); color: #fff; box-shadow: 0 8px 20px rgba(234,88,12,.28); }
		.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(234,88,12,.38); color: #fff; }
		.phone-callout { margin-top: 20px; padding: 18px 20px; background: var(--warn-soft); border: 1px solid #fde68a; border-radius: 14px; display: flex; align-items: center; gap: 14px; }
		.phone-callout-icon { width: 44px; height: 44px; border-radius: 50%; background: #fff; color: var(--warn); display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }
		.phone-callout-text { flex: 1; min-width: 0; font-size: 14px; color: #78350f; }
		.phone-callout-text strong { display: block; font-size: 18px; color: var(--ink); margin-top: 2px; letter-spacing: -.01em; }
		.phone-callout-text a { color: var(--ink); text-decoration: none; }
		.note { font-size: 13px; color: var(--muted); margin-top: 18px; text-align: center; }
		.home-link { display: inline-flex; align-items: center; gap: 6px; font-size: 14px; margin-top: 22px; color: var(--muted); justify-content: center; width: 100%; }
		.home-link:hover { color: var(--brand); }
		@media (max-width: 560px) {
			body { padding: 16px; }
			.card-top { padding: 28px 22px 22px; }
			.card-body { padding: 22px; }
			h1 { font-size: 22px; }
			.actions { flex-direction: column; }
			.btn { width: 100%; }
			.detail-row { flex-direction: column; gap: 2px; padding: 8px 0; }
			.detail-value { text-align: left; }
		}
	</style>
</head>
<body>
	<div class="shell">
		<div class="brand-top">
			<span class="brand-mark">
				<img src="{{ asset('images/logo.svg') }}" alt="TK Winner logo">
			</span>
			<span class="brand-text">
				TK WINNER
				<small>Smederevska Palanka</small>
			</span>
		</div>

		<div class="card">
			@php
				$fmtStart = null;
				$fmtEnd = null;
				if ($reservation !== null) {
					$start = $reservation->startAt();
					$fmtStart = $start;
					$fmtEnd = $start->addMinutes((int) $reservation->timeSlot->duration_minutes);
				}
			@endphp

			@if ($status === 'cancellable')
				<div class="card-top">
					<div class="status-icon neutral">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
					</div>
					<h1>Da li zaista želite da otkažete termin?</h1>
					<p class="sub">Ako potvrdite, termin će biti <strong>trajno obrisan</strong> i slot će postati ponovo dostupan za rezervaciju.</p>
				</div>
				<div class="card-body">
					<div class="details">
						<div class="details-title">Detalji rezervacije</div>
						<div class="detail-row"><span class="detail-label">Ime i prezime</span><span class="detail-value">{{ $reservation->first_name }} {{ $reservation->last_name }}</span></div>
						<div class="detail-row"><span class="detail-label">Teren</span><span class="detail-value">{{ $reservation->court->name }} · {{ $reservation->court->location }}</span></div>
						<div class="detail-row"><span class="detail-label">Datum</span><span class="detail-value">{{ $fmtStart->isoFormat('dddd, D. MMMM YYYY.') }}</span></div>
						<div class="detail-row"><span class="detail-label">Vreme</span><span class="detail-value">{{ $fmtStart->format('H:i') }} – {{ $fmtEnd->format('H:i') }}</span></div>
						<div class="detail-row"><span class="detail-label">Trajanje</span><span class="detail-value">{{ $reservation->timeSlot->label }}</span></div>
					</div>

					<form method="post" action="{{ route('reservations.cancel', ['token' => $reservation->cancellation_token]) }}" onsubmit="return confirm('Da li ste sigurni da želite da otkažete termin?');">
						@csrf
						<div class="actions">
							<a href="{{ route('reservations.index') }}" class="btn btn-secondary">Ne, vrati se</a>
							<button type="submit" class="btn btn-danger">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
								Otkaži termin
							</button>
						</div>
					</form>
					<p class="note">Otkazivanje online je moguće do 6 sati pre termina.</p>
				</div>

			@elseif ($status === 'cancelled')
				<div class="card-top">
					<div class="status-icon ok">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
					</div>
					<h1>Termin je otkazan</h1>
					<p class="sub">Vaša rezervacija je uspešno otkazana. Slot je ponovo dostupan drugim igračima.</p>
				</div>
				<div class="card-body">
					<div class="details">
						<div class="details-title">Otkazana rezervacija</div>
						<div class="detail-row"><span class="detail-label">Teren</span><span class="detail-value">{{ $reservation->court->name }}</span></div>
						<div class="detail-row"><span class="detail-label">Datum</span><span class="detail-value">{{ $fmtStart->isoFormat('dddd, D. MMMM YYYY.') }}</span></div>
						<div class="detail-row"><span class="detail-label">Vreme</span><span class="detail-value">{{ $fmtStart->format('H:i') }} – {{ $fmtEnd->format('H:i') }}</span></div>
					</div>
					<a href="{{ route('reservations.index') }}" class="btn btn-primary" style="width:100%">Rezerviši novi termin</a>
				</div>

			@elseif ($status === 'too_late')
				<div class="card-top">
					<div class="status-icon warn">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
					</div>
					<h1>Otkazivanje preko sajta više nije moguće</h1>
					<p class="sub">Vaš termin počinje za <strong>manje od 6 sati</strong>. Pravila kluba dozvoljavaju online otkazivanje samo dok do početka ima više od 6 sati.</p>
				</div>
				<div class="card-body">
					<div class="details">
						<div class="details-title">Vaš termin</div>
						<div class="detail-row"><span class="detail-label">Teren</span><span class="detail-value">{{ $reservation->court->name }}</span></div>
						<div class="detail-row"><span class="detail-label">Datum</span><span class="detail-value">{{ $fmtStart->isoFormat('dddd, D. MMMM YYYY.') }}</span></div>
						<div class="detail-row"><span class="detail-label">Vreme</span><span class="detail-value">{{ $fmtStart->format('H:i') }} – {{ $fmtEnd->format('H:i') }}</span></div>
					</div>

					<div class="phone-callout">
						<div class="phone-callout-icon">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.37 1.9.72 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.59 2.81.72A2 2 0 0 1 22 16.92z"/></svg>
						</div>
						<div class="phone-callout-text">
							Ako ipak želite da otkažete, pozovite nas:
							<strong><a href="tel:{{ preg_replace('/[^+0-9]/', '', $contactPhone) }}">{{ $contactPhone }}</a></strong>
						</div>
					</div>
				</div>

			@else {{-- not_found --}}
				<div class="card-top">
					<div class="status-icon err">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
					</div>
					<h1>Link nije važeći</h1>
					<p class="sub">Ova veza za otkazivanje ne postoji ili je već iskorišćena. Moguće je da ste već otkazali termin, ili je link istekao.</p>
				</div>
				<div class="card-body">
					<div class="phone-callout">
						<div class="phone-callout-icon">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.37 1.9.72 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.59 2.81.72A2 2 0 0 1 22 16.92z"/></svg>
						</div>
						<div class="phone-callout-text">
							Za pomoć pozovite:
							<strong><a href="tel:{{ preg_replace('/[^+0-9]/', '', $contactPhone) }}">{{ $contactPhone }}</a></strong>
						</div>
					</div>
					<a href="{{ route('reservations.index') }}" class="btn btn-primary" style="width:100%;margin-top:18px">Idi na početnu</a>
				</div>
			@endif
		</div>

		<a href="{{ route('reservations.index') }}" class="home-link">← Nazad na tkwinner.net</a>
	</div>
</body>
</html>
