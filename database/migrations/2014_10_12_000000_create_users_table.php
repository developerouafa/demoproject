<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nickname');
            $table->string('name');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('designation');
            $table->string('website');
            $table->string('phone');
            $table->string('address');
            $table->string('twitter');
            $table->string('facebook');
            $table->string('google');
            $table->string('linkedin');
            $table->string('github');
            $table->string('biographicalinfo');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('github_id', 200);
            $table->text('roles_name');
            $table->tinyInteger('UserStatus')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
