<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->char('NidProject',38)->collation('utf8mb4_persian_ci');
            $table->bigInteger('ProjectNumber');
            $table->string('Subject',2500)->collation('utf8mb4_persian_ci');
            $table->tinyInteger('ProjectStatus');
            $table->char('ScholarId',38)->collation('utf8mb4_persian_ci');
            $table->char('UnitId',38)->collation('utf8mb4_persian_ci');
            $table->char('GroupId',38)->collation('utf8mb4_persian_ci');
            $table->string('Supervisor',150)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('SupervisorMobile',25)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('Advisor',150)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('AdvisorMobile',25)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('Referee1',150)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('Referee2',150)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('Editor',150)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->dateTime('CreateDate');
            $table->string('PersianCreateDate',25)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('TenPercentLetterDate',25)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('PreImploymentLetterDate',25)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('ImploymentDate',25)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('SecurityLetterDate',25)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('ThesisDefenceDate',25)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('ThesisDefenceLetterDate',25)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->tinyInteger('ReducePeriod')->nullable(true);
            $table->string('Commision',8000)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->boolean('HasBookPublish')->nullable(true);
            $table->char('UserId',38)->collation('utf8mb4_persian_ci');
            $table->boolean('TitleApproved')->nullable(true);
            $table->string('ThirtyPercentLetterDate',25)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('SixtyPercentLetterDate',25)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('ATFLetterDate',25)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->boolean('FinalApprove')->nullable(true);
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidProject','PK_Projects');
            $table->foreign('ScholarId','FK_ScholarProject')->references('NidScholar')->on('Scholars');
            $table->foreign('UserId','FK_UserProject')->references('NidUser')->on('Users');
            $table->foreign('UnitId','FK_UnitProject')->references('NidUnit')->on('Units');
            $table->foreign('GroupId','FK_UnitGroupProject')->references('NidGroup')->on('Unit_Groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
