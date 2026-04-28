<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Kompozitni index za court_id + reservation_date (najčešći upit)
            $table->index(['court_id', 'reservation_date'], 'idx_reservations_court_date');
            
            // Index za reservation_date (month availability upiti)
            $table->index(['reservation_date'], 'idx_reservations_date');
            
            // Kompozitni index za conflict checking
            $table->index(['court_id', 'reservation_date', 'start_time'], 'idx_reservations_court_date_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropIndex('idx_reservations_court_date');
            $table->dropIndex('idx_reservations_date');
            $table->dropIndex('idx_reservations_court_date_time');
        });
    }
};
