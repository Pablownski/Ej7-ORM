# Football Manager ORM — Laboratorio 7

Modelado de una **plataforma de gestión de fútbol** usando **Laravel 11** y **Eloquent ORM**.

---

## Dominio: Fútbol

| # | Tabla | Descripción |
|---|---|---|
| 1 | `countries` | Países (nacionalidades de jugadores, sede de ligas) |
| 2 | `leagues` | Ligas de fútbol (Premier League, La Liga, etc.) |
| 3 | `clubs` | Clubes con estadio y presupuesto |
| 4 | `managers` | Entrenadores y su club actual |
| 5 | `players` | Jugadores con posición y valor de mercado |
| 6 | `seasons` | Temporadas de cada liga (con campeón) |
| 7 | `fixtures` | Partidos: local, visitante, marcador, estado |
| 8 | `goals` | Goles con minuto, tipo y asistencia |
| 9 | `transfers` | Transferencias de jugadores entre clubes |
| 10 | `bookings` | Tarjetas amarillas y rojas por partido |

> **Total de registros sembrados: ~14 500** (supera el minimo de 10 000).

---

## Relaciones Eloquent (definidas en ambos modelos)

| Relacion | Tipo | Modelos involucrados |
|---|---|---|
| Un pais tiene muchas ligas | `hasMany` / `belongsTo` | Country — League |
| Una liga tiene muchos clubes | `hasMany` / `belongsTo` | League — Club |
| Un club tiene un entrenador | `hasOne` / `belongsTo` | Club — Manager |
| Un club tiene muchos jugadores | `hasMany` / `belongsTo` | Club — Player |
| Una temporada tiene muchos partidos | `hasMany` / `belongsTo` | Season — Fixture |
| Un partido tiene muchos goles | `hasMany` / `belongsTo` | Fixture — Goal |
| Un jugador tiene muchos goles | `hasMany` / `belongsTo` | Player — Goal |
| Un jugador tiene muchas transferencias | `hasMany` / `belongsTo` | Player — Transfer |
| Un jugador tiene muchas tarjetas | `hasMany` / `belongsTo` | Player — Booking |
| Una temporada pertenece a un campeon | `belongsTo` / `hasMany` | Season — Club (champion) |
| Un partido tiene club local y visitante | `belongsTo` x2 / `hasMany` x2 | Fixture — Club |
| Una transferencia vincula dos clubes | `belongsTo` x2 / `hasMany` x2 | Transfer — Club |

---

## Requisitos

- **Docker** y **Docker Compose** instalados
- Git

---

## Credenciales de la base de datos

El archivo `.env` **no está incluido en el repositorio** (está en `.gitignore`).

Docker usa los siguientes valores por defecto para desarrollo local. Para cambiarlos, define las variables de entorno en tu shell **antes** de correr `docker compose up`:

| Variable | Valor por defecto (Docker) |
|---|---|
| `DB_DATABASE` | `football_manager` |
| `DB_USERNAME` | `dbuser` |
| `DB_PASSWORD` | `changeme` |
| `DB_ROOT_PASSWORD` | `rootchangeme` |

Ejemplo para sobrescribir antes de levantar:

```bash
export DB_PASSWORD=mi_password_seguro
export DB_ROOT_PASSWORD=mi_root_seguro
docker compose up --build
```

---

## Instalacion con Docker (forma mas rapida)

```bash
# 1. Clonar el repositorio
git clone <url-del-repo>
cd Ej7-ORM

# 2. Levantar los servicios — el contenedor genera el .env automaticamente
docker compose up --build
```

El contenedor de la app automaticamente:
1. Genera el `.env` interno con las variables de entorno del contenedor
2. Genera la `APP_KEY`
3. Ejecuta `php artisan migrate` (crea las 10 tablas)
4. Ejecuta `php artisan db:seed` (siembra ~14 500 registros)
5. Levanta el servidor en **http://localhost:8000**

> El seed puede tardar 2-4 minutos por el volumen de datos.

Para detener los contenedores:

```bash
docker compose down
```

Para limpiar la base de datos y volver a sembrar:

```bash
docker compose exec app php artisan migrate:fresh --seed
```

---

## Instalacion sin Docker (PHP local)

```bash
# Requisitos: PHP 8.2+, Composer, MySQL 8

composer install
cp .env.example .env
# Editar .env: completar DB_HOST=127.0.0.1 y el resto de credenciales

php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

---

## Ejecutar las consultas Eloquent

```bash
# Con Docker
docker compose exec app php artisan tinker

# Sin Docker
php artisan tinker
```

Dentro de Tinker:

```php
require 'database/queries/ExampleQueries.php';
```

---

## Consultas implementadas

Ver `database/queries/ExampleQueries.php` para el codigo completo con justificaciones.

| # | Descripcion | Tecnicas Eloquent |
|---|---|---|
| 1 | Ultimos partidos de una temporada con goles y tarjetas | **Eager Loading** `with()` anidado, filtro, orden |
| 2 | Top 10 goleadores activos con su club y pais | `withCount`, `with`, `orderBy` |
| 3 | Ligas europeas de 1ra division con sus clubes | `whereHas`, `withCount`, filtro por relacion |
| 4 | Transferencias permanentes mayores a 50M | `where`, `whereIn`, `orderBy`, `with` relaciones |
| 5 | Clubes con mas jugadores de valor alto | `withCount` condicional, `having`, `with` |
| 6 | Partidos con mas goles (alta intensidad) | `withCount`, `with` anidado, `orderBy` |

### Por que Eager Loading en la consulta 1?

Sin `with(['homeClub', 'awayClub', 'goals.scorer'])`, Eloquent haria:
- 1 query para los partidos
- 1 query por partido para el club local (N queries)
- 1 query por partido para el club visitante (N queries)
- 1 query por partido para sus goles (N queries)
- 1 query por gol para el goleador (N*M queries)

Con `with()`, todo queda en **5 queries fijas** sin importar cuantos partidos haya, eliminando el problema **N+1**.

---

## Estructura del proyecto

```
.
+-- app/Models/           # 10 modelos Eloquent
|   |                     # Country, League, Club, Manager, Player
|   |                     # Season, Fixture, Goal, Transfer, Booking
+-- database/
|   +-- migrations/       # 10 migraciones (01 al 10), cada una con up() y down()
|   +-- seeders/          # DatabaseSeeder + 10 seeders individuales
|   +-- queries/          # 6 consultas Eloquent comentadas
+-- docker/
|   +-- Dockerfile
|   +-- start.sh
+-- docker-compose.yml
+-- .env.example
+-- README.md
```
