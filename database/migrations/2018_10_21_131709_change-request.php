<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_request', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Type_of_certificate');
            $table->string('Name');
            $table->string('Date_of_completion');
            $table->string('Position');
            $table->string('Committee');
            $table->text('changes');
            $table->string('status')->default('null');
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
        Schema::dropIfExists('change_request');
    }
}
