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
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'employee_id')) {
                $table->string('employee_id')->unique();
            }
            
            if (!Schema::hasColumn('employees', 'name')) {
                $table->string('name');
            }
            
            if (!Schema::hasColumn('employees', 'email')) {
                $table->string('email')->unique();
            }
            
            if (!Schema::hasColumn('employees', 'phone')) {
                $table->string('phone');
            }
            
            if (!Schema::hasColumn('employees', 'role')) {
                $table->string('role');
            }
            
            if (!Schema::hasColumn('employees', 'address')) {
                $table->text('address');
            }
            
            if (!Schema::hasColumn('employees', 'joined_date')) {
                $table->date('joined_date');
            }
            
            if (!Schema::hasColumn('employees', 'status')) {
                $table->string('status')->default('active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $columns = [
                'employee_id',
                'name',
                'email',
                'phone',
                'role',
                'address',
                'joined_date',
                'status'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('employees', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
