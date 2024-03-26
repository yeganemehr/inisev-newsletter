<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')
                ->references('id')
                ->on('websites')
                ->cascadeOnDelete();
            $table->string('local_id');

            $table->string('title');
            $table->longText('description');
            $table->string('url');

            $table->timestamps();

            $table->unique(['website_id', 'local_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
