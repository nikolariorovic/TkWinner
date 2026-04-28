<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Otkazivanje — {{ $firstName }} {{ $lastName }}</title>
	<style>
		body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f8fafc; }
		.container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
		.header { background: #1f2937; padding: 24px; color: #ffffff; }
		.header .tag { display: inline-block; background: #dc2626; color: #ffffff; font-size: 11px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; margin-bottom: 10px; }
		.header h1 { margin: 0; font-size: 20px; font-weight: 600; }
		.header p { margin: 6px 0 0 0; font-size: 13px; color: #9ca3af; }
		.content { padding: 24px; }
		.lead { font-size: 14px; color: #374151; line-height: 1.6; margin: 0 0 18px 0; }
		.section { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 18px 20px; margin: 14px 0; }
		.section h2 { margin: 0 0 12px 0; font-size: 14px; color: #0f172a; text-transform: uppercase; letter-spacing: .06em; font-weight: 700; }
		.row { display: flex; margin-bottom: 8px; font-size: 14px; align-items: flex-start; }
		.row:last-child { margin-bottom: 0; }
		.k { color: #6b7280; min-width: 130px; margin-right: 12px; font-weight: 500; }
		.v { color: #111827; flex: 1; font-weight: 500; }
		.v a { color: #374151; text-decoration: none; border-bottom: 1px dotted #9ca3af; }
		.v a:hover { color: #111827; }
		.slot-box { background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 14px 18px; margin: 18px 0; font-size: 13px; color: #991b1b; }
		.slot-box strong { color: #7f1d1d; }
		.footer { background: #f3f4f6; color: #6b7280; padding: 16px 24px; text-align: center; font-size: 12px; }
		.footer p { margin: 0; }
		@media (max-width: 600px) {
			.container { margin: 10px; }
			.content { padding: 16px; }
			.row { flex-direction: column; }
			.k { min-width: 0; margin-bottom: 2px; }
		}
	</style>
</head>
<body>
	@php $byAdmin = $cancelledByAdmin ?? false; @endphp
	<div class="container">
		<div class="header">
			<span class="tag">{{ $byAdmin ? 'Admin otkazivanje' : 'Otkazivanje' }}</span>
			<h1>
				@if ($byAdmin)
					Admin je otkazao termin klijenta {{ $firstName }} {{ $lastName }}
				@else
					{{ $firstName }} {{ $lastName }} je otkazao/la termin
				@endif
			</h1>
			<p>{{ $cancelledAt }}</p>
		</div>

		<div class="content">
			<p class="lead">
				@if ($byAdmin)
					Termin je otkazan kroz <strong>admin panel</strong>. Klijent je automatski obavešten e-mailom da je njegova rezervacija otkazana od strane uprave kluba. Slot je oslobođen i ponovo je dostupan za rezervaciju.
				@else
					Sledeća rezervacija je upravo otkazana preko sajta. Slot je automatski oslobođen i ponovo je dostupan drugim igračima.
				@endif
			</p>

			<div class="section">
				<h2>Otkazani termin</h2>
				<div class="row"><span class="k">Teren:</span><span class="v">{{ $courtName }} ({{ $courtLocation }})</span></div>
				<div class="row"><span class="k">Datum:</span><span class="v">{{ $date }}</span></div>
				<div class="row"><span class="k">Vreme:</span><span class="v">{{ $startTime }} – {{ $endTime }}</span></div>
				<div class="row"><span class="k">Trajanje:</span><span class="v">{{ $durationLabel }}</span></div>
			</div>

			<div class="section">
				<h2>Podaci o klijentu</h2>
				<div class="row"><span class="k">Ime i prezime:</span><span class="v">{{ $firstName }} {{ $lastName }}</span></div>
				<div class="row"><span class="k">Email:</span><span class="v"><a href="mailto:{{ $userEmail }}">{{ $userEmail }}</a></span></div>
				<div class="row"><span class="k">Telefon:</span><span class="v"><a href="tel:{{ preg_replace('/[^+0-9]/', '', $userPhone) }}">{{ $userPhone }}</a></span></div>
				<div class="row"><span class="k">Otkazano:</span><span class="v">{{ $cancelledAt }}</span></div>
			</div>

			<div class="slot-box">
				@if ($byAdmin)
					<strong>Otkazano preko admin panela.</strong> Klijent je obavešten e-mailom sa porukom da je uprava kluba otkazala rezervaciju. Slot je slobodan za novu rezervaciju.
				@else
					<strong>Slot je oslobođen.</strong> Ne treba ručna intervencija — termin je u sistemu označen kao slobodan i može odmah biti rezervisan od strane drugog igrača.
				@endif
			</div>
		</div>

		<div class="footer">
			<p>Automatska notifikacija · Teniski klub Winner · Sistem za rezervacije</p>
		</div>
	</div>
</body>
</html>
