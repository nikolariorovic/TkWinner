<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

final class ReservationCancelledMail extends Mailable implements ShouldQueue
{
	use Queueable;

	public $tries = 3;
	public $backoff = [10, 30, 60];

	/**
	 * @param array<string,mixed> $data  Scalar payload (model is already deleted, so we can't use SerializesModels).
	 */
	public function __construct(private readonly array $data)
	{
	}

	public function build(): self
	{
		$byAdmin = (bool) ($this->data['cancelledByAdmin'] ?? false);
		$subject = ($byAdmin ? 'Vaš termin je otkazan — ' : 'Otkazana rezervacija — ')
			. ($this->data['bookingName'] ?? 'termin');

		return $this
			->subject($subject)
			->from(config('mail.from.address'), config('mail.from.name'))
			->view('emails.reservation_cancelled', $this->data);
	}
}
