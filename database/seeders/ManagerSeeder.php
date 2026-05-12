<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class ManagerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('en_US');
        $now   = Carbon::now();
        $tactics = ['4-3-3', '4-4-2', '4-2-3-1', '3-5-2', '3-4-3', '5-3-2'];

        $clubIds    = DB::table('clubs')->pluck('id')->toArray();
        $countryIds = DB::table('countries')->pluck('id')->toArray();

        $batch = [];
        // Un entrenador por club + algunos libres
        foreach ($clubIds as $i => $clubId) {
            $batch[] = [
                'club_id'    => $clubId,
                'country_id' => $countryIds[array_rand($countryIds)],
                'first_name' => $faker->firstName('male'),
                'last_name'  => $faker->lastName(),
                'birth_date' => $faker->dateTimeBetween('-65 years', '-35 years')->format('Y-m-d'),
                'tactic'     => $tactics[array_rand($tactics)],
                'hired_at'   => $faker->dateTimeBetween('-3 years', '-1 month')->format('Y-m-d'),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // 20 entrenadores sin club (libres en el mercado)
        for ($i = 0; $i < 20; $i++) {
            $batch[] = [
                'club_id'    => null,
                'country_id' => $countryIds[array_rand($countryIds)],
                'first_name' => $faker->firstName('male'),
                'last_name'  => $faker->lastName(),
                'birth_date' => $faker->dateTimeBetween('-65 years', '-35 years')->format('Y-m-d'),
                'tactic'     => $tactics[array_rand($tactics)],
                'hired_at'   => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($batch, 100) as $chunk) {
            DB::table('managers')->insert($chunk);
        }
    }
}
