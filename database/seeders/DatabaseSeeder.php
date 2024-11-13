<?php

namespace Database\Seeders;

use App\Models\Setting;
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

        User::factory()->create([
            'name' => 'Deyber Manrique',
            'email' => 'dbrmanrique@gmail.com',
        ]);

        Setting::create(['key' => 'institution_name', 'value' => 'UGEL - ASUNCIÓN']);
        Setting::create(['key' => 'ruc', 'value' => '20571443784']);
        Setting::create(['key' => 'airhsp_code', 'value' => '001479']);
        Setting::create(['key' => 'essalud_percent', 'value' => '9']);
        Setting::create(['key' => 'onp_percent', 'value' => '13']);
        Setting::create(['key' => 'working_hours', 'value' => '8']);
    }
}
