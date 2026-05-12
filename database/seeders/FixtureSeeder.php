<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class FixtureSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $now   = Carbon::now();

        $seasonIds = DB::table('seasons')->pluck('id')->toArray();
        $clubIds   = DB::table('clubs')->pluck('id')->toArray();

        $batch = [];
        $total = 0;

        foreach ($seasonIds as $seasonId) {
            $season = DB::table('seasons')->find($seasonId);
            $matchesPerSeason = 20;

            for ($i = 0; $i < $matchesPerSeason; $i++) {
                // Evitar que local y visitante sean el mismo club
                do {
                    $homeId = $clubIds[array_rand($clubIds)];
                    $awayId = $clubIds[array_rand($clubIds)];
                } while ($homeId === $awayId);

                $isPlayed = $faker->boolean(75);
                $playedAt = $isPlayed
                    ? $faker->dateTimeBetween($season->start_date, min($season->end_date, date('Y-m-d')))->format('Y-m-d H:i:s')
                    : null;

                $batch[] = [
                    'season_id'    => $seasonId,
                    'home_club_id' => $homeId,
                    'away_club_id' => $awayId,
                    'played_at'    => $playedAt,
                    'home_score'   => $isPlayed ? $faker->numberBetween(0, 6) : null,
                    'away_score'   => $isPlayed ? $faker->numberBetween(0, 5) : null,
                    'status'       => $isPlayed ? 'played' : ($faker->boolean(10) ? 'postponed' : 'scheduled'),
                    'attendance'   => $isPlayed ? $faker->numberBetween(5_000, 90_000) : null,
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ];
                $total++;

                if (count($batch) === 200) {
                    DB::table('fixtures')->insert($batch);
                    $batch = [];
                }

                if ($total >= 2000) break 2;
            }
        }

        if ($batch) {
            DB::table('fixtures')->insert($batch);
        }
    }
}
