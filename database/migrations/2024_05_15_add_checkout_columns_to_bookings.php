<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->timestamp('checked_out_at')->nullable();
            $table->unsignedBigInteger('checked_out_by')->nullable();
            $table->decimal('final_amount', 10, 2)->nullable();
            $table->decimal('additional_charges', 10, 2)->default(0);
            $table->foreign('checked_out_by')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['checked_out_by']);
            $table->dropColumn([
                'checked_out_at',
                'checked_out_by',
                'final_amount',
                'additional_charges'
            ]);
        });
    }
}; 