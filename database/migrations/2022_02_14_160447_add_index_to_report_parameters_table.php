<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToReportParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('report_parameters', function (Blueprint $table) {
            $table->index('ReportId');
            // $table->index(['ParameterKey','ParameterValue'],'KnVindex');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('report_parameters', function (Blueprint $table) {
            //
        });
    }
}
