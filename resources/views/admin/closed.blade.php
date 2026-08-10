<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Admin panel — Neradni dani — Teniski klub Winner</title>

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
		@media (max-width: 860px) {
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

		.flash { padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 500; }
		.flash-success { background: var(--success-soft); color: var(--success); }
		.flash-error { background: var(--danger-soft); color: var(--danger); }

		.grid { display: grid; grid-template-columns: 380px 1fr; gap: 20px; align-items: start; }
		@media (max-width: 900px) { .grid { grid-template-columns: 1fr; } }

		.card { background: #fff; border: 1px solid var(--line); border-radius: 16px; overflow: hidden; box-shadow: 0 1px 2px rgba(12,10,9,.04); }
		.card-head { padding: 16px 22px; border-bottom: 1px solid var(--line); background: var(--surface); display: flex; align-items: center; justify-content: space-between; gap: 12px; }
		.card-head-title { font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); }
		.count-pill { background: var(--brand); color: #fff; font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 10px; }

		.form-body { padding: 20px 22px; }
		.field { margin-bottom: 14px; }
		.field label { display: block; font-size: 13px; font-weight: 600; color: var(--ink-2); margin-bottom: 6px; }
		.field input {
			width: 100%; padding: 10px 12px; border: 1.5px solid var(--line); border-radius: 10px;
			font: inherit; font-size: 16px; color: var(--ink); background: #fff;
		}
		.field input:focus { outline: 0; border-color: var(--brand); box-shadow: 0 0 0 3px rgba(234,88,12,.15); }
		.field .hint { font-size: 12px; color: var(--muted); margin-top: 4px; }
		.field-error { color: var(--danger); font-size: 12px; margin-top: 4px; font-weight: 500; }
		.btn-primary { width: 100%; padding: 12px; border-radius: 10px; background: var(--brand); color: #fff; font-weight: 700; font-size: 14px; transition: background .15s, transform .15s; }
		.btn-primary:hover { background: #c2410c; transform: translateY(-1px); }

		.info-note { display: flex; gap: 10px; background: var(--brand-soft); color: var(--ink-3); border-radius: 10px; padding: 12px 14px; font-size: 12.5px; line-height: 1.5; margin-top: 4px; }
		.info-note svg { flex-shrink: 0; color: var(--brand); margin-top: 2px; }

		.list-body { padding: 18px 22px; display: flex; flex-direction: column; gap: 10px; }
		.empty { padding: 56px 24px; text-align: center; color: var(--muted); }
		.empty-icon { width: 56px; height: 56px; border-radius: 50%; background: var(--brand-soft); color: var(--brand); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 14px; }

		.closed-item { display: flex; align-items: center; gap: 14px; padding: 12px 16px; background: #fff; border: 1px solid var(--line); border-left: 3px solid var(--brand); border-radius: 12px; transition: background .15s, box-shadow .15s; }
		.closed-item:hover { background: var(--brand-soft); box-shadow: 0 1px 3px rgba(12,10,9,.06); }
		.date-chip { flex-shrink: 0; width: 58px; padding: 6px 0; text-align: center; background: var(--brand-soft); color: var(--brand); border-radius: 10px; }
		.closed-item:hover .date-chip { background: #fff; }
		.chip-day { display: block; font-size: 19px; font-weight: 800; line-height: 1.15; }
		.chip-month { display: block; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; }
		.closed-meta { flex: 1 1 auto; min-width: 0; }
		.closed-title { font-size: 15px; font-weight: 700; color: var(--ink); display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
		.badge-today { background: var(--danger-soft); color: var(--danger); font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; padding: 2px 8px; border-radius: 7px; }
		.closed-reason { font-size: 13px; color: var(--muted); overflow-wrap: anywhere; }
		.closed-actions { flex-shrink: 0; }
		.btn-remove { background: var(--danger-soft); color: var(--danger); border: 1.5px solid transparent; padding: 8px 14px; border-radius: 10px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; gap: 6px; transition: background .15s, border-color .15s, transform .15s; }
		.btn-remove:hover { background: #fecaca; border-color: var(--danger); transform: translateY(-1px); }

		.btn-remove[disabled], .btn-primary[disabled] { opacity: .55; cursor: not-allowed; pointer-events: none; transform: none; }
		.spinner { width: 14px; height: 14px; border: 2px solid rgba(0,0,0,.15); border-top-color: currentColor; border-radius: 50%; animation: spin 1s linear infinite; display: inline-block; }
		.btn-primary .spinner { width: 16px; height: 16px; border-color: rgba(255,255,255,.4); border-top-color: #fff; }
		@keyframes spin { to { transform: rotate(360deg); } }

		@media (max-width: 600px) {
			.container { padding: 24px 16px 56px; }
			.closed-item { flex-wrap: wrap; }
			.closed-meta { flex: 1 1 140px; }
			.closed-actions { width: 100%; }
			.btn-remove { width: 100%; }
		}
	</style>
</head>
<body>
	<div class="topbar">
		<div class="topbar-inner">
			<a href="{{ route('admin.dashboard') }}" class="brand">
				<img src="{{ asset('images/logo.svg') }}" alt="TK Winner Logo" style="height: 55px;">
			</a>
			<button type="button" class="admin-nav-toggle" id="adminNavToggle" aria-label="Meni">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
			</button>
			<div class="topbar-right" id="adminTopbarRight">
				<nav class="admin-nav">
					<a href="{{ route('admin.dashboard') }}">Rezervacije</a>
					<a href="{{ route('admin.blocked.index') }}">Blokirani</a>
					<a href="{{ route('admin.closed.index') }}" class="active">Neradni dani</a>
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
		<h1>Neradni dani</h1>
		<p class="page-sub">Označi datume kada klub ne radi (odmor, praznik, radovi). Korisnici te datume neće moći da izaberu prilikom online rezervacije.</p>

		@if (session('success'))
			<div class="flash flash-success">{{ session('success') }}</div>
		@endif
		@if (session('error'))
			<div class="flash flash-error">{{ session('error') }}</div>
		@endif

		<div class="grid">
			<div class="card">
				<div class="card-head">
					<span class="card-head-title">Dodaj neradne dane</span>
				</div>
				<form method="post" action="{{ route('admin.closed.store') }}" class="form-body">
					@csrf
					<div class="field">
						<label for="date_from">Datum (od)</label>
						<input type="date" id="date_from" name="date_from" value="{{ old('date_from') }}" min="{{ $today->toDateString() }}" required>
						@error('date_from') <div class="field-error">{{ $message }}</div> @enderror
					</div>
					<div class="field">
						<label for="date_to">Datum (do) — opciono</label>
						<input type="date" id="date_to" name="date_to" value="{{ old('date_to') }}" min="{{ $today->toDateString() }}">
						<div class="hint">Ostavi prazno za jedan dan. Za odmor unesi period — svi dani između biće označeni.</div>
						@error('date_to') <div class="field-error">{{ $message }}</div> @enderror
					</div>
					<div class="field">
						<label for="reason">Razlog (opciono)</label>
						<input type="text" id="reason" name="reason" value="{{ old('reason') }}" maxlength="255" placeholder="npr. Godišnji odmor">
						@error('reason') <div class="field-error">{{ $message }}</div> @enderror
					</div>
					<button type="submit" class="btn-primary">Označi kao neradno</button>

					<div class="info-note">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
						<span>Već postojeće rezervacije se ne otkazuju automatski — ako ih ima, otkaži ih u tabu Rezervacije.</span>
					</div>
				</form>
			</div>

			<div class="card">
				<div class="card-head">
					<span class="card-head-title">Označeni datumi</span>
					<span class="count-pill">{{ $closedDates->count() }}</span>
				</div>

				@if ($closedDates->isEmpty())
					<div class="empty">
						<div class="empty-icon">
							<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
						</div>
						<p>Nema označenih neradnih dana. Klub radi svaki dan.</p>
					</div>
				@else
					<div class="list-body">
						@foreach ($closedDates as $closed)
							@php $d = $closed->date; @endphp
							<div class="closed-item">
								<div class="date-chip">
									<span class="chip-day">{{ $d->format('j') }}</span>
									<span class="chip-month">{{ $d->locale('sr')->isoFormat('MMM') }}</span>
								</div>
								<div class="closed-meta">
									<div class="closed-title">
										{{ $d->locale('sr')->isoFormat('dddd, D. MMMM YYYY.') }}
										@if ($d->isSameDay($today))
											<span class="badge-today">Danas</span>
										@endif
									</div>
									<div class="closed-reason">{{ $closed->reason ?: 'Klub ne radi' }}</div>
								</div>
								<div class="closed-actions">
									<form method="post" action="{{ route('admin.closed.destroy', ['closed' => $closed->id]) }}"
										data-confirm="Ukloniti {{ $d->format('d.m.Y.') }} sa liste neradnih dana? Korisnici će ponovo moći da rezervišu taj dan.">
										@csrf
										<button type="submit" class="btn-remove">
											<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
											Ukloni
										</button>
									</form>
								</div>
							</div>
						@endforeach
					</div>
				@endif
			</div>
		</div>
	</div>

	<script>
		const adminNavToggle = document.getElementById('adminNavToggle');
		const adminTopbarRight = document.getElementById('adminTopbarRight');
		if (adminNavToggle && adminTopbarRight) {
			adminNavToggle.addEventListener('click', () => adminTopbarRight.classList.toggle('open'));
		}

		// "do" ne može biti pre "od"
		const dateFrom = document.getElementById('date_from');
		const dateTo = document.getElementById('date_to');
		dateFrom.addEventListener('change', () => {
			dateTo.min = dateFrom.value || dateTo.getAttribute('min');
			if (dateTo.value && dateTo.value < dateFrom.value) dateTo.value = '';
		});

		// Dok traje slanje, blokiraj sva dugmad — dupli klik je pravio 404 na već obrisanom datumu.
		let submitting = false;
		document.addEventListener('submit', function (e) {
			const form = e.target;

			if (submitting) {
				e.preventDefault();
				return;
			}

			const msg = form.dataset.confirm;
			if (msg && !confirm(msg)) {
				e.preventDefault();
				return;
			}

			submitting = true;
			const btn = form.querySelector('button[type="submit"]');
			if (btn) {
				btn.dataset.label = btn.innerHTML;
				btn.innerHTML = '<span class="spinner"></span>' + (btn.classList.contains('btn-remove') ? ' Uklanjam…' : ' Čuvam…');
			}
			// Tek posle starta slanja, da disabled ne prekine submit.
			setTimeout(() => {
				document.querySelectorAll('.btn-remove, .btn-primary').forEach(b => { b.disabled = true; });
			}, 0);
		});

		// Povratak na stranicu iz keša (back dugme) — vrati dugmad u normalno stanje.
		window.addEventListener('pageshow', function () {
			submitting = false;
			document.querySelectorAll('.btn-remove, .btn-primary').forEach(b => {
				b.disabled = false;
				if (b.dataset.label) {
					b.innerHTML = b.dataset.label;
					delete b.dataset.label;
				}
			});
		});
	</script>
</body>
</html>
