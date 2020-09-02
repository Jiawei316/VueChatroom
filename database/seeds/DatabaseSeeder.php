<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Friend;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'test1',
            'account' => 'test1',
            'password' => \Illuminate\Support\Facades\Hash::make('1234'),
            'api_token' => \Illuminate\Support\Str::random(80)
        ]);

        User::create([
            'username' => 'test2',
            'account' => 'test2',
            'password' => \Illuminate\Support\Facades\Hash::make('1234'),
            'api_token' => \Illuminate\Support\Str::random(80)
        ]);

        User::create([
            'username' => 'test3',
            'account' => 'test3',
            'password' => \Illuminate\Support\Facades\Hash::make('1234'),
            'api_token' => \Illuminate\Support\Str::random(80)
        ]);

        // No.1 Send Friend to No.2
        Friend::create([
            'self_index' => 1,
            'friend_index' => 2
        ]);

        // No.1 Send Friend to No.3
        Friend::create([
            'self_index' => 1,
            'friend_index' => 3
        ]);

        // No.2 Send Friend to No.3
        Friend::create([
            'self_index' => 2,
            'friend_index' => 3
        ]);

        // No.3 Send Friend to No.2
        Friend::create([
            'self_index' => 3,
            'friend_index' => 2
        ]);
    }
}
