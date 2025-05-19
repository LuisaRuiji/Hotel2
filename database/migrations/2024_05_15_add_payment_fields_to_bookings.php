<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('payment_method')->nullable();
            $table->decimal('payment_amount', 10, 2)->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount_id')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->string('card_last_four')->nullable();
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'payment_amount',
                'discount_type',
                'discount_id',
                'payment_date',
                'card_last_four'
            ]);
        });
    }
}; 