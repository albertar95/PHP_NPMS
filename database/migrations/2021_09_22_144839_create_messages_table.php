<?php

use Illuminate\Database\Console\Migrations\RefreshCommand;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->char('NidMessage',38)->collation('utf8mb4_persian_ci');
            $table->char('SenderId',38)->collation('utf8mb4_persian_ci');
            $table->char('RecieverId',38)->collation('utf8mb4_persian_ci');
            $table->char('RelateId',38)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('Title',200)->nullable(true)->collation('utf8mb4_persian_ci');
            $table->string('MessageContent',8000)->collation('utf8mb4_persian_ci');
            $table->boolean('IsRead');
            $table->boolean('IsRecieved');
            $table->boolean('IsDeleted');
            $table->dateTime('CreateDate');
            $table->dateTime('ReadDate')->nullable(true);
            $table->dateTime('DeleteDate')->nullable(true);
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidMessage','PK_Messages');
            $table->foreign('SenderId','FK_UserMessage')->references('NidUser')->on('Users');
            $table->foreign('RecieverId','FK_UserMessage2')->references('NidUser')->on('Users');
            $table->foreign('RelateId','FK_MessageMessage')->references('NidMessage')->on('Messages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
