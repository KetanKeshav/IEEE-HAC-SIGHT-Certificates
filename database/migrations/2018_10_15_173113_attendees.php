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
      $table->string('cert_id');
      $table->string('member_uid')->unique();
      $table->string('Certificate_Type');
      $table->string('Name')->default('-');
      $table->string('Year');
      $table->string('Position_chair_member')->default('-');
      $table->string('Committee_of_person')->default('-');
      $table->string('Date_of_completion')->default('-');
      $table->string('Project_Name')->default('-');
      $table->string('Month_of_completion')->default('-');
      $table->string('Email');
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
