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
        Schema::create('problems', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('title');
            $table->string('level');
            $table->unsignedInteger('score')->nullable();
            $table->string('tag');
            $table->text('decription');
            $table->string('input_link')->nullable();
            $table->string('submitter_id')->nullable();
            $table->string('creater_id');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problems');
    }
};
