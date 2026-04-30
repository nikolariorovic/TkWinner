<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Mail\OwnerReservationCancelledMail;
use App\Mail\ReservationCancelledMail;
use App\Mail\ReservationConfirmedMail;
use App\Models\BlockedCustomer;
use App\Models\Court;
use App\Models\Reservation;
use App\Models\TimeSlot;
use App\Services\ReservationService;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

final class ReservationController extends Controller
{
	public function __construct(private readonly ReservationService $service)
	{
	}

	public function index(): View
	{
		return view('welcome', [
			'courts'    => Court::query()->where('is_active', true)->orderBy('name')->get(),
			'timeSlots' => TimeSlot::query()->orderBy('duration_minutes')->get(),
		]);
	}

	public function availability(Request $request): JsonResponse
	{
		$validated = $request->validate([
			'court_id' => ['required', 'integer', Rule::exists('courts', 'id')->where('is_active', true)],
			'date' => ['required', 'date', 'after_or_equal:today'],
			'duration_minutes' => ['required', 'integer', 'in:60,90,120'],
		]);

		$date = CarbonImmutable::parse($validated['date'])->startOfDay();
		$times = $this->service->getAvailableStartTimes((int) $validated['court_id'], $date, (int) $validated['duration_minutes']);

		return response()->json(['available' => $times]);
	}

	public function dayAvailability(Request $request): JsonResponse
	{
		$validated = $request->validate([
			'court_id' => ['required', 'integer', Rule::exists('courts', 'id')->where('is_active', true)],
			'date' => ['required', 'date', 'after_or_equal:today'],
		]);

		$date = CarbonImmutable::parse($validated['date'])->startOfDay();
		$durations = TimeSlot::query()->pluck('duration_minutes');
		$has = false;
		foreach ($durations as $duration) {
			$times = $this->service->getAvailableStartTimes((int) $validated['court_id'], $date, (int) $duration);
			if (!empty($times)) {
				$has = true;
				break;
			}
		}
		return response()->json(['hasAvailability' => $has]);
	}

	public function monthAvailability(Request $request): JsonResponse
	{
		$validated = $request->validate([
			'court_id' => ['required', 'integer', Rule::exists('courts', 'id')->where('is_active', true)],
			'year' => ['required', 'integer', 'min:1970', 'max:2100'],
			'month' => ['required', 'integer', 'min:1', 'max:12'],
		]);

		$year = (int) $validated['year'];
		$month = (int) $validated['month'];
		$start = CarbonImmutable::create($year, $month, 1)->startOfDay();
		$end = $start->endOfMonth();
		$durations = TimeSlot::query()->pluck('duration_minutes');
		$disabled = [];

		for ($d = $start; $d->lte($end); $d = $d->addDay()) {
			$has = false;
			foreach ($durations as $duration) {
				$times = $this->service->getAvailableStartTimes((int) $validated['court_id'], $d, (int) $duration);
				if (!empty($times)) { $has = true; break; }
			}
			if (!$has) {
				$disabled[] = $d->toDateString();
			}
		}

		return response()->json(['disabledDates' => $disabled]);
	}

	public function availableDurations(Request $request): JsonResponse
	{
		$validated = $request->validate([
			'court_id' => ['required', 'integer', Rule::exists('courts', 'id')->where('is_active', true)],
			'date' => ['required', 'date', 'after_or_equal:today'],
		]);

		$date = CarbonImmutable::parse($validated['date'])->startOfDay();
		$timeSlots = TimeSlot::query()->orderBy('duration_minutes')->get();
		$available = [];

		foreach ($timeSlots as $slot) {
			$times = $this->service->getAvailableStartTimes((int) $validated['court_id'], $date, (int) $slot->duration_minutes);
			if (!empty($times)) {
				$available[] = [
					'id' => $slot->id,
					'duration_minutes' => $slot->duration_minutes,
					'label' => $slot->label,
				];
			}
		}

		return response()->json(['availableDurations' => $available]);
	}

	public function store(StoreReservationRequest $request): RedirectResponse|JsonResponse
	{
		$data = $request->validated();

		$slot = TimeSlot::query()->findOrFail((int) $data['time_slot_id']);
		$date = CarbonImmutable::parse($data['date'])->startOfDay();
		$start = CarbonImmutable::parse($data['date'] . ' ' . $data['start_time']);

		$now = CarbonImmutable::now($date->timezone);
		$open = $date->setTimeFromTimeString(ReservationService::OPEN_TIME);
		$lastStart = $date->setTimeFromTimeString(ReservationService::LAST_START_TIME);

		$error = null;
		if (BlockedCustomer::isBlocked($data['email'], $data['phone'])) {
			$error = 'Vaš nalog je blokiran za online rezervacije. Molimo kontaktirajte klub.';
		} elseif ($date->isSameDay($now) && $start <= $now) {
			$error = 'Ne možete rezervisati termin u prošlosti.';
		} elseif ($start < $open || $start > $lastStart) {
			$error = 'Termin mora biti unutar radnog vremena.';
		} elseif ($this->service->hasConflict((int) $data['court_id'], $date, $start, (int) $slot->duration_minutes)) {
			$error = 'Termin je zauzet. Izaberite drugi.';
		}

		if ($error !== null) {
			if ($request->expectsJson()) {
				return response()->json(['message' => $error, 'errors' => ['start_time' => [$error]]], 422);
			}
			return back()->withErrors(['start_time' => $error])->withInput();
		}

		$reservation = Reservation::query()->create([
			'court_id' => (int) $data['court_id'],
			'reservation_date' => $date->toDateString(),
			'start_time' => $start->format('H:i:s'),
			'time_slot_id' => (int) $data['time_slot_id'],
			'first_name' => $data['first_name'],
			'last_name' => $data['last_name'],
			'email' => $data['email'],
			'phone' => $data['phone'],
		]);

		Mail::to($reservation->email)->send(new ReservationConfirmedMail($reservation));

		$ownerEmail = config('mail.owner_address');
		if (!empty($ownerEmail)) {
			Mail::to($ownerEmail)->send(new ReservationConfirmedMail($reservation, forOwner: true));
		}

		$ownerEmailSecondary = config('mail.owner_address_secondary');
		if (!empty($ownerEmailSecondary)) {
			Mail::to($ownerEmailSecondary)->send(new ReservationConfirmedMail($reservation, forOwner: true));
		}


		if ($request->expectsJson()) {
			return response()->json(['message' => 'Uspešno ste rezervisali termin.']);
		}
		return redirect()->route('reservations.index')->with('success', 'Uspešno ste rezervisali termin.');
	}

	public function showCancel(string $token): View
	{
		$reservation = Reservation::query()
			->with(['court', 'timeSlot'])
			->where('cancellation_token', $token)
			->first();

		if ($reservation === null) {
			return view('cancel', [
				'reservation' => null,
				'status' => 'not_found',
				'contactPhone' => Reservation::CONTACT_PHONE,
			]);
		}

		return view('cancel', [
			'reservation' => $reservation,
			'status' => $reservation->isCancellable() ? 'cancellable' : 'too_late',
			'contactPhone' => Reservation::CONTACT_PHONE,
		]);
	}

	public function cancel(string $token): View
	{
		$reservation = Reservation::query()
			->with(['court', 'timeSlot'])
			->where('cancellation_token', $token)
			->first();

		if ($reservation === null) {
			return view('cancel', [
				'reservation' => null,
				'status' => 'not_found',
				'contactPhone' => Reservation::CONTACT_PHONE,
			]);
		}

		if (!$reservation->isCancellable()) {
			return view('cancel', [
				'reservation' => $reservation,
				'status' => 'too_late',
				'contactPhone' => Reservation::CONTACT_PHONE,
			]);
		}

		$snapshot = $reservation->replicate();
		$snapshot->setRelations($reservation->getRelations());
		$reservation->delete();

		$start = $snapshot->startAt();
		$end = $start->addMinutes((int) $snapshot->timeSlot->duration_minutes);
		$durationLabel = $snapshot->timeSlot->label;
		$bookingName = sprintf('Termin %s - %s', $durationLabel, strtoupper($snapshot->court->name));

		$mailData = [
			'bookingName' => $bookingName,
			'courtName' => $snapshot->court->name,
			'courtLocation' => (string) $snapshot->court->location,
			'date' => $start->locale('sr')->isoFormat('dddd, D. MMMM YYYY.'),
			'startTime' => $start->format('H:i'),
			'endTime' => $end->format('H:i'),
			'durationLabel' => $durationLabel,
			'firstName' => $snapshot->first_name,
			'lastName' => $snapshot->last_name,
			'userEmail' => $snapshot->email,
			'userPhone' => $snapshot->phone,
			'cancelledAt' => CarbonImmutable::now('Europe/Belgrade')->locale('sr')->isoFormat('dddd, D. MMMM YYYY. [u] HH:mm'),
			'contactPhone' => Reservation::CONTACT_PHONE,
			'siteUrl' => route('reservations.index'),
		];

		Mail::to($snapshot->email)
			->send(new ReservationCancelledMail($mailData));

		$ownerEmail = config('mail.owner_address');
		if (!empty($ownerEmail)) {
			Mail::to($ownerEmail)->send(new OwnerReservationCancelledMail($mailData));
		}

		$ownerEmailSecondary = config('mail.owner_address_secondary');
		if (!empty($ownerEmailSecondary)) {
			Mail::to($ownerEmailSecondary)->send(new OwnerReservationCancelledMail($mailData));
		}

		return view('cancel', [
			'reservation' => $snapshot,
			'status' => 'cancelled',
			'contactPhone' => Reservation::CONTACT_PHONE,
		]);
	}
} 