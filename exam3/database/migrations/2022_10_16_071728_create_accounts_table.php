<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('amount')->default(0)->comment('額度');
            $table->integer('balance')->default(0)->comment('餘額');
            $table->text('description')->nullable()->comment('描述');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE `accounts` comment '會員帳戶'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
