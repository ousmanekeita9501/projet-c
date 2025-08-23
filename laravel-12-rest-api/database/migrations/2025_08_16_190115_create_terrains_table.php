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
        Schema::create('terrains', function (Blueprint $table) {
            $table->id();

            // 🔗 Relation avec utilisateurs par téléphone
            $table->string('telephone');
            $table->foreign('telephone')->references('telephone')->on('utilisateurs')->onDelete('cascade');

            // Fichiers
            $table->string('carte_identite_path')->nullable();
            $table->string('titre_propriete_path')->nullable();
            $table->json('photos')->nullable();

            // Infos générales
            $table->integer('nombre_joueurs')->nullable();
            $table->string('heure_ouverture')->nullable();
            $table->string('heure_fermeture')->nullable();

            // Temps de match
            $table->enum('temps_match', ['fixe', 'variable'])->nullable();
            $table->integer('duree_match')->nullable();
            $table->integer('nombre_periodes')->nullable();
            $table->integer('delai_match')->nullable();

            // Tarifs
            $table->integer('tarif')->nullable();
            $table->integer('prix_reservation')->nullable();

            // Équipements
            $table->enum('vestiaire', ['avec_douches', 'sans_douches', 'non'])->nullable();

            // Textes
            $table->text('points_forts')->nullable();
            $table->text('description')->nullable();
            $table->text('adresse')->nullable();
            $table->string('emplacement')->nullable(); // lien google maps
            $table->text('reglement')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terrains');
    }
};
