<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Drop existing foreign keys if they exist (prevents duplicate errors)
            $this->dropForeignIfExists('appointments', 'patient_id');
            $this->dropForeignIfExists('appointments', 'doctor_id');

            // Add foreign keys with explicit constraint names
            $table->foreign('patient_id', 'appointments_patient_id_foreign')
                  ->references('id')
                  ->on('patients')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('doctor_id', 'appointments_doctor_id_foreign')
                  ->references('id')
                  ->on('doctors')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign('appointments_patient_id_foreign');
            $table->dropForeign('appointments_doctor_id_foreign');
        });
    }

    /**
     * Helper method to safely drop foreign keys.
     */
    private function dropForeignIfExists(string $table, string $column): void
    {
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE REFERENCED_TABLE_NAME IS NOT NULL 
            AND TABLE_NAME = ? 
            AND COLUMN_NAME = ?
        ", [$table, $column]);

        foreach ($foreignKeys as $fk) {
            Schema::table($table, function (Blueprint $t) use ($fk) {
                $t->dropForeign($fk->CONSTRAINT_NAME);
            });
        }
    }
};