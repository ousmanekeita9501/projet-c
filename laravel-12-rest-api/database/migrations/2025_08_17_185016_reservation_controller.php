<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // 🔑 Lien avec l'utilisateur
            $table->string('telephone_utilisateur');
            $table->foreign('telephone_utilisateur')->references('telephone')->on('utilisateurs')->onDelete('cascade');

            // 🔑 Lien avec le terrain
            $table->unsignedBigInteger('terrain_id');
            $table->foreign('terrain_id')->references('id')->on('terrains')->onDelete('cascade');

            // Infos de réservation
            $table->date('date_reservation');
            $table->time('heure_reservation');
            $table->string('code_secret')->unique(); // pour vérifier à l'entrée

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
