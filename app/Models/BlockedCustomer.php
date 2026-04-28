<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class BlockedCustomer extends Model
{
	protected $fillable = [
		'email',
		'phone_normalized',
		'phone_raw',
		'reason',
		'blocked_by',
	];

	public static function normalizeEmail(?string $email): ?string
	{
		if ($email === null) return null;
		$trimmed = trim($email);
		return $trimmed === '' ? null : strtolower($trimmed);
	}

	/**
	 * Normalizuje srpski broj telefona u E.164 format (+381...).
	 * Svi inputi koji predstavljaju isti broj vraćaju istu normalizovanu vrednost,
	 * tako da se ne može zaobići blokada menjanjem formata (+381 vs 0 prefix, razmaci, crtice...).
	 */
	public static function normalizePhone(?string $phone): ?string
	{
		if ($phone === null) return null;
		$digits = preg_replace('/\D+/', '', $phone);
		if ($digits === '' || $digits === null) return null;

		if (str_starts_with($digits, '00381')) {
			$digits = substr($digits, 2); // 00381... -> 381...
		}
		if (str_starts_with($digits, '381')) {
			return '+' . $digits;
		}
		if (str_starts_with($digits, '0')) {
			return '+381' . substr($digits, 1); // 0XX... -> +381XX...
		}
		return '+381' . $digits;
	}

	public static function isBlocked(?string $email, ?string $phone): bool
	{
		$normEmail = self::normalizeEmail($email);
		$normPhone = self::normalizePhone($phone);

		if ($normEmail === null && $normPhone === null) return false;

		return self::query()
			->when($normEmail !== null, fn ($q) => $q->orWhere('email', $normEmail))
			->when($normPhone !== null, fn ($q) => $q->orWhere('phone_normalized', $normPhone))
			->exists();
	}
}
