<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql1')->create('users_group', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('group_id');
            $table->timestamps();
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('group_id');
            $table->foreign('group_id')->references('id')->on('group')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::connection('mysql1')->dropIfExists('users_group',function(){
            $table->dropForeign('users_group_user_id_foreign');
            $table->dropIndex('users_group_user_id_index');
            $table->dropColumn('user_id');
            $table->dropForeign('users_group_group_id_foreign');
            $table->dropIndex('users_group_group_id_index');
            $table->dropColumn('group_id');
            });
    }
}
