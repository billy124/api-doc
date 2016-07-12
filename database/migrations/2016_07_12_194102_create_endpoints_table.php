<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEndpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endpoints', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned()->index();
            $table->string('title');
            $table->string('endpoint');
            $table->text('headers')->nullable();
            $table->string('method');
            $table->text('body')->nullable();
            $table->text('response')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('project_id')
                    ->references('id')->on('projects')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('endpoints');
    }
}
