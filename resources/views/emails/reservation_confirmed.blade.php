<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $bookingName }}</title>
	<style>
		body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f8fafc; }
		.container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
		.header { background: linear-gradient(135deg, #D2691E, #CD853F); padding: 30px 24px; text-align: center; color: white; }
		.header h1 { margin: 0; font-size: 24px; font-weight: 600; }
		.header .tennis-icon { font-size: 36px; margin-bottom: 12px; }
		.content { padding: 24px; }
		.booking-details { background: #f7fafc; border-radius: 8px; padding: 20px; margin: 20px 0; border-left: 4px solid #D2691E; }
		.detail-row { display: flex; margin-bottom: 12px; align-items: flex-start; }
		.detail-label { font-weight: 600; color: #374151; min-width: 100px; margin-right: 12px; }
		.detail-value { color: #1f2937; flex: 1; }
		.info-section { background: #f0f9ff; border-radius: 8px; padding: 16px; margin: 20px 0; }
		.footer { background: #374151; color: #d1d5db; padding: 20px 24px; text-align: center; font-size: 14px; }
		.guests-table { width: 100%; border-collapse: collapse; margin-top: 12px; }
		.guests-table th, .guests-table td { padding: 8px 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
		.guests-table th { background: #f9fafb; font-weight: 600; color: #374151; }
		@media (max-width: 600px) {
			.container { margin: 10px; }
			.header { padding: 20px 16px; }
			.content { padding: 16px; }
			.detail-row { flex-direction: column; }
			.detail-label { margin-bottom: 4px; }
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="header">
			<div class="tennis-icon">🎾</div>
			<h1>Potvrda rezervacije</h1>
		</div>
		
		<div class="content">
			<div class="booking-details">
				<h2 style="margin: 0 0 16px 0; color: #D2691E; font-size: 20px;">{{ $bookingName }}</h2>
				
				<div class="detail-row">
					<div class="detail-label">Teren:</div>
					<div class="detail-value">{{ $reservation->court->name }} ({{ $reservation->court->location }})</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">Datum:</div>
					<div class="detail-value">{{ $start->isoFormat('dddd, D. MMMM YYYY.') }}</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">Vreme:</div>
					<div class="detail-value">{{ $start->format('H:i') }} – {{ $end->format('H:i') }}</div>
				</div>
				
				<div class="detail-row">
					<div class="detail-label">Trajanje:</div>
					<div class="detail-value">{{ $reservation->timeSlot->label }}</div>
				</div>
			</div>
			
			@isset($cancelUrl)
				<div style="background: #fff7ed; border: 1px solid #fed7aa; border-radius: 8px; padding: 20px; margin: 20px 0; text-align: center;">
					<h3 style="margin: 0 0 8px 0; color: #9a3412; font-size: 16px;">Trebate da otkažete?</h3>
					<p style="margin: 0 0 16px 0; color: #7c2d12; font-size: 14px; line-height: 1.55;">
						Ako ne možete da dođete na termin, molimo vas da ga otkažete kako bi slot bio dostupan drugima.
					</p>
					<a href="{{ $cancelUrl }}" style="display: inline-block; background: linear-gradient(135deg, #D2691E, #CD853F); color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px;">
						Otkaži termin
					</a>
					<p style="margin: 14px 0 0 0; color: #9a3412; font-size: 12px;">
						Online otkazivanje je moguće do <strong>6 sati pre početka</strong> termina. Nakon toga, pozovite <strong>{{ $contactPhone ?? '+381 64 267 15 18' }}</strong>.
					</p>
				</div>
			@endisset

			<div class="info-section">
				<h3 style="margin: 0 0 12px 0; color: #0f172a;">O klubu</h3>
				<p style="margin: 0; color: #475569; line-height: 1.6;">
					Teniski klub Winner iz Smederevske Palanke je mesto gde se ljubav prema tenisu spaja sa željom za pobedom.
					Naši članovi, od najmlađih do najstarijih, uživaju u igri i druženju u prijatnom ambijentu.
					Nudimo treninge za sve uzraste i nivoe znanja, kao i organizaciju turnira i drugih teniskih događaja.
				</p>
				<p style="margin: 12px 0 0 0; color: #475569;">
					<strong>Kontakt telefon:</strong> {{ $contactPhone ?? '+381 64 267 15 18' }}
				</p>
			</div>
			
			<div style="margin-top: 24px;">
				<h3 style="margin: 0 0 12px 0; color: #0f172a;">Učesnici</h3>
				<table class="guests-table">
					<thead>
						<tr>
							<th>Ime</th>
							<th>Email</th>
							<th>Telefon</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Teniski Klub Winner SP</td>
							<td><a href="mailto:{{ config('mail.from.address') }}" style="color: #2563eb; text-decoration: none;">{{ config('mail.from.address') }}</a></td>
							<td><a href="tel:{{ $contactPhone ?? '+381 64 267 15 18' }}" style="color: #2563eb; text-decoration: none;">{{ $contactPhone ?? '+381 64 267 15 18' }}</a></td>
							<td><span style="color: #059669; font-weight: 600;">Organizator</span></td>
						</tr>
						<tr>
							<td>Jasmina Stevanović</td>
							<td><a href="mailto:jasminastevanovic73@gmail.com" style="color: #2563eb; text-decoration: none;">jasminastevanovic73@gmail.com</a></td>
							<td><a href="tel:+381642397433" style="color: #2563eb; text-decoration: none;">+381 64 239 74 33</a></td>
							<td><span style="color: #059669; font-weight: 600;">Kontakt</span></td>
						</tr>
						<tr>
							<td>{{ $reservation->first_name }} {{ $reservation->last_name }}</td>
							<td><a href="mailto:{{ $reservation->email }}" style="color: #2563eb; text-decoration: none;">{{ $reservation->email }}</a></td>
							<td><a href="tel:{{ $reservation->phone }}" style="color: #2563eb; text-decoration: none;">{{ $reservation->phone }}</a></td>
							<td><span style="color: #2563eb; font-weight: 600;">Rezervisao</span></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="footer">
			<p style="margin: 0;">Hvala vam što ste izabrali Teniski klub Winner!</p>
			<p style="margin: 8px 0 0 0; font-size: 12px; color: #9ca3af;">
				Ova poruka je automatski generisana iz sistema za rezervacije.
			</p>
		</div>
	</div>
</body>
</html> 