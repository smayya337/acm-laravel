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
        Schema::create('officers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('position')->comment('Position');
            $table->integer('sort_order')->default(0)->comment('Optional sort order of officer');
            $table->integer('year')->default(now()->year)->comment('The year this officer was elected');
            $table->boolean('faculty_advisor')->default(false)->comment('Whether this person is a faculty advisor');
            $table->foreignId('user_id')->nullable()->default(null)->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('officers');
    }
};
