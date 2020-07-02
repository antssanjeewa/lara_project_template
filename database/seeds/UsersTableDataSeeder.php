<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // $user = factory(User::class,100)->create();

        DB::table('users')->insert([
            [ 
                'name' => 'Super Admin',
                'mobile' => '0123456789',
                'email' => 'admin@smn.lk',
                'type' => 'staff',
                'password' => bcrypt('Admin#321'),
                'created_at' => Carbon::now()
            ]
            
        ]);
    }
}
