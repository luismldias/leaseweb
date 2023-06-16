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

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });

        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('hash');
            $table->string('ram_info');
            $table->integer('ram_value');
            $table->string('hdd_info');
            $table->string('hdd_type');
            $table->integer('hdd_size_in_mb');
            $table->string('price');
            $table->unsignedBigInteger('location_id');
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servers');
        Schema::dropIfExists('locations');
    }
};
