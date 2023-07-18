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

            $table->string('nip')->nullable();
            $table->string('last_promotion')->nullable();
            $table->string('new_promotion')->nullable();
            $table->enum('promotion_type', ['Pejabat Negara', 'Prestasi Luar Biasa', 'Penyesuaian Ijazah', 'Jabatan Fungsional Tertentu', 'Jabatan Struktural', 'Reguler']);
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
