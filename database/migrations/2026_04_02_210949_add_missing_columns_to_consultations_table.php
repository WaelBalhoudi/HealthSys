<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            if (!Schema::hasColumn('consultations', 'consultation_date')) {
                $table->date('consultation_date')->nullable()->after('doctor_id');
            }
            if (!Schema::hasColumn('consultations', 'symptoms')) {
                $table->text('symptoms')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'diagnosis')) {
                $table->text('diagnosis')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'treatment')) {
                $table->text('treatment')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'weight')) {
                $table->decimal('weight', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('consultations', 'height')) {
                $table->decimal('height', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('consultations', 'blood_pressure')) {
                $table->string('blood_pressure')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'temperature')) {
                $table->decimal('temperature', 4, 1)->nullable();
            }
            if (!Schema::hasColumn('consultations', 'heart_rate')) {
                $table->string('heart_rate')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'notes')) {
                $table->text('notes')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn([
                'consultation_date', 'symptoms', 'diagnosis', 'treatment',
                'weight', 'height', 'blood_pressure', 'temperature', 'heart_rate', 'notes'
            ]);
        });
    }
};