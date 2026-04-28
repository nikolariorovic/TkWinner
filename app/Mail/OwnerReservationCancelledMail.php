<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

final class OwnerReservationCancelledMail extends Mailable implements ShouldQueue
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
		$subject = sprintf(
			'[tK Winner] %s — %s %s (%s %s)',
			$byAdmin ? 'Admin otkazao termin' : 'Otkazivanje',
			$this->data['firstName'] ?? '',
			$this->data['lastName'] ?? '',
			$this->data['date'] ?? '',
			$this->data['startTime'] ?? ''
		);

		return $this
			->subject($subject)
			->from(config('mail.from.address'), config('mail.from.name'))
			->view('emails.reservation_cancelled_owner', $this->data);
	}
}
