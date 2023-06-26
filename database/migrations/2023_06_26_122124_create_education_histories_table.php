<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education_histories', function (Blueprint $table) {
            $table->increments('id',11);
            
            $table->unsignedBigInteger('employee_id');
            $table->foreign("employee_id")->references('id')->on("employees");

            $table->string('nip')->nullable();

            $table->unsignedInteger('education_id');
            $table->foreign("education_id")->references('id')->on("educations");

            $table->string('official_name')->nullable();
            $table->string('diploma_number')->nullable();
            $table->date('diploma_date')->nullable();
            $table->string('school_name')->nullable();
            $table->enum('current_education', ['Ya', 'Tidak']);

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
        Schema::dropIfExists('education_histories');
    }
}
