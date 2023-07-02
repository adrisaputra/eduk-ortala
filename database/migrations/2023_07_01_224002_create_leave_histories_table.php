<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_histories', function (Blueprint $table) {
            $table->increments('id',11);
            
            $table->unsignedBigInteger('employee_id');
            $table->foreign("employee_id")->references('id')->on("employees");

            $table->string('nip')->nullable();
            $table->string('type')->nullable();
            $table->string('hp')->nullable();
            $table->text('info')->nullable();
            $table->enum('status', ['Menunggu','Dalam Proses','Disetujui','Ditolak']);
            $table->enum('final', ['Ya','Tidak']);
            $table->integer('duration')->nullable();
            $table->text('note')->nullable();
            $table->string('file')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_finish')->nullable();
            $table->string('letter_no')->nullable();
            $table->date('letter_date')->nullable();

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
        Schema::dropIfExists('leave_histories');
    }
}
