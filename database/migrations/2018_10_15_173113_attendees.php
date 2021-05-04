<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Attendees extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('attendees', function (Blueprint $table) {
      $table->increments('id');
      $table->string('team_name');
      $table->string('team_id');
      $table->integer('rank')->nullable();
      $table->string('member_uid')->unique();
      $table->string('member_fname');
      $table->string('member_lname');
      $table->string('member_email');
      $table->string('member_type')->default('member');
      $table->boolean('banned')->default(0);
      //$table->boolean('certificate_type')->default('cap'); // cap => certificateOfParticipation
      $table->boolean('certificate_status')->default(0);
      $table->boolean('certificate_email_status')->default(0);
      //$table->boolean('certificate_visit_status')->default(0);
      $table->text('bulk_data');
      $table->text('email_log')->nullable();
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
    Schema::dropIfExists('attendees');
  }
}
