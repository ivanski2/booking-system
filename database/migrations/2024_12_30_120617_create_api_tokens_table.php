<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('api_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token', 80)->unique();
            $table->string('username');
            $table->dateTime('expires_at');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('api_tokens');
    }
};
