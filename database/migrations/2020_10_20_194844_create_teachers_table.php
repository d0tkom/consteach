<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->json('teaching_languages')->nullable();
            $table->json('about_me');
            $table->string('country');
            $table->string('video_url');
            $table->float('one_hour_price');
            $table->float('five_hour_price');
            $table->float('ten_hour_price');
            $table->float('twenty_hour_price');
            $table->string('stripe_token')->nullable();
            $table->boolean('finished_onboarding')->default(false);
            $table->boolean('complete')->default(false);
            $table->boolean('validated')->default(false);
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('teachers');
    }
}
