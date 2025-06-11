<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id('session_id');
            $table->foreignId('tutor_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('datetime');
            $table->integer('duration');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
