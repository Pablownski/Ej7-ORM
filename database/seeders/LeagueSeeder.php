<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class LeagueSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $byCode = DB::table('countries')->pluck('id', 'code');

        $leagues = [
            ['country_code' => 'ESP', 'name' => 'La Liga',              'short_name' => 'LaLiga',  'level' => 1, 'founded_year' => 1929],
            ['country_code' => 'ESP', 'name' => 'Segunda División',      'short_name' => '2ªDiv',   'level' => 2, 'founded_year' => 1929],
            ['country_code' => 'ENG', 'name' => 'Premier League',        'short_name' => 'PL',      'level' => 1, 'founded_year' => 1992],
            ['country_code' => 'ENG', 'name' => 'EFL Championship',      'short_name' => 'Champ',   'level' => 2, 'founded_year' => 1888],
            ['country_code' => 'GER', 'name' => 'Bundesliga',            'short_name' => 'BL1',     'level' => 1, 'founded_year' => 1963],
            ['country_code' => 'GER', 'name' => '2. Bundesliga',         'short_name' => 'BL2',     'level' => 2, 'founded_year' => 1974],
            ['country_code' => 'FRA', 'name' => 'Ligue 1',               'short_name' => 'L1',      'level' => 1, 'founded_year' => 1932],
            ['country_code' => 'ITA', 'name' => 'Serie A',               'short_name' => 'SA',      'level' => 1, 'founded_year' => 1898],
            ['country_code' => 'POR', 'name' => 'Primeira Liga',         'short_name' => 'PrimL',   'level' => 1, 'founded_year' => 1934],
            ['country_code' => 'NED', 'name' => 'Eredivisie',            'short_name' => 'ED',      'level' => 1, 'founded_year' => 1956],
            ['country_code' => 'BEL', 'name' => 'First Division A',      'short_name' => 'FDA',     'level' => 1, 'founded_year' => 1895],
            ['country_code' => 'BRA', 'name' => 'Brasileirão Série A',   'short_name' => 'BSA',     'level' => 1, 'founded_year' => 1959],
            ['country_code' => 'ARG', 'name' => 'Liga Profesional',      'short_name' => 'LPF',     'level' => 1, 'founded_year' => 1891],
            ['country_code' => 'COL', 'name' => 'Liga BetPlay',          'short_name' => 'BetPlay', 'level' => 1, 'founded_year' => 1948],
            ['country_code' => 'MEX', 'name' => 'Liga MX',               'short_name' => 'LMX',     'level' => 1, 'founded_year' => 1943],
            ['country_code' => 'USA', 'name' => 'Major League Soccer',   'short_name' => 'MLS',     'level' => 1, 'founded_year' => 1993],
            ['country_code' => 'GUA', 'name' => 'Liga Nacional de Fútbol','short_name' => 'LNF',    'level' => 1, 'founded_year' => 1919],
            ['country_code' => 'CRC', 'name' => 'Liga FPD',              'short_name' => 'FPD',     'level' => 1, 'founded_year' => 1921],
            ['country_code' => 'JPN', 'name' => 'J1 League',             'short_name' => 'J1',      'level' => 1, 'founded_year' => 1992],
            ['country_code' => 'KSA', 'name' => 'Saudi Pro League',      'short_name' => 'SPL',     'level' => 1, 'founded_year' => 1976],
            ['country_code' => 'CRO', 'name' => 'HNL',                   'short_name' => 'HNL',     'level' => 1, 'founded_year' => 1941],
            ['country_code' => 'SRB', 'name' => 'Super liga Srbije',     'short_name' => 'SLS',     'level' => 1, 'founded_year' => 1923],
            ['country_code' => 'MAR', 'name' => 'Botola Pro',            'short_name' => 'BP',      'level' => 1, 'founded_year' => 1956],
            ['country_code' => 'ECU', 'name' => 'LigaPro',               'short_name' => 'LP',      'level' => 1, 'founded_year' => 1950],
            ['country_code' => 'PER', 'name' => 'Liga 1',                'short_name' => 'L1PE',    'level' => 1, 'founded_year' => 1912],
        ];

        $rows = [];
        foreach ($leagues as $l) {
            $rows[] = [
                'country_id'   => $byCode[$l['country_code']],
                'name'         => $l['name'],
                'short_name'   => $l['short_name'],
                'level'        => $l['level'],
                'founded_year' => $l['founded_year'],
                'logo_url'     => null,
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }

        DB::table('leagues')->insert($rows);
    }
}
