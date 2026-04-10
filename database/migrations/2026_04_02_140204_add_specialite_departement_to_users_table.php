<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('specialite_id')->nullable()->constrained('specialites')->onDelete('set null');
            $table->foreignId('departement_id')->nullable()->constrained('departements')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['specialite_id']);
            $table->dropForeign(['departement_id']);
            $table->dropColumn(['specialite_id', 'departement_id']);
        });
    }
};