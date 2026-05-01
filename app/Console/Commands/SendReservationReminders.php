<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\ReservationReminderMail;
use App\Models\Reservation;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

final class SendReservationReminders extends Command
{
	protected $signature = 'reservations:remind';
	protected $description = 'Šalje podsetnik mejl sat vremena pre termina.';

	public function handle(): int
	{
		$tz  = 'Europe/Belgrade';
		$now = CarbonImmutable::now($tz);

		// Prozor: termini koji počinju između 55 i 65 minuta od sada
		$from = $now->addMinutes(55);
		$to   = $now->addMinutes(65);

		$reservations = Reservation::query()
			->where('reminder_sent', false)
			->where('reservation_date', $now->toDateString())
			->whereTime('start_time', '>=', $from->format('H:i:s'))
			->whereTime('start_time', '<=', $to->format('H:i:s'))
			->with(['court', 'timeSlot'])
			->get();

		$ownerEmail = config('mail.owner_address');
		$ownerEmailSecondary = config('mail.owner_address_secondary');

		foreach ($reservations as $reservation) {
			Mail::to($reservation->email)->send(new ReservationReminderMail($reservation));

			if (!empty($ownerEmail)) {
				Mail::to($ownerEmail)->send(new ReservationReminderMail($reservation));
			}

			if (!empty($ownerEmailSecondary)) {
				Mail::to($ownerEmailSecondary)->send(new ReservationReminderMail($reservation));
			}

			$reservation->update(['reminder_sent' => true]);
			$this->info("Podsetnik poslat: {$reservation->email} — {$reservation->reservation_date} {$reservation->start_time}");
		}

		if ($reservations->isEmpty()) {
			$this->line('Nema termina za podsetnik u ovom prozoru.');
		}

		return self::SUCCESS;
	}
}
