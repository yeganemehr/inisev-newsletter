<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')
                ->references('id')
                ->on('websites')
                ->cascadeOnDelete();

            $table->string('name')->nullable();
            $table->string('email');

            $table->timestamps();

            $table->unique(['website_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};
