<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labels', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('label_folder_id');
            $table->string('title', 30);
            $table->string('text', 50);
            $table->text('snippet')->nullable();
            $table->text('url')->nullable();
            $table->string('color', 20);
            $table->timestamps();

            $table->foreign('label_folder_id')->references('id')->on('label_folders')->onDelete('cascade')->onUpdate('cascade');


            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labels');
    }
}
