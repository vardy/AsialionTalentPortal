<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->primary('id');

            $table->uuid('id');
            $table->string('invoice_id');

            $table->timestamps();

            $table->softDeletes();

            $table->string('file_name');
            $table->string('original_file_name');
            $table->string('file_size');
            $table->string('file_extension');
            $table->string('file_mime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
