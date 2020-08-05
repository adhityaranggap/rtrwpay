<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserHasSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_subscription', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('subscription_id');
            $table->enum('status', ['active','inactive'])->default('active');            
            $table->text('notes')->nullable();     
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
        Schema::dropIfExists('user_has_subscription');
    }
}
