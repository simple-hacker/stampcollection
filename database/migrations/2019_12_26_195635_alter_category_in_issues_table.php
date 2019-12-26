<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCategoryInIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable();
        });

        DB::update(`UPDATE issue SET category_id=1 WHERE category='Commemorative'`);
        DB::update(`UPDATE issue SET category_id=2 WHERE category='Definitive'`);

        Schema::table('issues', function (Blueprint $table) {
            $table->dropColumn('category');
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
            $table->string('category')->nullable();
        });

        DB::update(`UPDATE issue SET category='Commemorative' WHERE category_id=1`);
        DB::update(`UPDATE issue SET category='Definitive' WHERE category_id=2`);

        Schema::table('issues', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
}
