<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->double('height')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->double('weight')->nullable();
            $table->string('gender')->nullable();
            $table->string('medical_conditions')->nullable();
            $table->string('allergies')->nullable();
            $table->foreignId('user_id')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
