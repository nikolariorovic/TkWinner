<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\TimeSlot;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')],
        );

		$courts = [
			['name' => 'Teren 1', 'location' => 'Gornji teren'],
			['name' => 'Teren 2', 'location' => 'Donji teren'],
			['name' => 'Hala (balon)', 'location' => 'Zatvoreni teren'],
		];
		foreach ($courts as $c) {
			Court::query()->firstOrCreate(
				['name' => $c['name']],
				['location' => $c['location'], 'created_at' => now()],
			);
		}

		if (TimeSlot::query()->count() === 0) {
			TimeSlot::query()->insert([
				['duration_minutes' => 60, 'label' => '1 sat', 'created_at' => now()],
				['duration_minutes' => 90, 'label' => '1.5 sata', 'created_at' => now()],
				['duration_minutes' => 120, 'label' => '2 sata', 'created_at' => now()],
			]);
		}
    }
}
