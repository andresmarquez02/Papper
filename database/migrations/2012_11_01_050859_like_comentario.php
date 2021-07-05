<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LikeComentario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like_comentario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('like', 2)->default('SI');
            $table->bigInteger('id_pregunta');
            $table->bigInteger('id_admin');
            $table->bigInteger('id_comentario');
            $table->bigInteger('id_user_admin_comentario');
            $table->bigInteger('id_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('like_comentario');
    }
}
