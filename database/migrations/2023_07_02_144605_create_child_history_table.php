<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_history', function (Blueprint $table) {
            $table->increments('id',11);
            
            $table->unsignedBigInteger('employee_id');
            $table->foreign("employee_id")->references('id')->on("employees");

            $table->string('nip')->nullable();
            $table->string('child_name')->nullable();
            $table->string('child_birthplace')->nullable();
            $table->date('child_birthdate')->nullable();
            $table->string('child_gender')->nullable();
            $table->string('child_status')->nullable();
            $table->string('child_allowance')->nullable();
            $table->string('child_education')->nullable();
            $table->string('child_work')->nullable();
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
        Schema::dropIfExists('child_history');
    }
}
