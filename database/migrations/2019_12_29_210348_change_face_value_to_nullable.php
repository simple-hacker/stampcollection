<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFaceValueToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stamps', function (Blueprint $table) {
            $table->float('face_value')->nullable(true)->change();
            $table->float('mint_value')->nullable(true)->change();
            $table->float('used_value')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stamps', function (Blueprint $table) {
            $table->float('face_value')->nullable(false)->change();
            $table->float('mint_value')->nullable(false)->change();
            $table->float('used_value')->nullable(false)->change();
        });
    }
}
