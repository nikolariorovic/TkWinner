<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Rezervacija tenisa</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<style>
		*{box-sizing:border-box;margin:0;padding:0}
		html,body{height:100%;overflow:hidden}
		body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:linear-gradient(135deg,#D2691E 0%,#CD853F 50%,#A0522D 100%);color:#1a202c}
		.page{height:100vh;display:flex;align-items:center;justify-content:center;padding:16px;overflow:hidden}
		.container{width:100%;max-width:700px;height:100%;display:flex;align-items:center}
		.card{background:#ffffff;border-radius:20px;box-shadow:0 20px 40px rgba(0,0,0,.1);padding:32px;margin:0 auto;width:100%;max-height:90vh;overflow-y:auto}
		h1{font-size:28px;font-weight:700;margin:0 0 20px 0;text-align:center;color:#2d3748;background:linear-gradient(135deg,#D2691E,#CD853F);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
		.label{display:block;font-weight:600;margin-bottom:8px;color:#2d3748;font-size:14px}
		.select,.input{width:100%;padding:14px 16px;border:2px solid #e2e8f0;border-radius:12px;background:#ffffff;font-size:16px;transition:all 0.3s ease;box-shadow:0 2px 8px rgba(0,0,0,.05)}
		.select:focus,.input:focus{outline:none;border-color:#D2691E;box-shadow:0 0 0 3px rgba(210,105,30,.1),0 4px 12px rgba(0,0,0,.1)}
		.button{appearance:none;background:linear-gradient(135deg,#D2691E,#CD853F);color:#ffffff;border:none;border-radius:12px;padding:14px 20px;font-weight:600;cursor:pointer;font-size:15px;transition:all 0.3s ease;box-shadow:0 4px 12px rgba(210,105,30,.3)}
		.button:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(210,105,30,.4)}
		.button.secondary{background:#f7fafc;color:#4a5568;border:2px solid #e2e8f0;box-shadow:0 2px 8px rgba(0,0,0,.05)}
		.button.secondary:hover{background:#edf2f7;border-color:#cbd5e0;transform:translateY(-1px)}
		.button:disabled{background:#cbd5e0;cursor:not-allowed;transform:none;box-shadow:0 2px 8px rgba(0,0,0,.05)}
		.badge{display:inline-block;padding:10px 16px;border-radius:25px;border:2px solid #e2e8f0;background:#ffffff;margin:6px 4px;cursor:pointer;font-weight:500;transition:all 0.3s ease;box-shadow:0 2px 8px rgba(0,0,0,.05);font-size:14px}
		.badge:hover{border-color:#D2691E;transform:translateY(-2px);box-shadow:0 4px 12px rgba(210,105,30,.2)}
		.badge.active{background:linear-gradient(135deg,#D2691E,#CD853F);color:#ffffff;border-color:transparent;box-shadow:0 4px 12px rgba(210,105,30,.3)}
		.row{margin-bottom:18px}
		.date-row{margin-bottom:18px;position:relative}
		.alert{padding:14px 18px;border-radius:12px;margin-bottom:16px;font-weight:500;font-size:14px}
		.alert-success{background:#f0fff4;color:#22543d;border:2px solid #9ae6b4;box-shadow:0 2px 8px rgba(72,187,120,.1)}
		.alert-error{background:#fed7d7;color:#742a2a;border:2px solid #fc8181;box-shadow:0 2px 8px rgba(245,101,101,.1)}
		.hidden{display:none}
		.step-title{font-weight:700;margin-bottom:14px;color:#2d3748;font-size:18px}
		.step-box{border:2px dashed #e2e8f0;border-radius:16px;padding:24px;margin-bottom:16px;background:linear-gradient(135deg,#f7fafc 0%,#edf2f7 100%);position:relative;overflow:visible;z-index:1}
		.step-box::before{content:'';position:absolute;top:-2px;left:-2px;right:-2px;bottom:-2px;background:linear-gradient(135deg,#D2691E,#CD853F);border-radius:18px;z-index:-1;opacity:0;transition:opacity 0.3s ease}
		.step-box:hover::before{opacity:0.1}
		.progress{display:flex;gap:16px;flex-wrap:wrap;margin:12px 0 24px;justify-content:center;align-items:center}
		.progress .p-item{display:flex;align-items:center;gap:6px;font-weight:600;font-size:14px;color:#718096;transition:all 0.3s ease}
		.progress .p-item.active{color:#CD853F}
		.progress .p-item::after{content:'→';margin-left:8px;color:#cbd5e0;font-weight:400}
		.progress .p-item:last-child::after{display:none}
		.times-wrap{display:grid;grid-template-columns:repeat(auto-fill,minmax(110px,1fr));gap:10px;margin:14px 0}
		.button-row{display:flex;gap:12px;justify-content:space-between;align-items:center;flex-wrap:wrap}
		.button-row.center{justify-content:center}
		/* Loader */
		.overlay{position:fixed;inset:0;background:rgba(255,255,255,.8);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;z-index:9999}
		.overlay.hidden{display:none !important}
		.spinner{width:40px;height:40px;border:3px solid #e2e8f0;border-top-color:#D2691E;border-radius:50%;animation:spin 1s linear infinite}
		.spinner.sm{width:24px;height:24px;border-width:2px}
		@keyframes spin{to{transform:rotate(360deg)}}
		/* Responsive */
		@media (max-width: 768px){
			.card{padding:20px;max-height:95vh}
			h1{font-size:24px;margin-bottom:16px}
			.button-row{flex-direction:column-reverse;gap:10px}
			.button-row .button{width:100%}
			.times-wrap{grid-template-columns:repeat(auto-fill,minmax(90px,1fr));gap:8px}
			.progress{gap:12px;font-size:12px}
			.step-box{padding:18px}
			.step-title{font-size:16px}
			.date-row{margin-bottom:18px}
		}
		/* Flatpickr customization - FIXED POSITIONING */
		.date-input-wrapper{position:relative;z-index:1}
		.flatpickr-calendar{
			border-radius:16px !important;
			box-shadow:0 20px 40px rgba(0,0,0,.2) !important;
			border:none !important;
			z-index:9999 !important;
		}
		.flatpickr-calendar.open{
			display:block !important;
			visibility:visible !important;
			opacity:1 !important;
		}
		.flatpickr-day.selected{background:linear-gradient(135deg,#D2691E,#CD853F) !important;border-color:transparent !important;color:white !important}
		.flatpickr-day:hover{background:#fdf4f0 !important;border-color:#D2691E !important}
		.flatpickr-wrapper{position:relative !important;z-index:1 !important}
		.flatpickr-input{position:relative !important;z-index:1 !important}
		.flatpickr-monthDropdown-months,.flatpickr-current-month .flatpickr-monthDropdown-months{background:#D2691E !important;color:white !important}
		.flatpickr-prev-month:hover svg,.flatpickr-next-month:hover svg{fill:#D2691E !important}
		/* Mobile calendar adjustments */
		@media (max-width: 768px){
			.flatpickr-calendar{
				width:280px !important;
				max-width:90vw !important;
			}
		}
	</style>
</head>
<body>
	<div class="page">
		<div class="container">
			<div class="card">
				<h1>🎾 Rezervacija termina</h1>

				@if(session('success'))
					<div id="flash-success" class="alert alert-success">{{ session('success') }}</div>
				@endif
				@if($errors->any())
					<div class="alert alert-error">
						<ul style="margin:0;padding-left:18px;">
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<div class="progress" id="progress">
					<div class="p-item active">1. Teren</div>
					<div class="p-item">2. Datum</div>
					<div class="p-item">3. Trajanje</div>
					<div class="p-item">4. Termin</div>
					<div class="p-item">5. Podaci</div>
				</div>

				<div id="step1" class="step-box">
					<div class="step-title">Izaberite teren</div>
					<div class="row">
						<label class="label" for="court_id">Teren</label>
						<select id="court_id" class="select">
							<option value="">- izaberi teren -</option>
							@foreach($courts as $court)
								<option value="{{ $court->id }}">{{ $court->name }} ({{ $court->location }})</option>
							@endforeach
						</select>
					</div>
					<div class="button-row center">
						<button type="button" class="button" id="next1" disabled>Dalje →</button>
					</div>
				</div>

				<div id="step2" class="step-box hidden">
					<div class="step-title">Izaberite datum</div>
					<div class="date-row">
						<label class="label" for="date">Datum</label>
						<div class="date-input-wrapper">
							<input id="date" type="text" class="input" placeholder="Kliknite za izbor datuma" readonly>
						</div>
					</div>
					<div id="dateStatus" class="row hidden"></div>
					<div class="button-row">
						<button type="button" class="button secondary" id="back1">← Nazad</button>
						<button type="button" class="button" id="next2" disabled>Dalje →</button>
					</div>
				</div>

				<div id="step3" class="step-box hidden">
					<div class="step-title">Izaberite trajanje</div>
					<div class="row">
						<label class="label" for="duration">Trajanje</label>
						<select id="duration" class="select">
							<option value="">- izaberi trajanje -</option>
							@foreach($timeSlots as $slot)
								<option value="{{ $slot->duration_minutes }}">{{ $slot->label }}</option>
							@endforeach
						</select>
					</div>
					<div class="button-row">
						<button type="button" class="button secondary" id="back2">← Nazad</button>
						<button type="button" class="button" id="next3" disabled>Dalje →</button>
					</div>
				</div>

				<div id="step4" class="step-box hidden">
					<div class="step-title">🕐 Izaberite termin</div>
					<div id="times" class="times-wrap"></div>
					<div class="button-row">
						<button type="button" class="button secondary" id="back3">← Nazad</button>
						<button type="button" class="button" id="next4" disabled>Dalje →</button>
					</div>
				</div>

				<div id="step5" class="step-box hidden">
					<div class="step-title">Unesite podatke i potvrdite</div>
					<form id="reserveForm" method="post" action="{{ route('reservations.store') }}">
						@csrf
						<input type="hidden" name="court_id" id="f_court_id">
						<input type="hidden" name="date" id="f_date">
						<input type="hidden" name="time_slot_id" id="f_time_slot_id">
						<input type="hidden" name="start_time" id="f_start_time">

						<div class="row">
							<label class="label" for="first_name">Ime</label>
							<input class="input" type="text" id="first_name" name="first_name" required maxlength="100" value="{{ old('first_name') }}" placeholder="Unesite vaše ime">
						</div>
						<div class="row">
							<label class="label" for="last_name">Prezime</label>
							<input class="input" type="text" id="last_name" name="last_name" required maxlength="100" value="{{ old('last_name') }}" placeholder="Unesite vaše prezime">
						</div>
						<div class="row">
							<label class="label" for="email">Email</label>
							<input class="input" type="email" id="email" name="email" required maxlength="150" value="{{ old('email') }}" placeholder="primer@email.com">
						</div>
						<div class="row">
							<label class="label" for="phone">Telefon</label>
							<input class="input" type="text" id="phone" name="phone" required maxlength="50" pattern="^\+?[0-9\s\-()]{7,20}$" title="npr. +381 64 123 4567 ili 064-123-4567" value="{{ old('phone') }}" placeholder="+381 64 123 4567">
						</div>
						<div class="button-row">
							<button class="button secondary" type="button" id="back4">← Nazad</button>
							<button class="button" type="submit" id="submitBtn" disabled>🎾 Rezerviši</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div id="overlay" class="overlay hidden"><div class="spinner" aria-label="Učitavanje"></div></div>

	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/sr.js"></script>
	<script>
		const stepEls = [
			document.getElementById('step1'),
			document.getElementById('step2'),
			document.getElementById('step3'),
			document.getElementById('step4'),
			document.getElementById('step5'),
		];
		const progress = document.getElementById('progress').children;
		function showStep(n){
			stepEls.forEach((el,i)=>{ if(i===n-1){ el.classList.remove('hidden'); } else { el.classList.add('hidden'); } });
			[...progress].forEach((p,i)=>{ if(i<=n-1){ p.classList.add('active'); } else { p.classList.remove('active'); } });
			if(n===4){ fetchAvailability(); }
		}

		const courtEl = document.getElementById('court_id');
		const dateEl = document.getElementById('date');
		const dateStatus = document.getElementById('dateStatus');
		const durationEl = document.getElementById('duration');
		const timesEl = document.getElementById('times');
		const submitBtn = document.getElementById('submitBtn');
		const next1 = document.getElementById('next1');
		const next2 = document.getElementById('next2');
		const next3 = document.getElementById('next3');
		const next4 = document.getElementById('next4');
		const back1 = document.getElementById('back1');
		const back2 = document.getElementById('back2');
		const back3 = document.getElementById('back3');
		const back4 = document.getElementById('back4');
		const overlay = document.getElementById('overlay');
		let dateOk = false;
		let fp = null;
		let disabledSet = new Set();
		const monthAvailCache = new Map();

		const hidden = {
			court: document.getElementById('f_court_id'),
			date: document.getElementById('f_date'),
			slotId: document.getElementById('f_time_slot_id'),
			startTime: document.getElementById('f_start_time'),
		};

		function setOverlay(show){ show ? overlay.classList.remove('hidden') : overlay.classList.add('hidden'); }

		function getSelectedSlotIdByDuration(duration) {
			const map = {
				@foreach($timeSlots as $slot)
				'{{ $slot->duration_minutes }}': '{{ $slot->id }}',
				@endforeach
			};
			return map[String(duration)] || '';
		}

		function ymd(date){
			const y = date.getFullYear();
			const m = String(date.getMonth()+1).padStart(2,'0');
			const d = String(date.getDate()).padStart(2,'0');
			return `${y}-${m}-${d}`;
		}

		async function fetchMonthAvailability(year, month){
			if(!courtEl.value) return;
			const key = `${courtEl.value}:${year}-${String(month).padStart(2,'0')}`;
			// Serve from cache if present (no network)
			if (monthAvailCache.has(key)) {
				disabledSet = monthAvailCache.get(key);
				if(fp){ fp.set('disable', [(date)=> disabledSet.has(ymd(date))]); }
				return true;
			}
			dateStatus.classList.remove('hidden');
			dateStatus.innerHTML = '<div style="display:flex;align-items:center;gap:8px;color:#718096"><div class="spinner sm"></div><span>Učitavam dostupne dane...</span></div>';
			try {
				const params = new URLSearchParams({ court_id: courtEl.value, year: String(year), month: String(month) });
				const res = await fetch(`{{ route('reservations.monthAvailability') }}?${params.toString()}`);
				const data = await res.json();
				disabledSet = new Set(data.disabledDates || []);
				monthAvailCache.set(key, disabledSet);
				if(fp){ fp.set('disable', [(date)=> disabledSet.has(ymd(date))]); }
				dateStatus.classList.add('hidden');
				return true; // Signalizuje da je učitavanje završeno
			} catch(e){
				dateStatus.innerHTML = '<div class="alert alert-error" style="margin:8px 0 0 0">Greška pri učitavanju dostupnosti kalendara.</div>';
				return false;
			}
		}

		async function initCalendar(){
			if(fp){ fp.destroy(); fp = null; }
			
			// Prvo učitaj dostupnost za trenutni mesec pre inicijalizacije
			const today = new Date();
			await fetchMonthAvailability(today.getFullYear(), today.getMonth() + 1);
			
			fp = flatpickr(dateEl, {
				locale: flatpickr.l10ns.sr || 'sr',
				dateFormat: 'Y-m-d',
				minDate: 'today',
				disable: [(date)=> disabledSet.has(ymd(date))],
				onOpen: async function(selectedDates, dateStr, instance){ 
					await fetchMonthAvailability(instance.currentYear, instance.currentMonth + 1); 
				},
				onMonthChange: async function(selectedDates, dateStr, instance){ 
					await fetchMonthAvailability(instance.currentYear, instance.currentMonth + 1); 
				},
				onChange: function(selectedDates){ 
					if(selectedDates.length){ 
						dateOk = true; 
						next2.disabled = false; 
						hidden.date.value = ymd(selectedDates[0]); 
					} 
				}
			});
		}

		async function fetchAvailability() {
			timesEl.innerHTML = '<div style="width:100%;display:flex;justify-content:center;padding:20px 0"><div class="spinner sm"></div></div>';
			next4.disabled = true;
			const courtId = courtEl.value;
			const date = dateEl.value;
			const duration = durationEl.value;
			if (!courtId || !date || !duration) { timesEl.innerHTML=''; return; }
			try {
				const params = new URLSearchParams({ court_id: courtId, date, duration_minutes: duration });
				const res = await fetch(`{{ route('reservations.availability') }}?${params.toString()}`);
				if (!res.ok) throw new Error('Greška u dohvatanju termina');
				const data = await res.json();
				if (!Array.isArray(data.available) || data.available.length === 0) {
					timesEl.innerHTML = '<div style="text-align:center;color:#718096;padding:20px">Nema dostupnih termina za izabrane kriterijume.</div>';
					return;
				}
				const frag = document.createDocumentFragment();
				data.available.forEach(time => {
					const span = document.createElement('span');
					span.className = 'badge';
					span.textContent = time;
					span.onclick = () => selectTime(time, span);
					if (hidden.startTime.value === time) { span.classList.add('active'); next4.disabled = false; }
					frag.appendChild(span);
				});
				timesEl.innerHTML = '';
				timesEl.appendChild(frag);
			} catch (e) {
				timesEl.innerHTML = '<div class="alert alert-error">Došlo je do greške. Pokušajte ponovo.</div>';
			}
		}

		function selectTime(time, el) {
			Array.from(timesEl.children).forEach(c => c.classList.remove('active'));
			el.classList.add('active');
			hidden.startTime.value = time;
			updateHiddenFields();
			next4.disabled = false;
		}

		function updateHiddenFields() {
			hidden.court.value = courtEl.value || '';
			hidden.date.value = dateEl.value || '';
			hidden.slotId.value = getSelectedSlotIdByDuration(durationEl.value || '');
			submitBtn.disabled = !(hidden.court.value && hidden.date.value && hidden.slotId.value && hidden.startTime.value);
		}

		// Enable/disable next buttons based on selections
		courtEl.addEventListener('change', () => { 
			next1.disabled = !courtEl.value; 
			updateHiddenFields(); 
			if(courtEl.value) initCalendar(); 
		});
		durationEl.addEventListener('change', () => { next3.disabled = !durationEl.value; hidden.startTime.value=''; updateHiddenFields(); });

		// Fetch and populate available durations
		async function fetchAndPopulateDurations() {
			if (!courtEl.value || !dateEl.value) return;
			
			const originalOptions = durationEl.innerHTML;
			durationEl.innerHTML = '<option value="">Učitavam...</option>';
			durationEl.disabled = true;
			
			try {
				const params = new URLSearchParams({ court_id: courtEl.value, date: dateEl.value });
				const res = await fetch(`{{ route('reservations.availableDurations') }}?${params.toString()}`);
				const data = await res.json();
				
				durationEl.innerHTML = '<option value="">- izaberi trajanje -</option>';
				
				if (data.availableDurations && data.availableDurations.length > 0) {
					data.availableDurations.forEach(duration => {
						const option = document.createElement('option');
						option.value = duration.duration_minutes;
						option.textContent = duration.label;
						durationEl.appendChild(option);
					});
				} else {
					durationEl.innerHTML = '<option value="">Nema dostupnih trajanja</option>';
				}
			} catch (e) {
				durationEl.innerHTML = originalOptions; // Restore original options on error
			} finally {
				durationEl.disabled = false;
			}
		}

		// Next buttons
		next1.addEventListener('click', () => { if (!next1.disabled) showStep(2); });
		next2.addEventListener('click', async () => { 
			if (!next2.disabled && dateEl.value) { 
				await fetchAndPopulateDurations(); 
				showStep(3); 
			} 
		});
		next3.addEventListener('click', () => { if (!next3.disabled) showStep(4); });
		next4.addEventListener('click', () => { if (!next4.disabled) { updateHiddenFields(); showStep(5); } });

		// Back buttons
		back1.addEventListener('click', () => showStep(1));
		back2.addEventListener('click', () => showStep(2));
		back3.addEventListener('click', () => showStep(3));
		back4.addEventListener('click', () => showStep(4));

		// Auto-dismiss success flash
		const flash = document.getElementById('flash-success');
		if (flash) { setTimeout(() => flash.remove(), 3500); }

		// Show loader overlay on submit
		document.getElementById('reserveForm')?.addEventListener('submit', () => {
			submitBtn.disabled = true;
			setOverlay(true);
		});

		// Calendar will initialize only when date input is clicked
	</script>
</body>
</html> 