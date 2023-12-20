<?php

namespace Database\Seeders;

use App\Models\Log;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logsData = json_decode(File::get(storage_path('data/logs.json')));

        foreach ($logsData as $logData) {
            if (!User::where('id', $logData->user_id)->exists()) {
                continue; // Skipping if user doesn't exist
            }

            $log = new Log([
                'user_id' => $logData->user_id,
                'time' => $logData->time,
                'type' => $logData->type,
                'revenue' => $logData->revenue,
            ]);

            $log->save();
        }
    }
}
