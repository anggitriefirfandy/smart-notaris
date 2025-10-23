<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;
use Hash;
use Illuminate\Database\Seeder;
use Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name'     => 'admin',
            'uid'      => Str::uuid(),
            'email'    => 'admin@gmail.com',
            'role_id'  => 0,
            'password' => Hash::make('1234567890'),
        ]);
    }
}
