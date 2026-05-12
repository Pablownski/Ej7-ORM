<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class PlayerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('en_US');
        $now   = Carbon::now();

        $clubIds    = DB::table('clubs')->pluck('id')->toArray();
        $countryIds = DB::table('countries')->pluck('id')->toArray();

        $positions = ['GK', 'DEF', 'DEF', 'DEF', 'MID', 'MID', 'MID', 'FWD', 'FWD'];
        $batch = [];

        for ($i = 0; $i < 5000; $i++) {
            $isActive = $faker->boolean(90);
            // 5% de jugadores libres (sin club)
            $clubId = $faker->boolean(95) ? $clubIds[array_rand($clubIds)] : null;

            $batch[] = [
                'club_id'               => $clubId,
                'country_id'            => $countryIds[array_rand($countryIds)],
                'first_name'            => $faker->firstName(),
                'last_name'             => $faker->lastName(),
                'birth_date'            => $faker->dateTimeBetween('-38 years', '-16 years')->format('Y-m-d'),
                'position'              => $positions[array_rand($positions)],
                'jersey_number'         => $faker->boolean(85) ? $faker->numberBetween(1, 99) : null,
                'market_value_millions' => $faker->randomFloat(2, 0.1, 200),
                'active'                => $isActive,
                'created_at'            => $now,
                'updated_at'            => $now,
            ];

            if (count($batch) === 500) {
                DB::table('players')->insert($batch);
                $batch = [];
            }
        }

        if ($batch) {
            DB::table('players')->insert($batch);
        }
    }
}
