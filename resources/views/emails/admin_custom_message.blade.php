<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Poruka od Teniskog kluba Winner</title>
	<style>
		body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f8fafc; }
		.container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
		.header { background: linear-gradient(135deg, #D2691E, #CD853F); padding: 30px 24px; text-align: center; color: white; }
		.header h1 { margin: 0; font-size: 24px; font-weight: 600; }
		.header .tennis-icon { font-size: 36px; margin-bottom: 12px; }
		.content { padding: 24px; }
		.booking-details { background: #f7fafc; border-radius: 8px; padding: 16px 20px; margin: 0 0 20px 0; border-left: 4px solid #D2691E; }
		.booking-details h2 { margin: 0 0 10px 0; color: #D2691E; font-size: 16px; }
		.booking-details p { margin: 4px 0; color: #374151; font-size: 14px; }
		.message-box { background: #fff7ed; border: 1px solid #fed7aa; border-radius: 8px; padding: 20px; margin: 20px 0; }
		.message-box h3 { margin: 0 0 12px 0; color: #9a3412; font-size: 16px; }
		.message-body { color: #1f2937; font-size: 15px; line-height: 1.6; white-space: pre-wrap; word-wrap: break-word; }
		.footer { background: #374151; color: #d1d5db; padding: 20px 24px; text-align: center; font-size: 14px; }
		.footer a { color: #fbbf24; text-decoration: none; }
		@media (max-width: 600px) {
			.container { margin: 10px; }
			.header { padding: 20px 16px; }
			.content { padding: 16px; }
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="header">
			<div class="tennis-icon">🎾</div>
			<h1>Poruka od Teniskog kluba Winner</h1>
		</div>

		<div class="content">
			<p style="margin: 0 0 16px 0; color: #374151; font-size: 15px;">
				Poštovani/a <strong>{{ $reservation->first_name }} {{ $reservation->last_name }}</strong>,
			</p>
			<p style="margin: 0 0 20px 0; color: #374151; font-size: 15px; line-height: 1.6;">
				Šaljemo vam poruku vezanu za vašu rezervaciju:
			</p>

			<div class="booking-details">
				<h2>{{ $bookingName }}</h2>
				<p><strong>Teren:</strong> {{ $reservation->court->name }}@if($reservation->court->location) ({{ $reservation->court->location }})@endif</p>
				<p><strong>Datum:</strong> {{ $start->isoFormat('dddd, D. MMMM YYYY.') }}</p>
				<p><strong>Vreme:</strong> {{ $start->format('H:i') }} – {{ $end->format('H:i') }}</p>
			</div>

			<div class="message-box">
				<h3>Poruka:</h3>
				<div class="message-body">{{ $messageBody }}</div>
			</div>

			<p style="margin: 24px 0 0 0; color: #475569; font-size: 14px; line-height: 1.6;">
				Za bilo kakva dodatna pitanja, slobodno nas pozovite na
				<a href="tel:{{ $contactPhone ?? '+381 64 267 15 18' }}" style="color: #D2691E; font-weight: 600; text-decoration: none;">{{ $contactPhone ?? '+381 64 267 15 18' }}</a>.
			</p>
		</div>

		<div class="footer">
			<p style="margin: 0;">Srdačan pozdrav,<br>Teniski klub Winner — Smederevska Palanka</p>
			<p style="margin: 8px 0 0 0; font-size: 12px; color: #9ca3af;">
				Ova poruka je poslata od strane administratora kluba u vezi sa vašom rezervacijom.
			</p>
		</div>
	</div>
</body>
</html>
