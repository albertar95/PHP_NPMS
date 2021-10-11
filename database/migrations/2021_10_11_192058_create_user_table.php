<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->char('NidUser',38)->collation('utf8mb4_persian_ci');
            $table->string('UserName',100)->collation('utf8mb4_persian_ci');
            $table->string('Password',8000)->collation('utf8mb4_persian_ci');
            $table->string('FirstName',100)->collation('utf8mb4_persian_ci');
            $table->string('LastName',100)->collation('utf8mb4_persian_ci');
            $table->dateTime('CreateDate');
            $table->dateTime('LastLoginDate')->nullable();
            $table->integer('IncorrectPasswordCount')->nullable();
            $table->boolean('IsLockedOut');
            $table->boolean('IsDisabled');
            $table->boolean('IsAdmin');
            $table->string('ProfilePicture',8000)->nullable()->collation('utf8mb4_persian_ci');
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidUser','PK_User3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
