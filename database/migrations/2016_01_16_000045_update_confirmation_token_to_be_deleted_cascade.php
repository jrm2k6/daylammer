<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateConfirmationTokenToBeDeletedCascade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('confirmation_tokens', function (Blueprint $table) {
            $table->dropForeign('confirmation_tokens_user_id_foreign');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('confirmation_tokens', function (Blueprint $table) {
            $table->dropForeign('confirmation_tokens_user_id_foreign');
            $table->foreign('user_id')
                ->references('id')->on('users');
        });
    }
}
