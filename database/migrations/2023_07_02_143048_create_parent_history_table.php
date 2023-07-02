<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_history', function (Blueprint $table) {
            $table->increments('id',11);
            
            $table->unsignedBigInteger('employee_id');
            $table->foreign("employee_id")->references('id')->on("employees");

            $table->string('nip')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_birthplace')->nullable();
            $table->date('father_birthdate')->nullable();
            $table->string('father_work')->nullable();
            $table->string('father_address')->nullable();
            $table->string('father_rt')->nullable();
            $table->string('father_rw')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('father_codepos')->nullable();
            $table->string('father_village')->nullable();
            $table->string('father_district')->nullable();
            $table->string('father_regency')->nullable();
            $table->string('father_province')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_birthplace')->nullable();
            $table->date('mother_birthdate')->nullable();
            $table->string('mother_work')->nullable();
            $table->string('mother_address')->nullable();
            $table->string('mother_rt')->nullable();
            $table->string('mother_rw')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('mother_codepos')->nullable();
            $table->string('mother_village')->nullable();
            $table->string('mother_district')->nullable();
            $table->string('mother_regency')->nullable();
            $table->string('mother_province')->nullable();
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
        Schema::dropIfExists('parent_history');
    }
}
