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
        Schema::create('spin_bets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gamesno', 32)->nullable()->unique();
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->json('bet')->nullable();
            $table->string('win_number', 32)->nullable();
            $table->integer('status')->default(1)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spin_bets');
    }
};
