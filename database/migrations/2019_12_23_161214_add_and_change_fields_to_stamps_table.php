<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAndChangeFieldsToStampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stamps', function (Blueprint $table) {
            $table->float('face_value')->default(0)->nullable(false)->change();
            $table->float('mint_value')->default(0);
            $table->float('used_value')->default(0);
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
            $table->float('face_value')->default(null)->nullable()->change();
            $table->dropColumn('mint_value');
            $table->dropColumn('used_value');
        });
    }
}
