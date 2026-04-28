<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Reservation;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class ReservationService
{
	public const OPEN_TIME = '08:00';
	public const LAST_START_TIME = '23:00';
	private const STEP_MINUTES = 30;
	private const MAX_RESERVATION_MINUTES = 120;

	/** Cache of day occupancy grids for the current request. Key format: "courtId:Y-m-d" */
	private array $dayGridCache = [];

	public function getAvailableStartTimes(int $courtId, CarbonImmutable $date, int $durationMinutes): array
	{
		$openMin       = self::timeToMinutes(self::OPEN_TIME);
		$lastStartMin  = self::timeToMinutes(self::LAST_START_TIME);
		$step          = self::STEP_MINUTES;
		$need          = intdiv($durationMinutes, $step);
		$lastStartIdx  = intdiv($lastStartMin - $openMin, $step);

		$grid = $this->buildDayGrid($courtId, $date);

		$now = CarbonImmutable::now($date->timezone);
		$startIdx = 0;
		if ($date->isSameDay($now)) {
			$nowMin = $now->hour * 60 + $now->minute;
			$startIdx = max(0, (int) ceil(($nowMin - $openMin) / $step));
		}

		$out = [];
		$slots = count($grid);
		$maxStartIdx = min($slots - $need, $lastStartIdx);
		for ($i = $startIdx; $i <= $maxStartIdx; $i++) {
			$busy = false;
			for ($k = 0; $k < $need; $k++) {
				if ($grid[$i + $k]) { $busy = true; break; }
			}
			if (!$busy) {
				$m = $openMin + $i * $step;
				$out[] = self::minutesToTime($m);
			}
		}

		return $out;
	}

	public function hasConflict(int $courtId, CarbonImmutable $date, CarbonImmutable $start, int $durationMinutes): bool
	{
		$end = $start->addMinutes($durationMinutes);
		$existing = $this->getExistingIntervals($courtId, $date);
		return $this->overlapsAny($start, $end, $existing);
	}

	/** Fast existence check for any available window of a given duration */
	public function hasAnyWindow(int $courtId, CarbonImmutable $date, int $durationMinutes): bool
	{
		$openMin       = self::timeToMinutes(self::OPEN_TIME);
		$lastStartMin  = self::timeToMinutes(self::LAST_START_TIME);
		$step          = self::STEP_MINUTES;
		$need          = intdiv($durationMinutes, $step);
		$lastStartIdx  = intdiv($lastStartMin - $openMin, $step);
		$grid = $this->buildDayGrid($courtId, $date);

		$now = CarbonImmutable::now($date->timezone);
		$startIdx = 0;
		if ($date->isSameDay($now)) {
			$nowMin = $now->hour * 60 + $now->minute;
			$startIdx = max(0, (int) ceil(($nowMin - $openMin) / $step));
		}
		$maxStartIdx = min(count($grid) - $need, $lastStartIdx);
		for ($i = $startIdx; $i <= $maxStartIdx; $i++) {
			$ok = true;
			for ($k = 0; $k < $need; $k++) {
				if ($grid[$i + $k]) { $ok = false; break; }
			}
			if ($ok) return true;
		}
		return false;
	}

	/**
	 * Build a boolean occupancy grid (step = 30min) for a given court and date.
	 * false = free, true = busy
	 */
	private function buildDayGrid(int $courtId, CarbonImmutable $date): array
	{
		$key = $courtId . ':' . $date->toDateString();
		if (isset($this->dayGridCache[$key])) {
			return $this->dayGridCache[$key];
		}

		$openMin    = self::timeToMinutes(self::OPEN_TIME);
		$gridEndMin = self::timeToMinutes(self::LAST_START_TIME) + self::MAX_RESERVATION_MINUTES;
		$step       = self::STEP_MINUTES;
		$slots      = intdiv($gridEndMin - $openMin, $step);
		$grid       = array_fill(0, $slots, false);

		$rows = DB::table('reservations as r')
			->join('time_slots as ts', 'ts.id', '=', 'r.time_slot_id')
			->where('r.court_id', $courtId)
			->where('r.reservation_date', $date->toDateString())
			->get(['r.start_time', 'ts.duration_minutes']);

		foreach ($rows as $row) {
			$startMin = self::timeToMinutes((string) $row->start_time);
			$endMin   = $startMin + (int) $row->duration_minutes;
			for ($m = max($startMin, $openMin); $m < min($endMin, $gridEndMin); $m += $step) {
				$idx = intdiv($m - $openMin, $step);
				if ($idx >= 0 && $idx < $slots) {
					$grid[$idx] = true;
				}
			}
		}

		return $this->dayGridCache[$key] = $grid;
	}

	/** Utility: HH:MM -> minutes */
	private static function timeToMinutes(string $hhmm): int
	{
		[$h, $m] = array_map('intval', explode(':', substr($hhmm, 0, 5)));
		return $h * 60 + $m;
	}

	/** Utility: minutes -> HH:MM */
	private static function minutesToTime(int $minutes): string
	{
		$h = intdiv($minutes, 60);
		$m = $minutes % 60;
		return sprintf('%02d:%02d', $h, $m);
	}

	/**
	 * @return array<array{start: CarbonImmutable, end: CarbonImmutable}>
	 */
	private function getExistingIntervals(int $courtId, CarbonImmutable $date): array
	{
		$records = Reservation::query()
			->where('court_id', $courtId)
			->where('reservation_date', $date->toDateString())
			->with('timeSlot')
			->get();

		$intervals = [];
		foreach ($records as $reservation) {
			$startTime = CarbonImmutable::parse($date->toDateString() . ' ' . $reservation->start_time);
			$endTime = $startTime->addMinutes($reservation->timeSlot->duration_minutes);
			$intervals[] = ['start' => $startTime, 'end' => $endTime];
		}
		return $intervals;
	}

	/**
	 * @param array<array{start: CarbonImmutable, end: CarbonImmutable}> $intervals
	 */
	private function overlapsAny(CarbonImmutable $start, CarbonImmutable $end, array $intervals): bool
	{
		foreach ($intervals as $interval) {
			if ($interval['start'] < $end && $interval['end'] > $start) {
				return true;
			}
		}
		return false;
	}
} 