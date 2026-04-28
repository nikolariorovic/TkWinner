<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('blocked_customers', function (Blueprint $table) {
			$table->id();
			$table->string('email', 150)->nullable()->index();
			$table->string('phone_normalized', 30)->nullable()->index();
			$table->string('phone_raw', 50)->nullable();
			$table->text('reason')->nullable();
			$table->unsignedBigInteger('blocked_by')->nullable();
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('blocked_customers');
	}
};
