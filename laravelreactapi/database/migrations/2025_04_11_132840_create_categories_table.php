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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('meta_title')->nullable();
            $table->string('meta_descrip')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=visible,1=hidden');
            $table->timestamps(); // Add this line to create 'created_at' and 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};