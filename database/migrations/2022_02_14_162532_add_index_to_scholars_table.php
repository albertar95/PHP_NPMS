<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToScholarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scholars', function (Blueprint $table) {
            $table->index(['NidScholar','IsDeleted']);
            $table->index(['FirstName','LastName']);
            $table->index('UserId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scholars', function (Blueprint $table) {
            //
        });
    }
}
