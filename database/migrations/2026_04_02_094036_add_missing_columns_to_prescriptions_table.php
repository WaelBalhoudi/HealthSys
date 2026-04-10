<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            // Vérifier et ajouter les colonnes manquantes
            if (!Schema::hasColumn('prescriptions', 'valid_until')) {
                $table->date('valid_until')->nullable();
            }
            if (!Schema::hasColumn('prescriptions', 'status')) {
                $table->string('status')->default('active');
            }
            if (!Schema::hasColumn('prescriptions', 'consultation_id')) {
                $table->foreignId('consultation_id')->nullable()->constrained()->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn(['valid_until', 'status', 'consultation_id']);
        });
    }
};