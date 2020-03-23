<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('balance_current');
            $table->integer('balance_change');
            $table->timestamps();
        });

        Schema::table('balance', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                                    ->onDelete('cascade')
                                    ->onUpdate('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('balance_total')->after('name')->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('balance', function (Blueprint $table) {
            $table->dropForeign('balance_user_id_foreign');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('balance_total');
        });
        Schema::dropIfExists('balance');
    }
}
