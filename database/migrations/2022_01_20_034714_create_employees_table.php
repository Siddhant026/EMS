<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('user_id')->unsigned()->unique();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->string('address');
            $table->integer('pincode');
            $table->date('dob');
            $table->date('date_of_joining');
            $table->integer('position_id')->unsigned();
            $table->foreign('position_id')
                ->references('id')->on('positions')
                ->onDelete('cascade');
            $table->integer('manager_id')->unsigned()->nullable();
            $table->foreign('manager_id')
                ->references('id')->on('employees')
                ->onDelete('cascade');
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
