<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('position_histories', function (Blueprint $table) {
            $table->increments('id',11);
            
            $table->unsignedBigInteger('employee_id');
            $table->foreign("employee_id")->references('id')->on("employees");

            $table->string('nip')->nullable();
            $table->string('unit')->nullable();
            $table->enum('position_type', ['Struktural','Fungsional Umum','Fungsional Tertentu']);
            $table->string('position')->nullable();
            $table->enum('eselon', ['I.a','I.b','II.a','II.b','III.a','III.b','IV.a','IV.b','V.a','V.b','Non Eselon']);
            $table->date('tmt')->nullable();
            $table->string('sk_number')->nullable();
            $table->string('sk')->nullable();
            $table->string('sk_date')->nullable();
            $table->string('official_name')->nullable();
            $table->enum('sworn_status', ['Sudah','Belum']);
            $table->enum('current_position', ['Ya', 'Tidak']);

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
        Schema::dropIfExists('position_histories');
    }
}
