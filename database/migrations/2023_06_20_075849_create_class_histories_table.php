<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_histories', function (Blueprint $table) {
            $table->increments('id',11);
            
            $table->unsignedBigInteger('employee_id');
            $table->foreign("employee_id")->references('id')->on("employees");

            $table->string('nip')->nullable();

            $table->unsignedInteger('classes_id');
            $table->foreign("classes_id")->references('id')->on("classes");

            $table->string('rank')->nullable();
            $table->string('class')->nullable();
            $table->date('tmt')->nullable();
            $table->string('sk_official')->nullable();
            $table->string('sk_number')->nullable();
            $table->date('sk_date')->nullable();
            $table->integer('mk_year')->nullable();
            $table->integer('mk_month')->nullable();
            $table->string('no_bkn')->nullable();
            $table->string('date_bkn')->nullable();
            $table->string('kp_type')->nullable();

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
        Schema::dropIfExists('class_histories');
    }
}
