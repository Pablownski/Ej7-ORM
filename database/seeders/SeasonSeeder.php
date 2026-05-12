<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SeasonSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $leagueIds = DB::table('leagues')->pluck('id')->toArray();
        $clubIds   = DB::table('clubs')->pluck('id')->toArray();

        $batch = [];

        foreach ($leagueIds as $leagueId) {
            // 4 temporadas por liga (2021/22 a 2024/25)
            $years = [[2021, 2022], [2022, 2023], [2023, 2024], [2024, 2025]];
            foreach ($years as [$y1, $y2]) {
                $isFinished = $y2 <= 2024;
                $batch[] = [
                    'league_id'        => $leagueId,
                    'champion_club_id' => $isFinished ? $clubIds[array_rand($clubIds)] : null,
                    'name'             => "{$y1}/{$y2}",
                    'start_date'       => "{$y1}-08-01",
                    'end_date'         => "{$y2}-05-31",
                    'created_at'       => $now,
                    'updated_at'       => $now,
                ];
            }
        }

        foreach (array_chunk($batch, 100) as $chunk) {
            DB::table('seasons')->insert($chunk);
        }
    }
}
