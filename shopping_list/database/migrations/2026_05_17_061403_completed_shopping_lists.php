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
        Schema::create('completed_items', function(Blueprint $table) {
            $table->id();
            $table->string('name', 128)->comment('買うもの名');
            $table->unsignedBigInteger('user_id')->comment('所有者');
            $table->foreign('user_id')->references('id')->on('users');
            $table->dateTime('completed_at')->useCurrent()->comment('完了日');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completed_items');
    }
};
