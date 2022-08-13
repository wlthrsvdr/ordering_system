<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductTableAddImagePathField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function ($table) {
            $table->string('image_filename')->nullable()->after('status');
            $table->string('image_directory')->nullable()->after('image_filename');
            $table->string('image_path')->nullable()->after('image_directory');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product', function ($table) {
            $table->dropColumn(['image_path', 'image_directory', 'image_filename']);
        });
    }
}
