<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Admin panel — Tereni — Teniski klub Winner</title>

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

		.container { max-width: 900px; margin: 0 auto; padding: 32px 24px 64px; }
		h1 { font-size: 26px; font-weight: 800; letter-spacing: -.02em; margin-bottom: 6px; }
		.page-sub { color: var(--muted); font-size: 14px; margin-bottom: 24px; }

		.flash { padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 500; }
		.flash-success { background: var(--success-soft); color: var(--success); }
		.flash-error { background: var(--danger-soft); color: var(--danger); }

		.courts-list { display: flex; flex-direction: column; gap: 12px; }
		.court-card { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; box-shadow: 0 1px 2px rgba(12,10,9,.04); }
		.court-card.inactive { opacity: 0.6; }
		.court-info { flex: 1 1 auto; min-width: 0; }
		.court-name { font-size: 17px; font-weight: 700; color: var(--ink); }
		.court-location { font-size: 13px; color: var(--muted); margin-top: 2px; }
		.court-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 8px; margin-top: 8px; }
		.badge-active { background: var(--success-soft); color: var(--success); }
		.badge-inactive { background: var(--danger-soft); color: var(--danger); }
		.court-actions { flex-shrink: 0; }
		.btn-toggle { padding: 9px 18px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background .15s, border-color .15s, color .15s; border: 1.5px solid; }
		.btn-activate { background: var(--success-soft); border-color: var(--success); color: var(--success); }
		.btn-activate:hover { background: #bbf7d0; }
		.btn-deactivate { background: var(--danger-soft); border-color: var(--danger); color: var(--danger); }
		.btn-deactivate:hover { background: #fecaca; }

		@media (max-width: 600px) {
			.court-card { flex-direction: column; align-items: flex-start; }
			.court-actions { width: 100%; }
			.btn-toggle { width: 100%; text-align: center; }
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
					<a href="{{ route('admin.dashboard') }}">Rezervacije</a>
					<a href="{{ route('admin.blocked.index') }}">Blokirani</a>
					<a href="{{ route('admin.courts.index') }}" class="active">Tereni</a>
				</nav>
				<form method="post" action="{{ route('admin.logout') }}" class="logout-form">
					@csrf
					<button type="submit" class="btn-logout">Odjavi se</button>
				</form>
			</div>
		</div>
	</div>

	<div class="container">
		<h1>Tereni</h1>
		<p class="page-sub">Aktiviraj ili deaktiviraj terene. Deaktivirani tereni se ne prikazuju na sajtu i ne mogu se rezervisati.</p>

		@if (session('success'))
			<div class="flash flash-success">{{ session('success') }}</div>
		@endif
		@if (session('error'))
			<div class="flash flash-error">{{ session('error') }}</div>
		@endif

		<div class="courts-list">
			@foreach ($courts as $court)
				<div class="court-card @unless($court->is_active) inactive @endunless">
					<div class="court-info">
						<div class="court-name">{{ $court->name }}</div>
						@if ($court->location)
							<div class="court-location">{{ $court->location }}</div>
						@endif
						@if ($court->is_active)
							<span class="court-badge badge-active">
								<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
								Aktivan
							</span>
						@else
							<span class="court-badge badge-inactive">
								<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
								Neaktivan
							</span>
						@endif
					</div>
					<div class="court-actions">
						<form method="post" action="{{ route('admin.courts.toggle', ['court' => $court->id]) }}"
							data-confirm="{{ $court->is_active ? 'Deaktivirati teren &quot;' . $court->name . '&quot;? Korisnici ga neće moći rezervisati.' : 'Aktivirati teren &quot;' . $court->name . '&quot;?' }}">
							@csrf
							@if ($court->is_active)
								<button type="submit" class="btn-toggle btn-deactivate">Deaktiviraj</button>
							@else
								<button type="submit" class="btn-toggle btn-activate">Aktiviraj</button>
							@endif
						</form>
					</div>
				</div>
			@endforeach
		</div>
	</div>

	<script>
		const adminNavToggle = document.getElementById('adminNavToggle');
		const adminTopbarRight = document.getElementById('adminTopbarRight');
		if (adminNavToggle && adminTopbarRight) {
			adminNavToggle.addEventListener('click', () => adminTopbarRight.classList.toggle('open'));
		}

		document.addEventListener('submit', function (e) {
			const msg = e.target.dataset.confirm;
			if (msg && !confirm(msg)) e.preventDefault();
		});
	</script>
</body>
</html>
