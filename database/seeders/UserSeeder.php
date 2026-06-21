<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        $cek = DB::table('users')
        ->where('role','superadmin')
        ->count();

        if($cek == 0){

            DB::table('users')->insert([
                'nama'=>'Super Admin',
                'email'=>'superadmin@gmail.com',
                'password'=>Hash::make('superadmin123'),
                'role'=>'superadmin',
                'created_at'=>now(),
                'updated_at'=>now()
            ]);

        }

    }
}