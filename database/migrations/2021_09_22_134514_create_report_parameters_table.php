<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_parameters', function (Blueprint $table) {
            $table->char('NidParameter',38)->collation('utf8mb4_persian_ci');
            $table->char('ReportId',38)->collation('utf8mb4_persian_ci');
            $table->string('ParameterKey',8000)->collation('utf8mb4_persian_ci');
            $table->string('ParameterValue',8000)->collation('utf8mb4_persian_ci')->nullable(true);
            $table->boolean('IsDeleted')->default(false);
            $table->tinyInteger('Type');
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidParameter','PK_ReportParameters');
            $table->foreign('ReportId','FK_ReportReportParameter')->references('NidReport')->on('Reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_parameters');
    }
}
