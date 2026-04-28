<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Reservation;
use Carbon\CarbonImmutable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class AdminCustomMessageMail extends Mailable implements ShouldQueue
{
	use Queueable, SerializesModels;

	public $tries = 3;
	public $backoff = [10, 30, 60];

	public function __construct(
		private readonly Reservation $reservation,
		private readonly string $messageBody,
	) {
	}

	public function build(): self
	{
		$reservation = $this->reservation->loadMissing(['court', 'timeSlot']);
		$tz = 'Europe/Belgrade';
		$dateStr = method_exists($reservation->reservation_date, 'toDateString')
			? $reservation->reservation_date->toDateString()
			: (string) $reservation->reservation_date;
		$start = CarbonImmutable::createFromFormat('Y-m-d H:i:s', $dateStr . ' ' . $reservation->start_time, $tz);
		$end = $start->addMinutes((int) $reservation->timeSlot->duration_minutes);
		$bookingName = sprintf('Termin %s - %s', $reservation->timeSlot->label, strtoupper($reservation->court->name));

		return $this
			->subject('Poruka o vašoj rezervaciji — ' . $bookingName)
			->from(config('mail.from.address'), config('mail.from.name'))
			->view('emails.admin_custom_message', [
				'reservation' => $reservation,
				'bookingName' => $bookingName,
				'start' => $start,
				'end' => $end,
				'messageBody' => $this->messageBody,
				'contactPhone' => Reservation::CONTACT_PHONE,
			]);
	}
}
