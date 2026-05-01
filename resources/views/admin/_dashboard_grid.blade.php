@php
	$step = 30;
	$openMin = 8 * 60;
	$resById = collect($reservations)->keyBy('id');
	$tz = 'Europe/Belgrade';
	$nowMoment = \Carbon\CarbonImmutable::now($tz);
@endphp

@if ($courts->isEmpty())
	<div class="empty">
		<div class="empty-icon">
			<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
		</div>
		<p>Nema aktivnih terena. Aktivirajte teren u sekciji „Tereni“.</p>
	</div>
@else
	<div class="grid-scroll">
		<table class="grid-table {{ $courts->count() > 1 ? 'grid-multi' : '' }}">
			<thead>
				<tr>
					<th class="col-time">Vreme</th>
					@foreach ($courts as $court)
						<th>
							<div class="court-name">{{ $court->name }}</div>
							@if ($court->location)
								<div class="court-loc">{{ $court->location }}</div>
							@endif
						</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach ($hours as $i => $hourLabel)
					@php
						$slotMin = $openMin + $i * $step;
						$isHourRow = ($slotMin % 60 === 0);
						$isPast = $pastDay || ($nowMinutes !== null && $nowMinutes >= $slotMin);
						$rowClasses = trim(($isHourRow ? 'hour-row ' : '') . ($isPast ? 'row-past' : ''));
					@endphp
					<tr @if($rowClasses !== '') class="{{ $rowClasses }}" @endif>
						<td class="cell-time">{{ $hourLabel }}</td>
						@foreach ($courts as $court)
							@php
								$cell = $grid[$court->id][$i] ?? ['type' => 'empty'];
							@endphp
							@if ($cell['type'] === 'skip')
								{{-- spanned by reservation above --}}
							@elseif ($cell['type'] === 'reservation')
								@php
									$r = $resById->get($cell['reservationId']);
									$start = $r ? $r->startAt() : null;
									$end = $r ? $start->addMinutes((int) $r->timeSlot->duration_minutes) : null;
									$isPastReservation = $r ? ($pastDay || !$start->greaterThan($nowMoment)) : false;
								@endphp
								<td class="cell-reservation" rowspan="{{ $cell['rowspan'] }}">
									@if ($r)
										<button type="button" class="res-card{{ $isPastReservation ? ' is-past' : '' }}" data-reservation-id="{{ $r->id }}">
											<div class="res-name">{{ $r->first_name }} {{ $r->last_name }}</div>
											<div class="res-time">{{ $start->format('H:i') }} – {{ $end->format('H:i') }}</div>
										</button>
									@else
										<div class="cell-empty-inner">—</div>
									@endif
								</td>
							@elseif ($cell['type'] === 'unavailable')
								<td class="cell-empty cell-unavailable"><div class="cell-empty-inner"></div></td>
							@else
								<td class="cell-empty"><div class="cell-empty-inner">{{ $isPast ? '' : 'Slobodno' }}</div></td>
							@endif
						@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endif
