<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresenceRecapitulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presence_recapitulations', function (Blueprint $table) {
            $table->increments('id',11);
            $table->string('date')->nullable();
            $table->string('employee_amount')->nullable();
            $table->double('tl')->nullable();
            $table->double('ct')->nullable();
            $table->double('s')->nullable();
            $table->double('h')->nullable();
            $table->double('th')->nullable();
            $table->text('desc')->nullable();
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
        Schema::dropIfExists('presence_recapitulations');
    }
}
