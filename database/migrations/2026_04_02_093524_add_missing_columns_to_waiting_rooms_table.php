<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('waiting_rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('waiting_rooms', 'start_time')) {
                $table->timestamp('start_time')->nullable()->after('arrival_time');
            }
            if (!Schema::hasColumn('waiting_rooms', 'end_time')) {
                $table->timestamp('end_time')->nullable()->after('start_time');
            }
            if (!Schema::hasColumn('waiting_rooms', 'estimated_duration')) {
                $table->integer('estimated_duration')->default(30)->after('end_time');
            }
        });
    }

    public function down(): void
    {
        Schema::table('waiting_rooms', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time', 'estimated_duration']);
        });
    }
};