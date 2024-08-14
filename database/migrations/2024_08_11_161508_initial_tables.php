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
        Schema::create('clip_templates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->string('frame_name')->unique();
            $table->text('css')->nullable();
            $table->string('frame_description')->nullable();
            $table->json('json_data')->nullable();
            $table->string('width')->default(env('DEFAULT_WIDTH'));
            $table->string('height')->default(env('DEFAULT_HEIGHT'));
        });

        Schema::create('clips', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('template_id');
            $table->string('clip_name');
            $table->text('css')->nullable();
            $table->string('custom_json_data')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frame_templates');
        Schema::dropIfExists('frames');
    }
};
