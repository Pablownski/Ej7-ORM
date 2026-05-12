<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->constrained()->cascadeOnDelete();
            $table->foreignId('country_id')->constrained();
            $table->string('name');
            $table->string('short_name', 10)->nullable();
            $table->string('city');
            $table->unsignedSmallInteger('founded_year')->nullable();
            $table->string('stadium_name')->nullable();
            $table->unsignedInteger('stadium_capacity')->nullable();
            $table->decimal('budget_millions', 10, 2)->default(0);
            $table->string('crest_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
