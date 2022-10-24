<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyPocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_pocs', function (Blueprint $table) {
            $table->id();
             $table->string('first_name');
            $table->string('last_name');
            $table->string('business');
            $table->string('job_title');
            $table->string('contact');
            $table->string('whatsapp');
            $table->string('email');
            $table->string('image');
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
        Schema::dropIfExists('company_pocs');
    }
}
