<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class GoalSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $now   = Carbon::now();

        // Solo partidos jugados
        $fixtureIds = DB::table('fixtures')
            ->where('status', 'played')
            ->pluck('id')
            ->toArray();

        $playerIds = DB::table('players')
            ->where('active', true)
            ->whereIn('position', ['MID', 'FWD'])
            ->pluck('id')
            ->toArray();

        if (empty($playerIds)) {
            $playerIds = DB::table('players')->pluck('id')->toArray();
        }

        $types  = ['normal', 'normal', 'normal', 'normal', 'penalty', 'own_goal'];
        $batch  = [];
        $total  = 0;

        foreach ($fixtureIds as $fixtureId) {
            $fixture = DB::table('fixtures')->find($fixtureId);
            $numGoals = ($fixture->home_score ?? 0) + ($fixture->away_score ?? 0);

            for ($g = 0; $g < $numGoals; $g++) {
                $scorerId = $playerIds[array_rand($playerIds)];
                $assistId = $faker->boolean(55) ? $playerIds[array_rand($playerIds)] : null;
                if ($assistId === $scorerId) $assistId = null;

                $batch[] = [
                    'fixture_id'       => $fixtureId,
                    'player_id'        => $scorerId,
                    'assist_player_id' => $assistId,
                    'minute'           => $faker->numberBetween(1, 90),
                    'stoppage_minute'  => $faker->boolean(15) ? $faker->numberBetween(1, 7) : null,
                    'type'             => $types[array_rand($types)],
                    'created_at'       => $now,
                    'updated_at'       => $now,
                ];
                $total++;

                if (count($batch) === 500) {
                    DB::table('goals')->insert($batch);
                    $batch = [];
                }
            }

            if ($total >= 5000) break;
        }

        if ($batch) {
            DB::table('goals')->insert($batch);
        }
    }
}
