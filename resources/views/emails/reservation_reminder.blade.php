<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $bookingName }}</title>
	<style>
		body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f8fafc; }
		.container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
		.header { background: linear-gradient(135deg, #16a34a, #15803d); padding: 30px 24px; text-align: center; color: white; }
		.header h1 { margin: 0; font-size: 22px; font-weight: 600; }
		.header .icon { font-size: 40px; margin-bottom: 12px; }
		.content { padding: 28px 24px; }
		.alert-box { background: #f0fdf4; border: 2px solid #16a34a; border-radius: 10px; padding: 20px 24px; margin-bottom: 24px; text-align: center; }
		.alert-time { font-size: 36px; font-weight: 800; color: #15803d; letter-spacing: -.02em; line-height: 1; margin-bottom: 4px; }
		.alert-label { font-size: 14px; color: #166534; font-weight: 500; }
		.booking-details { background: #f7fafc; border-radius: 8px; padding: 20px; margin: 20px 0; border-left: 4px solid #D2691E; }
		.detail-row { display: flex; margin-bottom: 10px; align-items: flex-start; }
		.detail-label { font-weight: 600; color: #374151; min-width: 100px; margin-right: 12px; font-size: 14px; }
		.detail-value { color: #1f2937; flex: 1; font-size: 14px; }
		.footer { background: #374151; color: #d1d5db; padding: 20px 24px; text-align: center; font-size: 14px; }
		@media (max-width: 600px) {
			.container { margin: 10px; }
			.content { padding: 16px; }
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="header">
			<div class="icon">⏰</div>
			<h1>Podsetnik — termin za sat vremena</h1>
		</div>

		<div class="content">
			<p style="color:#374151; margin: 0 0 20px 0;">
				Poštovani/a <strong>{{ $reservation->first_name }}</strong>, podsetnik za vaš nadolazeći termin u Teniskom klubu Winner:
			</p>

			<div class="alert-box">
				<div class="alert-time">{{ $start->format('H:i') }} – {{ $end->format('H:i') }}</div>
				<div class="alert-label">{{ $start->locale('sr')->isoFormat('dddd, D. MMMM YYYY.') }}</div>
			</div>

			<div class="booking-details">
				<div class="detail-row">
					<div class="detail-label">Teren:</div>
					<div class="detail-value">{{ $reservation->court->name }} ({{ $reservation->court->location }})</div>
				</div>
				<div class="detail-row">
					<div class="detail-label">Trajanje:</div>
					<div class="detail-value">{{ $reservation->timeSlot->label }}</div>
				</div>
				<div class="detail-row">
					<div class="detail-label">Adresa:</div>
					<div class="detail-value">Nadežde Petrović 27, Smederevska Palanka</div>
				</div>
			</div>

			</div>

		<div class="footer">
			<p style="margin: 0;">Vidimo se na terenu — Teniski klub Winner</p>
			<p style="margin: 8px 0 0 0; font-size: 12px; color: #9ca3af;">
				Ova poruka je automatski generisana iz sistema za rezervacije.
			</p>
		</div>
	</div>
</body>
</html>
