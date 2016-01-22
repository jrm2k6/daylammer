<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyColumnDifficultyIdInPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('difficulty_users', function (Blueprint $table) {
            $table->dropColumn('difficulty');
            $table->integer('difficulty_id')->unsigned()->after('user_id');

            $table->foreign('difficulty_id')
                ->references('id')->on('difficulties')
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
        Schema::table('difficulty_users', function (Blueprint $table) {
            $table->string('difficulty')->after('id');
            $table->dropForeign('difficulty_users_difficulty_id_foreign');
            $table->dropColumn('difficulty_id');
        });
    }
}
