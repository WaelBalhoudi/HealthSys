<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter les colonnes une par une avec vérification
        Schema::table('invoices', function (Blueprint $table) {
            // Ajouter invoice_number
            if (!Schema::hasColumn('invoices', 'invoice_number')) {
                $table->string('invoice_number')->unique();
            }
        });
        
        Schema::table('invoices', function (Blueprint $table) {
            // Ajouter patient_id
            if (!Schema::hasColumn('invoices', 'patient_id')) {
                $table->unsignedBigInteger('patient_id');
            }
        });
        
        Schema::table('invoices', function (Blueprint $table) {
            // Ajouter consultation_id
            if (!Schema::hasColumn('invoices', 'consultation_id')) {
                $table->unsignedBigInteger('consultation_id')->nullable();
            }
        });
        
        Schema::table('invoices', function (Blueprint $table) {
            // Ajouter amount
            if (!Schema::hasColumn('invoices', 'amount')) {
                $table->decimal('amount', 10, 2)->default(0);
            }
        });
        
        Schema::table('invoices', function (Blueprint $table) {
            // Ajouter paid_amount
            if (!Schema::hasColumn('invoices', 'paid_amount')) {
                $table->decimal('paid_amount', 10, 2)->default(0);
            }
        });
        
        Schema::table('invoices', function (Blueprint $table) {
            // Ajouter status
            if (!Schema::hasColumn('invoices', 'status')) {
                $table->string('status')->default('pending');
            }
        });
        
        Schema::table('invoices', function (Blueprint $table) {
            // Ajouter issue_date
            if (!Schema::hasColumn('invoices', 'issue_date')) {
                $table->date('issue_date');
            }
        });
        
        Schema::table('invoices', function (Blueprint $table) {
            // Ajouter due_date
            if (!Schema::hasColumn('invoices', 'due_date')) {
                $table->date('due_date');
            }
        });
        
        Schema::table('invoices', function (Blueprint $table) {
            // Ajouter description
            if (!Schema::hasColumn('invoices', 'description')) {
                $table->text('description')->nullable();
            }
        });
        
        // Ajouter les clés étrangères
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['consultation_id']);
            $table->dropColumn([
                'invoice_number', 'patient_id', 'consultation_id', 'amount',
                'paid_amount', 'status', 'issue_date', 'due_date', 'description'
            ]);
        });
    }
};