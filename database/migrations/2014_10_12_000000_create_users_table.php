<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('name');
            $table->string('password')->default('root');
            $table->tinyInteger('rule')->default(0);
            $table->timestamps();
        });
        DB::insert('insert into `users` (`name`, `password`, `rule`, `created_at`) values (?, ?, ?, ?)',
            ['admin', Hash::make('admin'),  1, date('Y-m-d H:i:s')]);
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
}
