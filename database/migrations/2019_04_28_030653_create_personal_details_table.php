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

            $table->mediumText('first_name')->nullable(); // Required
            $table->mediumText('last_name')->nullable(); // Required
            $table->mediumText('email')->nullable(); // Required
            $table->mediumText('skype_id')->nullable();

            $table->mediumText('country_of_residence')->nullable(); // Required
            $table->mediumText('mobile_number')->nullable(); // Required
            $table->mediumText('home_number')->nullable();

            $table->mediumText('highest_education')->nullable(); // Required
            $table->mediumText('professional_experience')->nullable(); // Required
            $table->mediumText('industry_experience')->nullable(); // Required
            $table->mediumText('language_pairs')->nullable(); // Required
            $table->mediumText('tools')->nullable();
            $table->mediumText('turnaround_per_day')->nullable();

            // Permanent positions
            $table->mediumText('latest_remuneration')->nullable();
            $table->mediumText('expected_remuneration')->nullable();

            // Freelancers
            $table->mediumText('translation_rate')->nullable();
            $table->mediumText('editing_rate')->nullable();
            $table->mediumText('transcription_rate')->nullable();
            $table->mediumText('hourly_rate')->nullable();
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
