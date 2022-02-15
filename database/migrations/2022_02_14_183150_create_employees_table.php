<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
//            $table->foreign('user_id')->references('id')->on('users');
            $table->foreignId('users_id')->constrained('users');
//            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreignId('department_id')->constrained('departments');
//            $table->foreign('dutyTime_id')->references('id')->on('duty_times');
            $table->foreignId('dutyTime_id')->constrained('duty_times');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
