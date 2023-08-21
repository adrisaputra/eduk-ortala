<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryIncreasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_increases', function (Blueprint $table) {
            $table->increments('id',11);
            
            $table->unsignedBigInteger('employee_id');
            $table->foreign("employee_id")->references('id')->on("employees");

            $table->unsignedInteger('parent_unit_id');
            $table->foreign("parent_unit_id")->references('id')->on("parent_units");

            $table->string('nip')->nullable();
            $table->string('old_salary')->nullable();
            $table->string('pejabat')->nullable();
            $table->date('sk_date')->nullable();
            $table->string('sk_number')->nullable();
            $table->date('start_old_date')->nullable();
            $table->year('year_old_salary')->nullable();
            $table->integer('month_old_salary')->nullable();

            $table->string('new_salary')->nullable();
            $table->year('year_new_salary')->nullable();
            $table->integer('month_new_salary')->nullable();
            $table->string('class')->nullable();
            $table->date('start_new_date')->nullable();
            $table->string('status_employee')->nullable();
            $table->date('next_kgb')->nullable();
            $table->enum('status', ['Diterima', 'Diperbaiki', 'Ditolak']);
            $table->text('note');
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
        Schema::dropIfExists('salary_increases');
    }
}
