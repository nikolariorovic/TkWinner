<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

final class Reservation extends Model
{
	use HasFactory;

	public const CANCELLATION_CUTOFF_MINUTES = 360; // 6 sati
	public const CONTACT_PHONE = '+381 64 267 15 18';

	public $timestamps = false;

	protected $fillable = [
		'court_id',
		'reservation_date',
		'start_time',
		'time_slot_id',
		'first_name',
		'last_name',
		'email',
		'phone',
		'cancellation_token',
		'reminder_sent',
	];

	protected $casts = [
		'reservation_date' => 'date',
		'start_time'       => 'string',
		'reminder_sent'    => 'boolean',
	];

	protected static function booted(): void
	{
		static::creating(function (Reservation $reservation): void {
			if (empty($reservation->cancellation_token)) {
				$reservation->cancellation_token = self::generateUniqueToken();
			}
		});
	}

	public static function generateUniqueToken(): string
	{
		do {
			$token = Str::random(64);
		} while (self::query()->where('cancellation_token', $token)->exists());
		return $token;
	}

	public function court(): BelongsTo
	{
		return $this->belongsTo(Court::class);
	}

	public function timeSlot(): BelongsTo
	{
		return $this->belongsTo(TimeSlot::class);
	}

	public function startAt(): CarbonImmutable
	{
		$dateStr = method_exists($this->reservation_date, 'toDateString')
			? $this->reservation_date->toDateString()
			: (string) $this->reservation_date;
		return CarbonImmutable::createFromFormat('Y-m-d H:i:s', $dateStr . ' ' . $this->start_time, 'Europe/Belgrade');
	}

	public function minutesUntilStart(): int
	{
		return (int) CarbonImmutable::now('Europe/Belgrade')->diffInMinutes($this->startAt(), false);
	}

	public function isCancellable(): bool
	{
		return $this->minutesUntilStart() >= self::CANCELLATION_CUTOFF_MINUTES;
	}

	public function cancelUrl(): string
	{
		return route('reservations.cancel.show', ['token' => $this->cancellation_token]);
	}
}
