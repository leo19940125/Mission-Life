<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->text('description');
            $table->integer('price');
            $table->integer('quantity');
            $table->boolean('status');
            $table->integer('catalog');
            $table->string('pic_path')->default('0');
             $table->string('pic_path')->default('default_img.jpg')->change();
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
        Schema::drop('item');
        $table->string('picture_path')->default('0')->change();
    }
}
