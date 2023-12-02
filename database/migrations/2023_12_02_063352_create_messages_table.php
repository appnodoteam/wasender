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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text("message");
            $table->string("destination", 50);
            $table->unsignedBigInteger("number_id");
            $table->foreign("number_id")->references("id")->on("numbers");
            $table->string("status", 20)->default("pending");
            $table->string("messages_id", 50)->nullable();
            $table->json("response")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
