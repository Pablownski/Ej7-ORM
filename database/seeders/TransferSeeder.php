<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class TransferSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $now   = Carbon::now();

        $playerIds = DB::table('players')->pluck('id')->toArray();
        $clubIds   = DB::table('clubs')->pluck('id')->toArray();
        $types     = ['permanent', 'permanent', 'loan', 'free', 'return_from_loan'];

        $batch = [];

        for ($i = 0; $i < 1200; $i++) {
            $type     = $types[array_rand($types)];
            $fromId   = $faker->boolean(90) ? $clubIds[array_rand($clubIds)] : null;
            $toId     = $faker->boolean(90) ? $clubIds[array_rand($clubIds)] : null;

            // Evitar mismo club
            if ($fromId && $toId && $fromId === $toId) {
                $toId = $clubIds[array_rand($clubIds)];
            }

            $fee          = ($type === 'free' || $type === 'return_from_loan') ? 0 : $faker->randomFloat(2, 0.5, 220);
            $transferDate = $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d');
            $loanEnd      = ($type === 'loan') ? Carbon::parse($transferDate)->addMonths(rand(6, 18))->format('Y-m-d') : null;

            $batch[] = [
                'player_id'             => $playerIds[array_rand($playerIds)],
                'from_club_id'          => $fromId,
                'to_club_id'            => $toId,
                'transfer_fee_millions' => $fee,
                'transfer_type'         => $type,
                'transferred_at'        => $transferDate,
                'loan_end_date'         => $loanEnd,
                'created_at'            => $now,
                'updated_at'            => $now,
            ];

            if (count($batch) === 300) {
                DB::table('transfers')->insert($batch);
                $batch = [];
            }
        }

        if ($batch) {
            DB::table('transfers')->insert($batch);
        }
    }
}
