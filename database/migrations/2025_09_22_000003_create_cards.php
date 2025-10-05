<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_account_id')->constrained('bank_accounts')->onDelete('cascade');
            $table->string('card_number', 32);
            $table->unsignedSmallInteger('expire_year');
            $table->unsignedTinyInteger('expire_month');
            $table->string('cvv', 8);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('bank_account_id');
            $table->index('card_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
