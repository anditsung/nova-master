<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('abbr')->index();
            $table->string('wl_id')->nullable();
            $table->string('wl_reporter_id')->nullable();
            $table->boolean('is_active');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_companies');
    }
}
