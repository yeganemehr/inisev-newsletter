<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('post_id')
                ->references('id')
                ->on('posts')
                ->cascadeOnDelete();

            $table->foreignId('subscriber_id')
                ->references('id')
                ->on('subscribers')
                ->cascadeOnDelete();

            $table->timestamp('created_at')->nullable();
            $table->timestamp('sent_at')->nullable();

            $table->unique(['post_id', 'subscriber_id']);
            $table->unique(['post_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
