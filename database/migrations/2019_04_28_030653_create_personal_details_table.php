<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_details', function (Blueprint $table) {
            $table->primary('id');

            $table->uuid('id');
            $table->string('user_id');

            $table->timestamps();

            $table->softDeletes();

            $table->mediumText('first_name')->nullable(); // Required
            $table->mediumText('last_name')->nullable(); // Required
            $table->mediumText('email')->nullable(); // Required
            $table->mediumText('skype_id')->nullable();
            $table->mediumText('qq')->nullable();
            $table->mediumText('linkedin')->nullable();

            $table->mediumText('country_of_residence')->nullable(); // Required
            $table->mediumText('mobile_number')->nullable(); // Required
            $table->mediumText('home_number')->nullable();

            $table->mediumText('highest_education')->nullable(); // Required
            $table->mediumText('work_experience')->nullable(); // Required
            $table->mediumText('industry_specialization')->nullable(); // Required
            $table->mediumText('language_pairs')->nullable(); // Required
            $table->mediumText('tools')->nullable();
            $table->mediumText('turnaround_per_day')->nullable();

            $table->mediumText('currency_used')->nullable(); // Required

            $table->mediumText('translation_rate')->nullable();
            $table->mediumText('editing_rate')->nullable();
            $table->mediumText('transcription_rate')->nullable();
            $table->mediumText('hourly_rate')->nullable();

            $table->mediumText('account_name')->nullable(); // Required
            $table->mediumText('account_number')->nullable(); // Required
            $table->mediumText('bank_name')->nullable(); // Required
            $table->mediumText('bank_address')->nullable(); // Required
            $table->mediumText('swift_code')->nullable(); // Required
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_details');
    }
}
