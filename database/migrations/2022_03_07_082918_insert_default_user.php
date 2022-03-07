<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InsertDefaultUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('bank_users')->insert([
            'name' => 'Staff 01',
            'email' => "banker-staff01@aspiredev.com",
            'password' => Hash::make('1234@5678'),
            'remember_token' => Str::random(10)
        ]);

        DB::table('users')->insert([
            'name' => 'Harley',
            'email' => "harley@example.com",
            'password' => Hash::make('1234@5678'),
            'remember_token' => Str::random(10)
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('bank_users')->where('email', '=', 'banker-staff01@aspiredev.com')->delete();
        DB::table('users')->where('email', '=', 'harley@example.com')->delete();
    }
}
