<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldsToIssues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->string('subject')->nullable();
            $table->string('print_process')->nullable();
            $table->string('size')->nullable();
            $table->string('perforations')->nullable();
            $table->string('gum')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->dropColumn(['print_process', 'size', 'perforations', 'gum']);
        });
    }
}
