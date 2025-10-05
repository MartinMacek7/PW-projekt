<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_account_id')->constrained('bank_accounts')->onDelete('cascade');
            $table->integer('transaction_type');
            $table->string('counterparty_account_number');
            $table->string('counterparty_bank_code')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3);
            $table->string('vs')->nullable();
            $table->string('message')->nullable();
            $table->integer('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
