<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rooms', function (Blueprint $table) {
            // First, modify the status column to be a string to avoid enum constraints
            $table->string('status')->default('available')->change();
        });

        // Update existing statuses to match new format
        DB::statement("UPDATE rooms SET status = LOWER(status)");
        DB::statement("UPDATE rooms SET status = 'available' WHERE status = 'Available'");
        DB::statement("UPDATE rooms SET status = 'occupied' WHERE status = 'Occupied'");
        DB::statement("UPDATE rooms SET status = 'cleaning' WHERE status = 'Maintenance'");
    }

    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->enum('status', ['Available', 'Occupied', 'Maintenance'])->default('Available')->change();
        });

        // Revert status values to original format
        DB::statement("UPDATE rooms SET status = 'Available' WHERE status = 'available'");
        DB::statement("UPDATE rooms SET status = 'Occupied' WHERE status = 'occupied'");
        DB::statement("UPDATE rooms SET status = 'Maintenance' WHERE status = 'cleaning'");
    }
}; 