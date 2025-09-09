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
        Schema::create('referrals', function (Blueprint $table) {
             $table->id();
            $table->foreignId('user_id') // the inviter
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('referred_user_id') // the person who signed up
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            $table->string('code'); // referral code used
            $table->decimal('bonus', 12, 2)->default(0); // bonus earned
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
