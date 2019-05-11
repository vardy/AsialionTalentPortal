<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->primary('id');

            $table->uuid('id');
            $table->string('user_id');

            $table->timestamps();

            $table->softDeletes();

            $table->decimal('total')->default(0.00);
            $table->string('invoice_number')->nullable();
            $table->integer('num_of_pos')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
