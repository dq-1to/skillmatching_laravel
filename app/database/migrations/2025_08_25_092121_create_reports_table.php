<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $t) {
            $t->bigIncrements('id');
            $t->unsignedBigInteger('reporter_id'); // 通報者
            $t->unsignedBigInteger('post_id');     // 対象投稿
            $t->text('reason');                    // 通報理由
            // $t->tinyInteger('status')->default(0); // 0:受付,1:調査中,2:対応完了
            $t->tinyInteger('status')->default(0); // 0:報告済, 1:対応完了
            $t->tinyInteger('del_flag')->default(0);
            $t->timestamps();

            $t->foreign('reporter_id')->references('id')->on('users')->onDelete('cascade');
            $t->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $t->index(['post_id','status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
