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
        Schema::table('records', function (Blueprint $table) {
            $table->renameColumn('accuracy_rate', 'correct_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ロールバック用
        Schema::table('records', function (Blueprint $table) {
            $table->renameColumn('correct_percentage', 'accuracy_rate');
        });
    }
};
