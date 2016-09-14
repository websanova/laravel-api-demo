<?php

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $t)
        {
            $t->increments('id')->unsigned();
            $t->string('username', 255)->nullable()->unique();
            $t->string('password', 127);
            $t->enum('role', ['user', 'admin'])->index();
            $t->timestamps();
        });

        $user = new User;
        $user->username = 'admin';
        $user->password = \Hash::make('secret');
        $user->role = 'admin';
        $user->save();

        $user = new User;
        $user->username = 'social';
        $user->password = \Hash::make('secret');
        $user->role = 'user';
        $user->save();

        $user = new User;
        $user->username = 'test';
        $user->password = \Hash::make('secret');
        $user->role = 'user';
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
