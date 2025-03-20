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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id')
                    ->constrained() //levelテーブルのidと紐付け
                    ->onUpdate('cascade') //親テーブルと共に更新
                    ->onDelete('cascade') //親テーブルと共に削除
                    ->comment('レベルID');
            $table->text('question')->comment('問題文');
            $table->text('solution')->comment('解説');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
