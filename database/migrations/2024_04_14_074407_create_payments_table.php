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
        Schema::create('payments', function (Blueprint $table) {
            $table->id()->from(104230611);
            $table->string('merchant_sheba');
            $table->boolean('status')->default(0);
            $table->string('bank');
            $table->string('ref_id')->nullable();
            $table->foreignId('invoice_id')
                ->references('id')
                ->on('invoices')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
