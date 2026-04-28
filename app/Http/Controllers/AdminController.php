<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\AdminCustomMessageMail;
use App\Mail\OwnerReservationCancelledMail;
use App\Mail\ReservationCancelledMail;
use App\Models\BlockedCustomer;
use App\Models\Court;
use App\Models\Reservation;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

final class AdminController extends Controller
{
	public function showLogin(): View|RedirectResponse
	{
		if (Auth::check()) {
			return redirect()->route('admin.dashboard');
		}
		return view('admin.login');
	}

	public function login(Request $request): RedirectResponse
	{
		$credentials = $request->validate([
			'email' => ['required', 'email'],
			'password' => ['required', 'string'],
		]);

		if (!Auth::attempt($credentials, (bool) $request->boolean('remember'))) {
			throw ValidationException::withMessages([
				'email' => 'Neispravan email ili lozinka.',
			]);
		}

		$request->session()->regenerate();
		return redirect()->intended(route('admin.dashboard'));
	}

	public function logout(Request $request): RedirectResponse
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect()->route('admin.login.show');
	}

	public function dashboard(Request $request): View|JsonResponse
	{
		$validated = $request->validate([
			'date' => ['nullable', 'date'],
			'page' => ['nullable', 'integer', 'min:1'],
		]);

		$tz = 'Europe/Belgrade';
		$now = CarbonImmutable::now($tz);
		$date = isset($validated['date'])
			? CarbonImmutable::parse($validated['date'], $tz)->startOfDay()
			: $now->startOfDay();

		$page = (int) ($validated['page'] ?? 1);

		$reservations = Reservation::query()
			->with(['court', 'timeSlot'])
			->where('reservation_date', $date->toDateString())
			->orderBy('start_time')
			->orderBy('court_id')
			->paginate(15, ['*'], 'page', $page);

		if ($request->expectsJson()) {
			return response()->json([
				'date' => $date->toDateString(),
				'dateFormatted' => $date->locale('sr')->isoFormat('dddd, D. MMMM YYYY.'),
				'prevDate' => $date->subDay()->toDateString(),
				'nextDate' => $date->addDay()->toDateString(),
				'isToday' => $date->isSameDay($now),
				'total' => $reservations->total(),
				'currentPage' => $reservations->currentPage(),
				'lastPage' => $reservations->lastPage(),
				'reservations' => $reservations->map(function (Reservation $r) use ($now): array {
					$start = $r->startAt();
					$end = $start->addMinutes((int) $r->timeSlot->duration_minutes);
					return [
						'id' => $r->id,
						'startTime' => $start->format('H:i'),
						'endTime' => $end->format('H:i'),
						'durationLabel' => $r->timeSlot->label,
						'courtName' => $r->court->name,
						'courtLocation' => $r->court->location,
						'firstName' => $r->first_name,
						'lastName' => $r->last_name,
						'phone' => $r->phone,
						'email' => $r->email,
						'isFuture' => $start->greaterThan($now),
						'cancelUrl' => route('admin.reservations.cancel', ['reservation' => $r->id]),
						'messageUrl' => route('admin.reservations.message', ['reservation' => $r->id]),
					];
				}),
			]);
		}

		return view('admin.dashboard', [
			'date' => $date,
			'prevDate' => $date->subDay(),
			'nextDate' => $date->addDay(),
			'today' => $now->startOfDay(),
			'reservations' => $reservations,
			'reservationsTotal' => $reservations->total(),
			'now' => $now,
		]);
	}

	public function cancel(Request $request, Reservation $reservation): RedirectResponse
	{
		$reservation->loadMissing(['court', 'timeSlot']);

		$start = $reservation->startAt();
		$now = CarbonImmutable::now($start->timezone);

		if ($start->lessThanOrEqualTo($now)) {
			return redirect()
				->route('admin.dashboard', ['date' => $reservation->reservation_date->toDateString()])
				->with('error', 'Termin je već prošao ili je u toku — ne može se otkazati.');
		}

		$snapshot = $reservation->replicate();
		$snapshot->setRelations($reservation->getRelations());
		$dateStr = $reservation->reservation_date->toDateString();
		$reservation->delete();

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
			'cancelledByAdmin' => true,
		];

		Mail::to($snapshot->email)
			->send(new ReservationCancelledMail($mailData));

		$ownerEmail = config('mail.owner_address');
		if (!empty($ownerEmail)) {
			Mail::to($ownerEmail)->send(new OwnerReservationCancelledMail($mailData));
		}

		return redirect()
			->route('admin.dashboard', ['date' => $dateStr])
			->with('success', sprintf(
				'Termin otkazan: %s %s — %s %s (%s).',
				$snapshot->first_name,
				$snapshot->last_name,
				$start->format('d.m.Y'),
				$start->format('H:i'),
				$snapshot->court->name,
			));
	}

	public function sendMessage(Request $request, Reservation $reservation): JsonResponse
	{
		$validated = $request->validate([
			'message' => ['required', 'string', 'min:3', 'max:2000'],
		]);

		Mail::to($reservation->email)->send(new AdminCustomMessageMail($reservation, $validated['message']));

		return response()->json(['message' => 'Poruka je poslata.']);
	}

	public function blockedIndex(Request $request): View|JsonResponse
	{
		$validated = $request->validate([
			'page' => ['nullable', 'integer', 'min:1'],
		]);

		$page    = (int) ($validated['page'] ?? 1);
		$blocked = BlockedCustomer::query()->orderByDesc('created_at')->paginate(20, ['*'], 'page', $page);

		if ($request->expectsJson()) {
			return response()->json([
				'total'       => $blocked->total(),
				'currentPage' => $blocked->currentPage(),
				'lastPage'    => $blocked->lastPage(),
				'items'       => $blocked->map(fn (BlockedCustomer $b) => [
					'id'         => $b->id,
					'email'      => $b->email,
					'phone_raw'  => $b->phone_raw,
					'reason'     => $b->reason,
					'created_at' => $b->created_at?->locale('sr')->isoFormat('D.MM.YYYY.'),
					'unblockUrl' => route('admin.blocked.unblock', ['blocked' => $b->id]),
				])->values(),
			]);
		}

		return view('admin.blocked', ['blocked' => $blocked]);
	}

	public function blockedStore(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'email'  => ['required', 'email', 'max:150'],
			'phone'  => ['required', 'string', 'max:50', 'regex:/^\\+?[0-9\\s\\-()]{7,20}$/'],
			'reason' => ['nullable', 'string', 'max:500'],
		], [
			'phone.regex' => 'Telefon mora biti u formatu npr. +381 64 123 4567 ili 064-123-4567.',
		]);

		$email = BlockedCustomer::normalizeEmail($validated['email']);
		$phoneNormalized = BlockedCustomer::normalizePhone($validated['phone']);

		$exists = BlockedCustomer::query()
			->where('email', $email)
			->where('phone_normalized', $phoneNormalized)
			->exists();

		if ($exists) {
			return back()->with('error', 'Ovaj korisnik je već blokiran.')->withInput();
		}

		BlockedCustomer::query()->create([
			'email'            => $email,
			'phone_normalized' => $phoneNormalized,
			'phone_raw'        => $validated['phone'],
			'reason'           => $validated['reason'] ?? null,
			'blocked_by'       => Auth::id(),
		]);

		return redirect()->route('admin.blocked.index')->with('success', 'Korisnik je blokiran.');
	}

	public function unblock(BlockedCustomer $blocked): RedirectResponse
	{
		$blocked->delete();
		return redirect()->route('admin.blocked.index')->with('success', 'Korisnik je odblokiran.');
	}

	public function courtsIndex(): View
	{
		$courts = Court::query()->orderBy('name')->get();
		return view('admin.courts', ['courts' => $courts]);
	}

	public function toggleCourt(Court $court): RedirectResponse
	{
		$court->update(['is_active' => !$court->is_active]);
		$status = $court->is_active ? 'aktiviran' : 'deaktiviran';
		return redirect()->route('admin.courts.index')->with('success', "Teren \"{$court->name}\" je {$status}.");
	}
}
