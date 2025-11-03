<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {

        DB::table('users')->insert([
            [
                'name' => 'Marco Antônio',
                'email' => 'Tarzan@hotmail.com.br',
                'role' => 'admin',
                'status' => 'active',
                'password' => bcrypt('87654321'),
            ],
            [
                'name' => 'Gabriel Henrique',
                'email' => 'Zion@gmail.com.br',
                'role' => 'admin',
                'status' => 'active',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'Pedro Henrique',
                'email' => 'Pedro@outlook.com.br',
                'role' => 'admin',
                'status' => 'active',
                'password' => bcrypt('PXingu1234'),
            ],
            [
                'name' => 'Diogo Rodrigues',
                'email' => 'Admin@gmail.com.br',
                'role' => 'admin',
                'status' => 'active',
                'password' => bcrypt('123456789'),
            ],
            [
                'name' => 'Carreteiro Carlos',
                'email' => 'Vendor@gmail.com.br',
                'role' => 'vendor',
                'status' => 'active',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'Gleison Brito',
                'email' => 'user@gmail.com.br',
                'role' => 'user',
                'status' => 'active',
                'password' => bcrypt('password123'),
            ],
        ]);
    }
}
