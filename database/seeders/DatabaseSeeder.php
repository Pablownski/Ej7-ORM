<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,   //   30 países
            LeagueSeeder::class,    //   25 ligas
            ClubSeeder::class,      //  200 clubes
            ManagerSeeder::class,   //  220 entrenadores
            PlayerSeeder::class,    // 5000 jugadores
            SeasonSeeder::class,    //  100 temporadas
            FixtureSeeder::class,   // 2000 partidos
            GoalSeeder::class,      // 5000 goles
            TransferSeeder::class,  // 1200 transferencias
            BookingSeeder::class,   //  700 tarjetas
        ]);

        // Total aproximado:
        //   30 + 25 + 200 + 220 + 5000 + 100 + 2000 + 5000 + 1200 + 700 = 14 475 registros
    }
}
