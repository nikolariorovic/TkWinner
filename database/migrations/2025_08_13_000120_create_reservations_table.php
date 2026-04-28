<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('reservations', function (Blueprint $table): void {
			$table->id();
			$table->foreignId('court_id')->constrained('courts')->cascadeOnDelete();
			$table->date('reservation_date');
			$table->time('start_time');
			$table->foreignId('time_slot_id')->constrained('time_slots')->restrictOnDelete();
			$table->string('first_name', 100);
			$table->string('last_name', 100);
			$table->string('email', 150);
			$table->string('phone', 50);
			$table->timestamp('created_at')->useCurrent();
			$table->unique(['court_id', 'reservation_date', 'start_time'], 'uniq_court_date_start');
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('reservations');
	}
}; 