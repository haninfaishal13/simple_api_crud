<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Aurum NF',
                'email' => 'aurumnf79@gmail.com',
                'password' => bcrypt('123456')
            ]
            ];
        foreach($data as $key => $value) {
            User::create($value);
        }
    }
}
