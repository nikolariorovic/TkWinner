<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Admin prijava — Teniski klub Winner</title>

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
			--danger: #dc2626;
			--danger-soft: #fee2e2;
		}
		html, body { height: 100%; }
		body {
			font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
			color: var(--ink);
			background: linear-gradient(180deg, var(--brand-soft) 0%, var(--surface) 100%);
			line-height: 1.6;
			-webkit-font-smoothing: antialiased;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 24px;
		}
		.shell { width: 100%; max-width: 440px; }
		.brand-top { display: flex; align-items: center; gap: 12px; margin-bottom: 28px; justify-content: center; }
		.brand-mark { width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, var(--brand), var(--brand-2)); display: inline-flex; align-items: center; justify-content: center; color: #fff; font-size: 20px; box-shadow: 0 8px 18px rgba(234,88,12,.32); }
		.brand-text { font-weight: 800; letter-spacing: -.02em; font-size: 18px; color: var(--ink); }
		.brand-text small { display: block; font-size: 11px; font-weight: 500; color: var(--muted); letter-spacing: .08em; text-transform: uppercase; }
		.card { background: #fff; border-radius: 24px; box-shadow: 0 20px 50px -12px rgba(12,10,9,.16); padding: 36px; }
		h1 { font-size: 24px; font-weight: 800; letter-spacing: -.02em; color: var(--ink); line-height: 1.2; margin-bottom: 8px; text-align: center; }
		.sub { font-size: 14px; color: var(--muted); text-align: center; margin-bottom: 28px; }
		.field { margin-bottom: 18px; }
		label { display: block; font-size: 13px; font-weight: 600; color: var(--ink-2); margin-bottom: 8px; }
		input[type="email"], input[type="password"] {
			width: 100%;
			padding: 12px 14px;
			border: 1.5px solid var(--line);
			border-radius: 12px;
			font: inherit;
			font-size: 16px;
			color: var(--ink);
			background: #fff;
			transition: border-color .15s, box-shadow .15s;
		}
		input[type="email"]:focus, input[type="password"]:focus {
			outline: 0;
			border-color: var(--brand);
			box-shadow: 0 0 0 3px rgba(234,88,12,.15);
		}
		.remember { display: flex; align-items: center; gap: 8px; font-size: 14px; color: var(--ink-3); margin-bottom: 22px; }
		.remember input { width: 16px; height: 16px; accent-color: var(--brand); }
		.btn {
			width: 100%;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
			font-weight: 600;
			font-size: 15px;
			border-radius: 12px;
			padding: 14px 22px;
			cursor: pointer;
			transition: transform .2s, box-shadow .2s;
			text-decoration: none;
			border: 0;
			background: linear-gradient(135deg, var(--brand), var(--brand-2));
			color: #fff;
			box-shadow: 0 8px 20px rgba(234,88,12,.28);
		}
		.btn:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(234,88,12,.38); }
		.alert { background: var(--danger-soft); color: var(--danger); border-radius: 12px; padding: 12px 14px; font-size: 14px; margin-bottom: 18px; }
		.home-link { display: inline-flex; align-items: center; gap: 6px; font-size: 14px; margin-top: 22px; color: var(--muted); justify-content: center; width: 100%; }
		.home-link:hover { color: var(--brand); }
	</style>
</head>
<body>
	<div class="shell">
		<div class="brand-top">
            <img src="{{ asset('images/logo.svg') }}" alt="tK Winner Logo" style="height: 55px;">
		</div>

		<div class="card">
			<h1>Prijava</h1>
			<p class="sub">Prijavite se da pregledate i upravljate rezervacijama.</p>

			@if ($errors->any())
				<div class="alert">{{ $errors->first() }}</div>
			@elseif (session('error'))
				<div class="alert">{{ session('error') }}</div>
			@endif

			<form method="post" action="{{ route('admin.login') }}">
				@csrf
				<div class="field">
					<label for="email">Email</label>
					<input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
				</div>
				<div class="field">
					<label for="password">Lozinka</label>
					<input type="password" id="password" name="password" required>
				</div>
				<label class="remember">
					<input type="checkbox" name="remember" value="1">
					Zapamti me
				</label>
				<button type="submit" class="btn">Prijavi se</button>
			</form>
		</div>

		<a href="{{ route('reservations.index') }}" class="home-link">← Nazad na tkwinner.net</a>
	</div>
</body>
</html>
