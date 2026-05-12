<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class ClubSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('en_US');
        $now   = Carbon::now();

        $leagueIds  = DB::table('leagues')->pluck('id')->toArray();
        $countryIds = DB::table('countries')->pluck('id')->toArray();

        // Clubes reales conocidos para dar coherencia al seed
        $realClubs = [
            ['name' => 'Real Madrid',         'city' => 'Madrid',       'founded_year' => 1902, 'stadium_name' => 'Santiago Bernabéu',   'stadium_capacity' => 81_044, 'budget_millions' => 800.0],
            ['name' => 'FC Barcelona',         'city' => 'Barcelona',    'founded_year' => 1899, 'stadium_name' => 'Spotify Camp Nou',    'stadium_capacity' => 99_354, 'budget_millions' => 700.0],
            ['name' => 'Atlético de Madrid',   'city' => 'Madrid',       'founded_year' => 1903, 'stadium_name' => 'Cívitas Metropolitano','stadium_capacity' => 68_456, 'budget_millions' => 400.0],
            ['name' => 'Sevilla FC',           'city' => 'Sevilla',      'founded_year' => 1890, 'stadium_name' => 'Ramón Sánchez-Pizjuán','stadium_capacity' => 43_883, 'budget_millions' => 200.0],
            ['name' => 'Manchester City',      'city' => 'Manchester',   'founded_year' => 1880, 'stadium_name' => 'Etihad Stadium',      'stadium_capacity' => 53_400, 'budget_millions' => 900.0],
            ['name' => 'Liverpool FC',         'city' => 'Liverpool',    'founded_year' => 1892, 'stadium_name' => 'Anfield',             'stadium_capacity' => 61_276, 'budget_millions' => 750.0],
            ['name' => 'Arsenal FC',           'city' => 'Londres',      'founded_year' => 1886, 'stadium_name' => 'Emirates Stadium',    'stadium_capacity' => 60_704, 'budget_millions' => 600.0],
            ['name' => 'Chelsea FC',           'city' => 'Londres',      'founded_year' => 1905, 'stadium_name' => 'Stamford Bridge',     'stadium_capacity' => 40_173, 'budget_millions' => 650.0],
            ['name' => 'Bayern München',       'city' => 'Múnich',       'founded_year' => 1900, 'stadium_name' => 'Allianz Arena',       'stadium_capacity' => 75_024, 'budget_millions' => 800.0],
            ['name' => 'Borussia Dortmund',    'city' => 'Dortmund',     'founded_year' => 1909, 'stadium_name' => 'Signal Iduna Park',   'stadium_capacity' => 81_365, 'budget_millions' => 450.0],
            ['name' => 'Paris Saint-Germain',  'city' => 'París',        'founded_year' => 1970, 'stadium_name' => 'Parc des Princes',    'stadium_capacity' => 48_712, 'budget_millions' => 900.0],
            ['name' => 'Juventus FC',          'city' => 'Turín',        'founded_year' => 1897, 'stadium_name' => 'Juventus Stadium',    'stadium_capacity' => 41_507, 'budget_millions' => 500.0],
            ['name' => 'AC Milan',             'city' => 'Milán',        'founded_year' => 1899, 'stadium_name' => 'San Siro',            'stadium_capacity' => 80_018, 'budget_millions' => 450.0],
            ['name' => 'Inter de Milán',       'city' => 'Milán',        'founded_year' => 1908, 'stadium_name' => 'San Siro',            'stadium_capacity' => 80_018, 'budget_millions' => 480.0],
            ['name' => 'SL Benfica',           'city' => 'Lisboa',       'founded_year' => 1904, 'stadium_name' => 'Estádio da Luz',      'stadium_capacity' => 64_642, 'budget_millions' => 200.0],
            ['name' => 'FC Porto',             'city' => 'Porto',        'founded_year' => 1893, 'stadium_name' => 'Estádio do Dragão',   'stadium_capacity' => 50_033, 'budget_millions' => 180.0],
            ['name' => 'Ajax',                 'city' => 'Ámsterdam',    'founded_year' => 1900, 'stadium_name' => 'Johan Cruyff ArenA',  'stadium_capacity' => 55_865, 'budget_millions' => 250.0],
            ['name' => 'Club América',         'city' => 'Ciudad de México','founded_year' => 1916,'stadium_name' => 'Estadio Azteca',    'stadium_capacity' => 87_000, 'budget_millions' => 120.0],
            ['name' => 'Flamengo',             'city' => 'Río de Janeiro','founded_year' => 1895,'stadium_name' => 'Maracaná',           'stadium_capacity' => 78_838, 'budget_millions' => 150.0],
            ['name' => 'Boca Juniors',         'city' => 'Buenos Aires', 'founded_year' => 1905, 'stadium_name' => 'La Bombonera',        'stadium_capacity' => 54_000, 'budget_millions' => 80.0],
        ];

        $batch = [];
        foreach ($realClubs as $i => $club) {
            $leagueId = $leagueIds[array_rand($leagueIds)];
            $countryId = $countryIds[array_rand($countryIds)];
            $batch[] = [
                'league_id'         => $leagueId,
                'country_id'        => $countryId,
                'name'              => $club['name'],
                'short_name'        => strtoupper(substr($club['name'], 0, 5)),
                'city'              => $club['city'],
                'founded_year'      => $club['founded_year'],
                'stadium_name'      => $club['stadium_name'],
                'stadium_capacity'  => $club['stadium_capacity'],
                'budget_millions'   => $club['budget_millions'],
                'crest_url'         => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ];
        }

        // Rellenar hasta 200 clubes con datos generados
        for ($i = count($realClubs); $i < 200; $i++) {
            $city = $faker->city();
            $batch[] = [
                'league_id'         => $leagueIds[array_rand($leagueIds)],
                'country_id'        => $countryIds[array_rand($countryIds)],
                'name'              => $faker->lastName() . ' FC',
                'short_name'        => strtoupper(substr($faker->lexify('???'), 0, 4)),
                'city'              => $city,
                'founded_year'      => $faker->numberBetween(1880, 2005),
                'stadium_name'      => 'Estadio ' . $faker->lastName(),
                'stadium_capacity'  => $faker->numberBetween(5_000, 80_000),
                'budget_millions'   => $faker->randomFloat(2, 5, 400),
                'crest_url'         => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ];
        }

        foreach (array_chunk($batch, 50) as $chunk) {
            DB::table('clubs')->insert($chunk);
        }
    }
}
