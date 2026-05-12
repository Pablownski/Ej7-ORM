<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $countries = [
            ['name' => 'España',        'code' => 'ESP', 'continent' => 'Europa',       'population' => 47_400_000],
            ['name' => 'Inglaterra',    'code' => 'ENG', 'continent' => 'Europa',       'population' => 56_000_000],
            ['name' => 'Alemania',      'code' => 'GER', 'continent' => 'Europa',       'population' => 83_200_000],
            ['name' => 'Francia',       'code' => 'FRA', 'continent' => 'Europa',       'population' => 68_000_000],
            ['name' => 'Italia',        'code' => 'ITA', 'continent' => 'Europa',       'population' => 59_000_000],
            ['name' => 'Portugal',      'code' => 'POR', 'continent' => 'Europa',       'population' => 10_300_000],
            ['name' => 'Países Bajos',  'code' => 'NED', 'continent' => 'Europa',       'population' => 17_800_000],
            ['name' => 'Bélgica',       'code' => 'BEL', 'continent' => 'Europa',       'population' => 11_500_000],
            ['name' => 'Brasil',        'code' => 'BRA', 'continent' => 'Sudamérica',   'population' => 215_000_000],
            ['name' => 'Argentina',     'code' => 'ARG', 'continent' => 'Sudamérica',   'population' => 46_000_000],
            ['name' => 'Colombia',      'code' => 'COL', 'continent' => 'Sudamérica',   'population' => 51_000_000],
            ['name' => 'Uruguay',       'code' => 'URU', 'continent' => 'Sudamérica',   'population' => 3_500_000],
            ['name' => 'Chile',         'code' => 'CHI', 'continent' => 'Sudamérica',   'population' => 19_000_000],
            ['name' => 'México',        'code' => 'MEX', 'continent' => 'CONCACAF',     'population' => 130_000_000],
            ['name' => 'Estados Unidos','code' => 'USA', 'continent' => 'CONCACAF',     'population' => 332_000_000],
            ['name' => 'Costa Rica',    'code' => 'CRC', 'continent' => 'CONCACAF',     'population' => 5_100_000],
            ['name' => 'Guatemala',     'code' => 'GUA', 'continent' => 'CONCACAF',     'population' => 18_000_000],
            ['name' => 'Honduras',      'code' => 'HON', 'continent' => 'CONCACAF',     'population' => 10_000_000],
            ['name' => 'Senegal',       'code' => 'SEN', 'continent' => 'África',       'population' => 17_000_000],
            ['name' => 'Nigeria',       'code' => 'NGA', 'continent' => 'África',       'population' => 220_000_000],
            ['name' => 'Ghana',         'code' => 'GHA', 'continent' => 'África',       'population' => 32_000_000],
            ['name' => 'Costa de Marfil','code' => 'CIV','continent' => 'África',       'population' => 27_000_000],
            ['name' => 'Japón',         'code' => 'JPN', 'continent' => 'Asia',         'population' => 126_000_000],
            ['name' => 'Corea del Sur', 'code' => 'KOR', 'continent' => 'Asia',         'population' => 52_000_000],
            ['name' => 'Arabia Saudita','code' => 'KSA', 'continent' => 'Asia',         'population' => 35_000_000],
            ['name' => 'Croacia',       'code' => 'CRO', 'continent' => 'Europa',       'population' => 4_000_000],
            ['name' => 'Serbia',        'code' => 'SRB', 'continent' => 'Europa',       'population' => 7_000_000],
            ['name' => 'Marruecos',     'code' => 'MAR', 'continent' => 'África',       'population' => 37_000_000],
            ['name' => 'Ecuador',       'code' => 'ECU', 'continent' => 'Sudamérica',   'population' => 18_000_000],
            ['name' => 'Perú',          'code' => 'PER', 'continent' => 'Sudamérica',   'population' => 33_000_000],
        ];

        foreach ($countries as &$c) {
            $c['flag_url']    = null;
            $c['created_at']  = $now;
            $c['updated_at']  = $now;
        }

        DB::table('countries')->insert($countries);
    }
}
