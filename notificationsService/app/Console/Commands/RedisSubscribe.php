<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use App\Models\User;


class RedisSubscribe extends Command
{
    protected $signature = 'redis:subscribe';

    protected $description = 'Subscribe to a Redis channel';

    public function handle(): void
    {
        echo("Listening for events...");
        echo("\n");

        while(true){

            // Keep subscription alive using loop

            try{
                Redis::subscribe('notify', function ($data) {
                    Log::info($data);
                    if($data != null){
                        $userData = json_decode($data);
                        $user = new User();
                        $user->firstName = $userData->firstName;
                        $user->lastName = $userData->lastName;
                        $user->email = $userData->email;
                        $user->save();
                        Log::info($user);
                        echo("\n");
                    }
                });
            }catch(\Exception $e){
                echo('Restarting subscription...');
                echo("\n");
            }
        }
    }
}
