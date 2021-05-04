<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SingleCertificateIssue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('single_certificate_issue', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('type');
            $table->string('uid');
            //$table->boolean('issueType')->default(0);
            $table->boolean('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('single_certificate_issue');
    }
}
