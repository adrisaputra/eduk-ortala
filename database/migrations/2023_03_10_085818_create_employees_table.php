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
            
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('front_title')->nullable();
            $table->string('back_title')->nullable();
            $table->string('birthplace')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('status', ['honorer', 'cpns','pns']);
            $table->enum('employee_type', ['ASN', 'PPPK']);
            $table->string('religion')->nullable();
            $table->text('address')->nullable();
            $table->string('no_karpeg')->nullable();
            $table->string('no_askes')->nullable();
            $table->string('no_taspen')->nullable();
            $table->string('no_karis_karsu')->nullable();
            $table->string('no_npwp')->nullable();

            $table->unsignedInteger('class_id');
            $table->foreign("class_id")->references('id')->on("classes");

            $table->unsignedInteger('position_id');
            $table->foreign("position_id")->references('id')->on("positions");

            $table->unsignedInteger('education_id');
            $table->foreign("education_id")->references('id')->on("educations");

            $table->unsignedInteger('unit_id');
            $table->foreign("unit_id")->references('id')->on("units");

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
