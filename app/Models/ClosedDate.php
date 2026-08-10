<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Datum kada klub ne radi (odmor, praznik, radovi na terenima...).
 * Za takve datume front ne nudi nijedan slobodan termin.
 */
final class ClosedDate extends Model
{
	protected $fillable = [
		'date',
		'reason',
		'closed_by',
	];

	protected $casts = [
		'date' => 'date',
	];

	public static function isClosed(CarbonInterface|string $date): bool
	{
		$value = $date instanceof CarbonInterface ? $date->toDateString() : substr($date, 0, 10);

		return self::query()->whereDate('date', $value)->exists();
	}
}
