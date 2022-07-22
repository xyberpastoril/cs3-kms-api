<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->integer('category_id')->nullable();
            $table->integer('parent_answer_id')->nullable()->comment("In case a user seeks a follow-up question based from the answer given.");
            $table->integer('duplicate_question_id')->nullable()->comment("If a question is a duplicate of an existing question, then this will refer to it. Duplicate questions are hidden in search results.");
            $table->text('content');
            $table->uuid('update_token')->comment("This token is sent to the question owners email which gives him/her control to update/delete the question as long as the question does not have any answers yet.");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
