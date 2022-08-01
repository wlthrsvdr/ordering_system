<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('name');
            $table->string('purok');
            $table->string('purpose');
            $table->string('email');
            $table->string('userId');
            $table->string('ref_no');
            $table->timestamp('issueDate');
            $table->string('is_completed');
            $table->string('is_approved')->default('0');
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
        Schema::dropIfExists('request');
    }
}
