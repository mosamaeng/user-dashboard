<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usersData = json_decode(File::get(storage_path('data/users.json')));

        foreach ($usersData as $userData) {
            $user = new User([
                'name' => $userData->name,
                'avatar' => $userData->avatar ? 'https://mighty.tools/mockmind-api/content/human/' . $userData->id . '.jpg' : null, // S3 LINK ACCESS DENIED
                'id' => $userData->id,
                'occupation' => $userData->occupation,
                'email' => 'user' . $userData->id . 'gmail.com',
                'password' => bcrypt('password')
            ]);

            $user->save();
        }
    }
}
