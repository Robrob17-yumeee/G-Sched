<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('severity', ['not_assessed', 'low', 'moderate', 'high'])
                  ->default('not_assessed')
                  ->nullable()
                  ->after('purpose')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('severity', ['low', 'medium', 'high'])
                  ->default('low')
                  ->nullable(false)
                  ->change();
        });
    }
};
