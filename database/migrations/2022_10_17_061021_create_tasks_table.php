<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->date("due_date");
            $table->boolean("status")->default(0);
            $table->string("description");
            $table->enum('type', ['assigned', 'ongoing','completed']);
            $table->integer('priority')->default(0);
            $table->unsignedBigInteger("activity_id");
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('activity_id')->references('id')->on('activities')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
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
       Schema::dropIfExists('tasks');
    }
};
