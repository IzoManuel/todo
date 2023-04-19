<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true)->constrained();
            $table->integer('task_id', false, true)->constrained();
            $table->timestamp('due_date', $precision = 0)->nullable();
            $table->timestamp('start_time', $precision = 0)->nullable();
            $table->timestamp('end_time', $precision = 0)->nullable();
            $table->string('remarks', 100)->nullable();
            $table->integer('status_id', false, true)->constrained();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);

            $table->unique(['user_id', 'task_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_user');
    }
};
