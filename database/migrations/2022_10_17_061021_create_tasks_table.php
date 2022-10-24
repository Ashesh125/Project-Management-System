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
            $table->unsignedBigInteger("project_id");   
            $table->unsignedBigInteger('assigned_to');
            $table->foreign('project_id')->references('id')->on('projects')->cascadeOnDelete(); 
            $table->foreign('assigned_to')->references('id')->on('users')->cascadeOnDelete(); 
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
    }
};
