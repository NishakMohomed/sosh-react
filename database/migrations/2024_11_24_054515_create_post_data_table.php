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
        Schema::create('post_data', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('heading');
            $table->string('subtitle');
            $table->text('content');
            $table->json('hash_tags');
            $table->string('product_image_url');
            $table->text('background_image_description');
            $table->string('heading_position');
            $table->string('subtitle_position');
            $table->string('content_position');
            $table->json('theme');
            $table->foreignUuid('product_url_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_data');
    }
};
