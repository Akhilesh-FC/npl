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
        Schema::create('spin_betlogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gamesno', 32)->nullable();
            $table->integer('number')->nullable();
            $table->double('amount', 8, 2)->default(0);
            $table->integer('status')->default(1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * 
     */
    public function down(): void
    {
        Schema::dropIfExists('spin_betlogs');
    }
};
