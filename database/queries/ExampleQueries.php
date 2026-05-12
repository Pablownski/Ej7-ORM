<?php

/**
 * Consultas Eloquent de ejemplo — Laboratorio 7 ORM
 * Dominio: Plataforma de Gestión de Fútbol
 *
 * Para ejecutar desde Tinker:
 *   docker compose exec app php artisan tinker
 *   >>> require 'database/queries/ExampleQueries.php';
 */

use App\Models\Club;
use App\Models\Fixture;
use App\Models\League;
use App\Models\Player;
use App\Models\Transfer;

// ─────────────────────────────────────────────────────────────────────────────
// CONSULTA 1 — Eager Loading (previene el problema N+1)
//
// Se usa with() porque, sin él, por cada partido se lanzaría una query para
// homeClub, una para awayClub y otra para cada gol + su scorer. Con Eager
// Loading, Eloquent resuelve todo en 4 queries en lugar de O(n*m), sin importar
// cuántos partidos y goles haya.
// ─────────────────────────────────────────────────────────────────────────────

$seasonId = 1; // Cambia al ID de temporada que quieras explorar

$partidos = Fixture::with([
        'homeClub',
        'awayClub',
        'goals.scorer',     // goles con su goleador (relación anidada)
        'bookings.player',  // tarjetas con el jugador amonestado
    ])
    ->where('season_id', $seasonId)
    ->where('status', 'played')
    ->orderBy('played_at', 'desc')
    ->take(10)
    ->get();

echo "=== Consulta 1: Últimos 10 partidos jugados de la temporada {$seasonId} ===\n";
foreach ($partidos as $f) {
    $score = "{$f->home_score} - {$f->away_score}";
    echo "  [{$f->played_at?->format('d/m/Y')}] {$f->homeClub->name} {$score} {$f->awayClub->name}\n";
    foreach ($f->goals as $goal) {
        echo "    ⚽ min.{$goal->minute} — {$goal->scorer->first_name} {$goal->scorer->last_name} ({$goal->type})\n";
    }
}


// ─────────────────────────────────────────────────────────────────────────────
// CONSULTA 2 — Top 10 goleadores con su club y país
//
// withCount() agrega goals_count sin cargar los registros. Se encadena
// with() para traer las relaciones necesarias en pantalla.
// ─────────────────────────────────────────────────────────────────────────────

$topGoleadores = Player::withCount('goals')
    ->with(['club', 'country'])
    ->where('active', true)
    ->orderBy('goals_count', 'desc')
    ->take(10)
    ->get();

echo "\n=== Consulta 2: Top 10 goleadores activos ===\n";
foreach ($topGoleadores as $i => $player) {
    $club = $player->club?->name ?? 'Sin club';
    echo sprintf(
        "  %2d. %-25s | %-20s | %s | %d goles\n",
        $i + 1,
        "{$player->first_name} {$player->last_name}",
        $club,
        $player->country->code,
        $player->goals_count
    );
}


// ─────────────────────────────────────────────────────────────────────────────
// CONSULTA 3 — Ligas con sus clubes, filtradas por continente
//
// Relación anidada country → leagues → clubs. Se usa whereHas para filtrar
// ligas cuyo país esté en un continente específico.
// ─────────────────────────────────────────────────────────────────────────────

$ligasEuropa = League::with(['country', 'clubs'])
    ->withCount('clubs')
    ->whereHas('country', fn ($q) => $q->where('continent', 'Europa'))
    ->where('level', 1)
    ->orderBy('clubs_count', 'desc')
    ->get();

echo "\n=== Consulta 3: Ligas de primera división en Europa ===\n";
foreach ($ligasEuropa as $liga) {
    echo sprintf(
        "  %-30s | %-5s | %d clubes\n",
        $liga->name,
        $liga->country->code,
        $liga->clubs_count
    );
}


// ─────────────────────────────────────────────────────────────────────────────
// CONSULTA 4 — Transferencias millonarias (>50M) con jugador, origen y destino
//
// Filtra por transfer_fee_millions y tipo, ordena descendente.
// Eager Loading en player + fromClub + toClub para evitar N+1.
// ─────────────────────────────────────────────────────────────────────────────

$transferenciasBig = Transfer::with(['player.country', 'fromClub', 'toClub'])
    ->where('transfer_fee_millions', '>=', 50)
    ->whereIn('transfer_type', ['permanent'])
    ->orderBy('transfer_fee_millions', 'desc')
    ->take(15)
    ->get();

echo "\n=== Consulta 4: Transferencias permanentes ≥50 M de euros ===\n";
foreach ($transferenciasBig as $t) {
    $desde = $t->fromClub?->name ?? 'Libre';
    $hacia = $t->toClub?->name   ?? 'Libre';
    echo sprintf(
        "  %-25s | %-20s → %-20s | %.1fM | %s\n",
        "{$t->player->first_name} {$t->player->last_name}",
        $desde,
        $hacia,
        $t->transfer_fee_millions,
        $t->transferred_at->format('d/m/Y')
    );
}


// ─────────────────────────────────────────────────────────────────────────────
// CONSULTA 5 — Clubes con más de 20 jugadores de valor > 10 M, ordenados
//
// whereHas filtra clubes que cumplan la condición en sus jugadores.
// withCount aplica la misma condición para mostrar el conteo.
// ─────────────────────────────────────────────────────────────────────────────

$clubesRicos = Club::withCount([
        'players as jugadores_valiosos' => fn ($q) => $q
            ->where('market_value_millions', '>=', 10)
            ->where('active', true),
    ])
    ->with('league')
    ->having('jugadores_valiosos', '>=', 5)
    ->orderBy('jugadores_valiosos', 'desc')
    ->get();

echo "\n=== Consulta 5: Clubes con más jugadores de valor ≥10 M ===\n";
foreach ($clubesRicos as $club) {
    echo sprintf(
        "  %-28s | %-20s | %d jugadores valiosos\n",
        $club->name,
        $club->league->name,
        $club->jugadores_valiosos
    );
}


// ─────────────────────────────────────────────────────────────────────────────
// CONSULTA 6 — Partidos con más goles en una temporada (alta intensidad)
//
// withCount('goals') para sumar goles sin cargar todos los registros.
// Eager Loading de homeClub y awayClub. Filtro por temporada y status.
// ─────────────────────────────────────────────────────────────────────────────

$partidosMasGoles = Fixture::withCount('goals')
    ->with(['homeClub', 'awayClub', 'season.league'])
    ->where('status', 'played')
    ->orderBy('goals_count', 'desc')
    ->take(10)
    ->get();

echo "\n=== Consulta 6: Los 10 partidos con más goles ===\n";
foreach ($partidosMasGoles as $f) {
    echo sprintf(
        "  %-20s %d-%d %-20s | %d goles | %s\n",
        $f->homeClub->name,
        $f->home_score,
        $f->away_score,
        $f->awayClub->name,
        $f->goals_count,
        $f->season->league->short_name ?? $f->season->league->name
    );
}

echo "\n[Fin de las consultas de ejemplo]\n";
