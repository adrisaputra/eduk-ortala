<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsenceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absence_histories', function (Blueprint $table) {
            $table->increments('id',11);
            
            $table->unsignedBigInteger('employee_id');
            $table->foreign("employee_id")->references('id')->on("employees");

            $table->string('nip')->nullable();
            $table->date('date')->nullable();
            $table->string('in_type')->nullable();
            $table->time('in')->nullable();
            $table->time('out')->nullable();
            $table->enum('time_zone', ['WIB','WITA','WIT']);

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
        Schema::dropIfExists('absence_histories');
    }
}
