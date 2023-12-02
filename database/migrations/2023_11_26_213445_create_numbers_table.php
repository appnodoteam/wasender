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
        Schema::create('numbers', function (Blueprint $table) {
            $table->unsignedBigInteger("id",false)->primary();
            $table->string("number_id",50)->nullable();
            $table->string("waba_id",50)->nullable();
            $table->longText("token")->nullable();
            $table->string("status",20)->default("inactive");
            $table->string("name",100)->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign("user_id")->references("id")->on("users");
            $table->boolean("save_messages")->default(false);
            $table->boolean("save_media")->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('numbers');
    }
};
