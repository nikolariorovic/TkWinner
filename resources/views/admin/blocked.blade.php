<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Admin panel — Blokirani — Teniski klub Winner</title>

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

		.container { max-width: 1200px; margin: 0 auto; padding: 32px 24px 64px; }
		h1 { font-size: 26px; font-weight: 800; letter-spacing: -.02em; margin-bottom: 6px; }
		.page-sub { color: var(--muted); font-size: 14px; margin-bottom: 24px; }

		.flash { padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 500; }
		.flash-success { background: var(--success-soft); color: var(--success); }
		.flash-error { background: var(--danger-soft); color: var(--danger); }

		.grid { display: grid; grid-template-columns: 380px 1fr; gap: 20px; align-items: start; }
		@media (max-width: 900px) { .grid { grid-template-columns: 1fr; } }

		.card { background: #fff; border: 1px solid var(--line); border-radius: 16px; overflow: hidden; box-shadow: 0 1px 2px rgba(12,10,9,.04); }
		.card-head { padding: 16px 22px; border-bottom: 1px solid var(--line); background: var(--surface); display: flex; align-items: center; justify-content: space-between; }
		.card-head-title { font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); }
		.count-pill { background: var(--brand); color: #fff; font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 10px; }

		.form-body { padding: 20px 22px; }
		.field { margin-bottom: 14px; }
		.field label { display: block; font-size: 13px; font-weight: 600; color: var(--ink-2); margin-bottom: 6px; }
		.field input, .field textarea {
			width: 100%; padding: 10px 12px; border: 1.5px solid var(--line); border-radius: 10px;
			font: inherit; font-size: 14px; color: var(--ink); background: #fff;
		}
		.field input:focus, .field textarea:focus { outline: 0; border-color: var(--brand); box-shadow: 0 0 0 3px rgba(234,88,12,.15); }
		.field textarea { resize: vertical; min-height: 80px; }
		.field .hint { font-size: 12px; color: var(--muted); margin-top: 4px; }
		.field-error { color: var(--danger); font-size: 12px; margin-top: 4px; font-weight: 500; }
		.btn-block { width: 100%; padding: 12px; border-radius: 10px; background: var(--danger); color: #fff; font-weight: 700; font-size: 14px; transition: background .15s, transform .15s; }
		.btn-block:hover { background: #b91c1c; transform: translateY(-1px); }

		.list-body { padding: 4px 14px 14px; overflow-x: auto; }
		.empty { padding: 56px 24px; text-align: center; color: var(--muted); }
		.empty-icon { width: 56px; height: 56px; border-radius: 50%; background: var(--brand-soft); color: var(--brand); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 14px; }

		table { width: 100%; border-collapse: separate; border-spacing: 0 8px; margin-top: -4px; }
		th { text-align: left; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); padding: 10px 18px 6px 18px; background: transparent; }
		tbody tr td { padding: 14px 18px; font-size: 14px; vertical-align: middle; background: #fff; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
		tbody tr td:first-child { border-left: 3px solid var(--danger); border-top-left-radius: 12px; border-bottom-left-radius: 12px; padding-left: 15px; }
		tbody tr td:last-child { border-right: 1px solid var(--line); border-top-right-radius: 12px; border-bottom-right-radius: 12px; }
		tbody tr:hover td { background: var(--danger-soft); }
		.muted { color: var(--muted); font-size: 12px; }
		.reason { color: var(--ink-3); font-size: 13px; max-width: 320px; }
		.actions-cell { text-align: right; white-space: nowrap; }
		.btn-unblock { background: var(--success); color: #fff; padding: 8px 14px; border-radius: 10px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: transform .15s, box-shadow .15s; }
		.btn-unblock:hover { transform: translateY(-1px); box-shadow: 0 6px 14px rgba(22,163,74,.28); }

		.pag-wrap { display: flex; align-items: center; justify-content: center; gap: 14px; padding: 16px 22px; border-top: 1px solid var(--line); }
		.pag-btn { width: 36px; height: 36px; border-radius: 10px; border: 1.5px solid var(--line); background: #fff; color: var(--ink); font-size: 22px; line-height: 1; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: background .15s, border-color .15s, color .15s; text-decoration: none; }
		.pag-btn:hover { background: var(--brand-soft); border-color: var(--brand); color: var(--brand); }
		.pag-btn[disabled], .pag-btn.disabled { opacity: .35; cursor: not-allowed; pointer-events: none; }
		.pag-info { font-size: 14px; font-weight: 600; color: var(--ink-2); min-width: 56px; text-align: center; }

		@media (max-width: 720px) {
			table thead { display: none; }
			table, tbody, tr, td { display: block; width: 100%; }
			tbody tr { background: #fff; border: 1px solid var(--line); border-left: 3px solid var(--danger); border-radius: 12px; padding: 14px 16px; margin: 12px 0; }
			tbody tr td { padding: 4px 0; border: 0; background: transparent; border-radius: 0; }
			tbody tr td:first-child, tbody tr td:last-child { border: 0; border-radius: 0; padding-left: 0; padding-right: 0; }
			tbody tr:hover td { background: transparent; }
			td.actions-cell { text-align: left; margin-top: 10px; }
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
					<a href="{{ route('admin.blocked.index') }}" class="active">Blokirani</a>
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
		<h1>Blokirani korisnici</h1>
		<p class="page-sub">Dodaj email i broj telefona osobe koja se ne pojavljuje na zakazanim terminima. Online rezervacije neće biti dozvoljene za te kontakte.</p>

		@if (session('success'))
			<div class="flash flash-success">{{ session('success') }}</div>
		@endif
		@if (session('error'))
			<div class="flash flash-error">{{ session('error') }}</div>
		@endif

		<div class="grid">
			<div class="card">
				<div class="card-head">
					<span class="card-head-title">Dodaj blokadu</span>
				</div>
				<form method="post" action="{{ route('admin.blocked.store') }}" class="form-body">
					@csrf
					<div class="field">
						<label for="email">Email</label>
						<input type="email" id="email" name="email" value="{{ old('email') }}" required maxlength="150" autocomplete="off">
						@error('email') <div class="field-error">{{ $message }}</div> @enderror
					</div>
					<div class="field">
						<label for="phone">Broj telefona</label>
						<input type="text" id="phone" name="phone" value="{{ old('phone') }}" required maxlength="50" placeholder="npr. +381 64 123 4567">
						<div class="hint">Sve varijante istog broja se prepoznaju (+381, 0, razmaci, crtice...).</div>
						@error('phone') <div class="field-error">{{ $message }}</div> @enderror
					</div>
					<div class="field">
						<label for="reason">Razlog (opciono)</label>
						<textarea id="reason" name="reason" maxlength="500" placeholder="npr. Nije se pojavio na terminu 15.04.2026">{{ old('reason') }}</textarea>
						@error('reason') <div class="field-error">{{ $message }}</div> @enderror
					</div>
					<button type="submit" class="btn-block">Blokiraj korisnika</button>
				</form>
			</div>

			<div class="card" id="blockedCard">
				<div class="card-head">
					<span class="card-head-title">Lista blokiranih</span>
					<span class="count-pill" id="blockedCountPill">{{ $blocked->total() }}</span>
				</div>
				<div class="list-body" id="blockedBody">
					@if ($blocked->isEmpty())
						<div class="empty">
							<div class="empty-icon">
								<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
							</div>
							<p>Trenutno nema blokiranih korisnika.</p>
						</div>
					@else
						<table>
							<thead>
								<tr>
									<th>Kontakt</th>
									<th>Razlog</th>
									<th>Dodato</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach ($blocked as $b)
									<tr>
										<td>
											<div style="font-weight:600">{{ $b->email }}</div>
											<div class="muted">{{ $b->phone_raw }}</div>
										</td>
										<td class="reason">{{ $b->reason ?: '—' }}</td>
										<td class="muted">{{ $b->created_at?->locale('sr')->isoFormat('D.MM.YYYY.') }}</td>
										<td class="actions-cell">
											<form method="post" action="{{ route('admin.blocked.unblock', ['blocked' => $b->id]) }}" onsubmit="return confirm('Odblokirati ovog korisnika?');">
												@csrf
												<button type="submit" class="btn-unblock">Odblokiraj</button>
											</form>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					@endif
				</div>
				<div id="blockedPagination" class="pag-wrap"@if(!$blocked->hasPages()) style="display:none"@endif>
					@if ($blocked->hasPages())
						<button class="pag-btn" data-pag-dir="prev" data-pag-page="{{ $blocked->currentPage() - 1 }}" {{ $blocked->onFirstPage() ? 'disabled' : '' }}>&#8249;</button>
						<span class="pag-info" id="blockedPagInfo">{{ $blocked->currentPage() }} / {{ $blocked->lastPage() }}</span>
						<button class="pag-btn" data-pag-dir="next" data-pag-page="{{ $blocked->currentPage() + 1 }}" {{ !$blocked->hasMorePages() ? 'disabled' : '' }}>&#8250;</button>
					@endif
				</div>
			</div>
		</div>
	</div>

	<script>
		const adminNavToggle = document.getElementById('adminNavToggle');
		const adminTopbarRight = document.getElementById('adminTopbarRight');
		if (adminNavToggle && adminTopbarRight) {
			adminNavToggle.addEventListener('click', () => adminTopbarRight.classList.toggle('open'));
		}

		// ===== BLOKIRANI PAGINACIJA =====
		const blockedBase = '{{ route('admin.blocked.index') }}';
		const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

		function esc(s) {
			return String(s ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
		}

		async function loadBlockedPage(page, scrollDir) {
			const url = page > 1 ? blockedBase + '?page=' + page : blockedBase;
			document.getElementById('blockedBody').style.opacity = '0.5';
			try {
				const res = await fetch(url, {
					headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
				});
				if (!res.ok) { window.location.reload(); return; }
				renderBlocked(await res.json(), scrollDir);
			} catch {
				window.location.reload();
			}
		}

		function renderBlocked(data, scrollDir) {
			document.getElementById('blockedCountPill').textContent = data.total;

			const body = document.getElementById('blockedBody');
			body.style.opacity = '';

			if (data.items.length === 0) {
				body.innerHTML = '<div class="empty"><div class="empty-icon">'
					+ '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>'
					+ '</div><p>Trenutno nema blokiranih korisnika.</p></div>';
			} else {
				const rows = data.items.map(b => {
					const unblockForm = '<form method="post" action="' + esc(b.unblockUrl) + '" onsubmit="return confirm(\'Odblokirati ovog korisnika?\');" style="margin:0">'
						+ '<input type="hidden" name="_token" value="' + esc(csrfToken) + '">'
						+ '<button type="submit" class="btn-unblock">Odblokiraj</button></form>';
					return '<tr>'
						+ '<td><div style="font-weight:600">' + esc(b.email) + '</div><div class="muted">' + esc(b.phone_raw) + '</div></td>'
						+ '<td class="reason">' + esc(b.reason || '—') + '</td>'
						+ '<td class="muted">' + esc(b.created_at || '') + '</td>'
						+ '<td class="actions-cell">' + unblockForm + '</td>'
						+ '</tr>';
				}).join('');
				body.innerHTML = '<table><thead><tr><th>Kontakt</th><th>Razlog</th><th>Dodato</th><th></th></tr></thead><tbody>' + rows + '</tbody></table>';
			}

			const pagWrap = document.getElementById('blockedPagination');
			if (data.lastPage > 1) {
				const prevDis = data.currentPage <= 1 ? ' disabled' : '';
				const nextDis = data.currentPage >= data.lastPage ? ' disabled' : '';
				pagWrap.innerHTML =
					'<button class="pag-btn" data-pag-dir="prev" data-pag-page="' + (data.currentPage - 1) + '"' + prevDis + '>&#8249;</button>'
					+ '<span class="pag-info">' + data.currentPage + ' / ' + data.lastPage + '</span>'
					+ '<button class="pag-btn" data-pag-dir="next" data-pag-page="' + (data.currentPage + 1) + '"' + nextDis + '>&#8250;</button>';
				pagWrap.style.display = '';
			} else {
				pagWrap.style.display = 'none';
			}

			const card = document.getElementById('blockedCard');
			if (scrollDir === 'next') {
				card.scrollIntoView({ behavior: 'smooth', block: 'start' });
			} else if (scrollDir === 'prev') {
				card.scrollIntoView({ behavior: 'smooth', block: 'end' });
			}
		}

		document.addEventListener('click', function (e) {
			const btn = e.target.closest('[data-pag-page]');
			if (btn && !btn.hasAttribute('disabled')) {
				e.preventDefault();
				loadBlockedPage(+btn.dataset.pagPage, btn.dataset.pagDir);
			}
		});
	</script>
</body>
</html>
