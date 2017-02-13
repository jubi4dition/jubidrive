<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        $this->call(UsersTableSeeder::class);
        $this->command->info('User table seeded!');
         
    }
}

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        
        $user = App\User::create(array(
            'username' => 'username',
            'password' => Hash::make('password'),
            'fullname' => 'Mikel Curtin',
            'foldername' => md5(1)
        ));
        
        $user = App\User::create(array(
            'username' => 'username2',
            'password' => Hash::make('password'),
            'fullname' => 'Michal Zehr',
            'foldername' => md5(2)
        ));
        
        $user = App\User::create(array(
            'username' => 'username3',
            'password' => Hash::make('password'),
            'fullname' => 'Justin Laubach',
            'foldername' => md5(3)
        ));
    }
}
