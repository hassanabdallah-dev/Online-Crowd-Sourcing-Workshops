<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql1')->create('preferences', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->string('name')->unique();
            $table->boolean('enable')->nullable();
            $table->string('value')->nullable();
            $table->longText('descripton')->nullable();
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
        Schema::connection('mysql1')->dropIfExists('preferences');
    }
}
