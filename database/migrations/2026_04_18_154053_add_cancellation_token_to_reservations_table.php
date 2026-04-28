<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::table('reservations', function (Blueprint $table): void {
			$table->string('cancellation_token', 64)->unique()->nullable()->after('phone');
		});
	}

	public function down(): void
	{
		Schema::table('reservations', function (Blueprint $table): void {
			$table->dropUnique(['cancellation_token']);
			$table->dropColumn('cancellation_token');
		});
	}
};
