<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('time_slots', function (Blueprint $table): void {
			$table->id();
			$table->unsignedInteger('duration_minutes');
			$table->string('label', 50);
			$table->timestamp('created_at')->useCurrent();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('time_slots');
	}
}; 