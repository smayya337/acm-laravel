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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->comment('Event name');
            $table->dateTimeTz('start')->default(now())->comment('Event start date and time');
            $table->dateTimeTz('end')->nullable()->comment('Optional event end date and time');
            $table->string('location')->comment('Event location');
            $table->string('description')->nullable()->comment('Optional event description');
            $table->string('image')->nullable()->comment('Event image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
