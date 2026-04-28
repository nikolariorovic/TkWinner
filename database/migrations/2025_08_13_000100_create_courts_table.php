<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('courts', function (Blueprint $table): void {
			$table->id();
			$table->string('name', 100);
			$table->string('location', 255)->nullable();
			$table->timestamp('created_at')->useCurrent();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('courts');
	}
}; 