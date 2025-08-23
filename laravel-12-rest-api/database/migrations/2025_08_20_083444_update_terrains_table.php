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
        Schema::table('terrains', function (Blueprint $table) {
            if (Schema::hasColumn('terrains', 'user_token')) {
                $table->dropColumn('user_token'); // suppression de l’ancien champ
            }

            if (!Schema::hasColumn('terrains', 'telephone')) {
                $table->string('telephone')->after('id');
                $table->foreign('telephone')->references('telephone')->on('utilisateurs')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('terrains', function (Blueprint $table) {
            $table->dropForeign(['telephone']);
            $table->dropColumn('telephone');
            $table->string('user_token')->nullable();
        });
    }
};
