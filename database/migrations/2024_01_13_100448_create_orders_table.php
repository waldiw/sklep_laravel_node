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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('street', 100)->nullable();
            $table->string('city', 40);
            $table->string('post', 40);
            $table->string('email', 20);
            $table->string('phone', 40);
            $table->text('comments')->nullable();
            $table->boolean('vat')->default(0);
            $table->string('vatName')->nullable();
            $table->string('vatNumber', 13)->nullable();
            $table->string('vatStreet', 100)->nullable();
            $table->string('vatCity', 40)->nullable();
            $table->string('vatPost', 40)->nullable();
            $table->enum('status', array('nowe', 'w realizacji', 'zrealizowane'))->default('nowe');
            $table->uuid('uuid');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
