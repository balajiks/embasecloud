<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration auto-generated by Sequel Pro Laravel Export
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 32)->unique();
            $table->string('subject')->nullable();
            $table->longText('body')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('department')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('priority')->default(3);
            $table->timestamp('due_date')->nullable();
            $table->tinyInteger('is_locked')->default(0);
            $table->integer('locked_by')->nullable();
            $table->timestamp('locked_time')->useCurrent();
            $table->tinyInteger('rated')->default(0);
            $table->tinyInteger('feedback_disabled')->default(0);
            $table->dateTime('closed_at')->nullable();
            $table->integer('closed_by')->nullable();
            $table->string('token')->nullable();
            $table->integer('assignee')->nullable();
            $table->integer('resolution_time')->default(0);
            $table->timestamp('archived_at')->nullable();
            $table->decimal('todo_percent', 10, 2)->default(0.00);
            $table->softDeletes();
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
        Schema::dropIfExists('tickets');
    }
}