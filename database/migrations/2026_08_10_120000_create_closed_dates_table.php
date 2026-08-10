<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('closed_dates', function (Blueprint $table) {
			$table->id();
			$table->date('date')->unique();
			$table->string('reason', 255)->nullable();
			$table->unsignedBigInteger('closed_by')->nullable();
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('closed_dates');
	}
};
