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

            $table->string('first_name')->nullable(); // Required
            $table->string('last_name')->nullable(); // Required
            $table->string('email')->nullable(); // Required
            $table->string('skype_id')->nullable();

            $table->string('country_of_residence')->nullable(); // Required
            $table->string('mobile_number')->nullable(); // Required
            $table->string('home_number')->nullable();

            $table->string('highest_education')->nullable(); // Required
            $table->string('professional_experience')->nullable(); // Required
            $table->string('industry_experience')->nullable(); // Required
            $table->string('language_pairs')->nullable(); // Required
            $table->string('tools')->nullable();
            $table->string('turnaround_per_day')->nullable();

            // Permanent positions
            $table->string('latest_remuneration')->nullable();
            $table->string('expected_remuneration')->nullable();

            // Freelancers
            $table->string('translation_rate')->nullable();
            $table->string('editing_rate')->nullable();
            $table->string('transcription_rate')->nullable();
            $table->string('hourly_rate')->nullable();
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
