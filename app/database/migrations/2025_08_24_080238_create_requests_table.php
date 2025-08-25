<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id');

            $table->text('content');                 // 依頼内容
            $table->string('tel', 15)->nullable(); // 数字のみ、最大15桁
            $table->string('email');                 // 既定で255
            $table->date('due_date')->nullable();    // ← 期日（時刻までなら dateTime）

            $table->tinyInteger('status')->default(0);   // 0:掲載中,1:進行中,2:完了
            $table->tinyInteger('del_flag')->default(0); // 0:通常,1:論理削除
            $table->timestamps();

            // 外部キー
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

            // 索引
            $table->index('user_id');
            $table->index('post_id');
            $table->index('status');
            $table->index('del_flag');
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
