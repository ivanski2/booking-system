<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('appointment_datetime');
            $table->string('client_name');
            $table->string('client_egn', 10);         // ЕГН (ограничаваме до 10 символа)
            $table->text('description')->nullable();
            $table->string('notification_type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
