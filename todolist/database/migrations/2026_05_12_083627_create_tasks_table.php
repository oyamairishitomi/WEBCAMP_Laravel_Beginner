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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128)->comment('タスク名');
            $table->date('period')->comment('タスクの期限');
            $table->text('detail')->comment('タスクの詳細');
            $table->unsignedTinyInteger('priority')->comment('重要度：（１：低い、２：普通、３：高い）');
            $table->unsignedBigInteger('user_id')->comment('このタスクの所有者');
            $table->foreign('user_id')->references('id')->on('users');
            //$table->timestamps();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTIme('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
