<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topup', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->nullable();
            $table->string('topup_by')->nullable();
            $table->decimal('amount', 25, 2)->default("0.00")->nullable();
            $table->string('topup_to')->nullable();
            $table->string('status')->default('paid');
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
        Schema::dropIfExists('topup');
    }
}
