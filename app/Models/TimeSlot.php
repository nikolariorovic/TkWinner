<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class TimeSlot extends Model
{
	use HasFactory;

	public $timestamps = false;

	protected $fillable = [
		'duration_minutes',
		'label',
	];

	public function reservations(): HasMany
	{
		return $this->hasMany(Reservation::class);
	}
} 