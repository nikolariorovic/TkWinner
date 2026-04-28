<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $bookingName }} — Otkazano</title>
	<style>
		body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f8fafc; }
		.container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
		.header { background: linear-gradient(135deg, #dc2626, #b91c1c); padding: 30px 24px; text-align: center; color: white; }
		.header h1 { margin: 0; font-size: 24px; font-weight: 600; }
		.header .icon { font-size: 36px; margin-bottom: 12px; line-height: 1; }
		.header p { margin: 10px 0 0 0; font-size: 14px; opacity: .9; }
		.content { padding: 24px; }
		.lead { font-size: 15px; color: #374151; line-height: 1.6; margin: 0 0 20px 0; }
		.booking-details { background: #fef2f2; border-radius: 8px; padding: 20px; margin: 20px 0; border-left: 4px solid #dc2626; }
		.booking-details h2 { margin: 0 0 16px 0; color: #991b1b; font-size: 18px; }
		.detail-row { display: flex; margin-bottom: 12px; align-items: flex-start; }
		.detail-row:last-child { margin-bottom: 0; }
		.detail-label { font-weight: 600; color: #374151; min-width: 120px; margin-right: 12px; }
		.detail-value { color: #1f2937; flex: 1; }
		.canceller-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 18px 20px; margin: 20px 0; }
		.canceller-box h3 { margin: 0 0 10px 0; color: #0f172a; font-size: 15px; }
		.canceller-box .row { display: flex; margin-bottom: 6px; font-size: 14px; }
		.canceller-box .row:last-child { margin-bottom: 0; }
		.canceller-box .k { color: #6b7280; min-width: 100px; margin-right: 8px; }
		.canceller-box .v { color: #111827; font-weight: 500; }
		.cta { text-align: center; margin: 26px 0 10px; }
		.cta a { display: inline-block; background: linear-gradient(135deg, #D2691E, #CD853F); color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px; }
		.info { background: #f0f9ff; border-radius: 8px; padding: 16px 18px; margin-top: 20px; font-size: 13px; color: #0c4a6e; line-height: 1.55; }
		.footer { background: #374151; color: #d1d5db; padding: 20px 24px; text-align: center; font-size: 14px; }
		.footer p { margin: 0; }
		.footer .small { margin-top: 8px; font-size: 12px; color: #9ca3af; }
		@media (max-width: 600px) {
			.container { margin: 10px; }
			.header { padding: 20px 16px; }
			.content { padding: 16px; }
			.detail-row { flex-direction: column; }
			.detail-label { margin-bottom: 4px; min-width: 0; }
			.canceller-box .row { flex-direction: column; }
			.canceller-box .k { margin-bottom: 2px; }
		}
	</style>
</head>
<body>
	@php $byAdmin = $cancelledByAdmin ?? false; @endphp
	<div class="container">
		<div class="header">
			<div class="icon">✕</div>
			<h1>{{ $byAdmin ? 'Vaš termin je otkazan' : 'Rezervacija otkazana' }}</h1>
			<p>{{ $byAdmin ? 'Otkazao ga je administrator teniskog kluba Winner' : 'Termin je oslobođen i ponovo je dostupan za rezervaciju' }}</p>
		</div>

		<div class="content">
			<p class="lead">
				@if ($byAdmin)
					Poštovani {{ $firstName }}, obaveštavamo Vas da je <strong>administrator teniskog kluba Winner</strong> otkazao Vašu rezervaciju prikazanu u nastavku. Izvinjavamo se zbog neprijatnosti. Ako želite više informacija ili pomoć oko novog termina, slobodno nas pozovite na <strong>{{ $contactPhone }}</strong>.
				@else
					Obaveštavamo vas da je sledeća rezervacija uspešno otkazana preko sajta.
				@endif
			</p>

			<div class="booking-details">
				<h2>{{ $bookingName }}</h2>

				<div class="detail-row">
					<div class="detail-label">Teren:</div>
					<div class="detail-value">{{ $courtName }} ({{ $courtLocation }})</div>
				</div>

				<div class="detail-row">
					<div class="detail-label">Datum:</div>
					<div class="detail-value">{{ $date }}</div>
				</div>

				<div class="detail-row">
					<div class="detail-label">Vreme:</div>
					<div class="detail-value">{{ $startTime }} – {{ $endTime }}</div>
				</div>

				<div class="detail-row">
					<div class="detail-label">Trajanje:</div>
					<div class="detail-value">{{ $durationLabel }}</div>
				</div>
			</div>

			<div class="canceller-box">
				<h3>{{ $byAdmin ? 'Detalji otkazivanja' : 'Ko je otkazao' }}</h3>
				@if ($byAdmin)
					<div class="row"><span class="k">Otkazao:</span><span class="v">Administrator kluba</span></div>
					<div class="row"><span class="k">Kontakt kluba:</span><span class="v">{{ $contactPhone }}</span></div>
					<div class="row"><span class="k">Otkazano:</span><span class="v">{{ $cancelledAt }}</span></div>
				@else
					<div class="row"><span class="k">Ime i prezime:</span><span class="v">{{ $firstName }} {{ $lastName }}</span></div>
					<div class="row"><span class="k">Email:</span><span class="v">{{ $userEmail }}</span></div>
					<div class="row"><span class="k">Telefon:</span><span class="v">{{ $userPhone }}</span></div>
					<div class="row"><span class="k">Otkazano:</span><span class="v">{{ $cancelledAt }}</span></div>
				@endif
			</div>

			<div class="cta">
				<a href="{{ $siteUrl }}">Rezerviši novi termin</a>
			</div>

			<div class="info">
				@if ($byAdmin)
					<strong>Napomena:</strong> Slot je oslobođen i možete odmah rezervisati drugi termin preko sajta.
					Za bilo kakva pitanja u vezi sa otkazivanjem, pozovite <strong>{{ $contactPhone }}</strong>.
				@else
					<strong>Napomena:</strong> Slot je automatski oslobođen i odmah je dostupan drugim igračima.
					Ako imate pitanja, pozovite <strong>{{ $contactPhone }}</strong>.
				@endif
			</div>
		</div>

		<div class="footer">
			<p>Teniski klub Winner · Smederevska Palanka</p>
			<p class="small">Ova poruka je automatski generisana iz sistema za rezervacije.</p>
		</div>
	</div>
</body>
</html>
