<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->char('NidUser',38)->collation('utf8mb4_persian_ci');
            $table->string('UserName',50)->collation('utf8mb4_persian_ci');
            $table->string('Password',50)->collation('utf8mb4_persian_ci');
            $table->string('FirstName',50)->collation('utf8mb4_persian_ci');
            $table->string('LastName',50)->collation('utf8mb4_persian_ci');
            $table->dateTime('CreateDate');
            $table->dateTime('LastLoginDate')->nullable(true);
            $table->integer('IncorrectPasswordCount')->nullable(true);
            $table->boolean('IsLockedOut');
            $table->boolean('IsDisabled');
            $table->boolean('IsAdmin');
            $table->string('ProfilePicture',8000)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidUser','PK_Users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
