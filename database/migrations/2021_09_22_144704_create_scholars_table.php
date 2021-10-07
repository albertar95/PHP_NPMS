<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScholarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scholars', function (Blueprint $table) {
            $table->char('NidScholar',38)->collation('utf8mb4_persian_ci');
            $table->string('ProfilePicture',8000)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('FirstName',75)->collation('utf8mb4_persian_ci');
            $table->string('LastName',75)->collation('utf8mb4_persian_ci');
            $table->string('NationalCode',12)->collation('utf8mb4_persian_ci');
            $table->string('BirthDate',25)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('FatherName',75)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('Mobile',25)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->tinyInteger('MillitaryStatus')->nullable(true);
            $table->tinyInteger('GradeId');
            $table->char('MajorId',38)->collation('utf8mb4_persian_ci');
            $table->char('OreintationId',38)->collation('utf8mb4_persian_ci');
            $table->tinyInteger('college')->nullable(true);
            $table->tinyInteger('CollaborationType');
            $table->boolean('IsDeleted')->nullable(true);
            $table->dateTime('DeleteDate')->nullable(true);
            $table->char('DeleteUser',38)->collation('utf8mb4_persian_ci')->nullable(true);
            $table->char('UserId',38)->collation('utf8mb4_persian_ci');
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidScholar','PK_Scholars');
            $table->foreign('MajorId','FK_MajorScholar')->references('NidMajor')->on('Majors');
            $table->foreign('OreintationId','FK_OreintationScholar')->references('NidOreintation')->on('Oreintations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scholars');
    }
}
