<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Reservation;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;

final class PruneOldReservations extends Command
{
	protected $signature = 'Izreservations:prune';
	protected $description = 'Briše rezervacije starije od 30 dana.';

	public function handle(): int
	{
		$cutoff = CarbonImmutable::now('Europe/Belgrade')->subDays(30)->toDateString();

		$deleted = Reservation::query()
			->where('reservation_date', '<', $cutoff)
			->delete();

		$this->info("Obrisano rezervacija: {$deleted} (starije od {$cutoff}).");

		return self::SUCCESS;
	}
}
