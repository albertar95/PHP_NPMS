<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIsRelatedColumnInMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('FK_MessageMessage');
            $table->dropColumn('RelateId');
            $table->char('RelatedId',38)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->foreign('RelatedId','FK_MessageMessage2')->references('NidMessage')->on('Messages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            //
        });
    }
}
