<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $now   = Carbon::now();

        $fixtureIds = DB::table('fixtures')
            ->where('status', 'played')
            ->pluck('id')
            ->toArray();

        $playerIds = DB::table('players')->pluck('id')->toArray();
        $types     = ['yellow', 'yellow', 'yellow', 'red', 'second_yellow'];

        $batch = [];

        for ($i = 0; $i < 700; $i++) {
            $batch[] = [
                'fixture_id' => $fixtureIds[array_rand($fixtureIds)],
                'player_id'  => $playerIds[array_rand($playerIds)],
                'minute'     => $faker->numberBetween(1, 90),
                'type'       => $types[array_rand($types)],
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (count($batch) === 200) {
                DB::table('bookings')->insert($batch);
                $batch = [];
            }
        }

        if ($batch) {
            DB::table('bookings')->insert($batch);
        }
    }
}
