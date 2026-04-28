<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Reservation;
use Carbon\CarbonImmutable;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class ReservationConfirmedMail extends Mailable implements ShouldQueue
{
	use Queueable, SerializesModels;

	public $tries = 3;
	public $backoff = [10, 30, 60];

	public function __construct(
		private readonly Reservation $reservation,
		private readonly bool $forOwner = false,
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
		$durationLabel = $reservation->timeSlot->label;
		$bookingName = sprintf('Termin %s - %s', $durationLabel, strtoupper($reservation->court->name));

		$viewData = [
			'reservation' => $reservation,
			'bookingName' => $bookingName,
			'durationLabel' => $durationLabel,
			'start' => $start,
			'end' => $end,
			'timezoneLabel' => 'Central European Time - Belgrade',
			'contactPhone' => Reservation::CONTACT_PHONE,
		];

		if (!$this->forOwner) {
			$viewData['cancelUrl'] = $reservation->cancelUrl();
		}

		return $this
			->subject($bookingName)
			->from(config('mail.from.address'), config('mail.from.name'))
			->view('emails.reservation_confirmed', $viewData);
	}
} 