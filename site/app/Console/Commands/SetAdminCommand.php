<?php

namespace App\Console\Commands;

use App\Models\Dictionaries\CharacterNationDictionary;
use App\Models\User;
use Illuminate\Console\Command;

class SetAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:gm {login}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::firstWhere('ID', $this->argument('login'));

        if ($user && $user->characters->count()) {
            $user->characters()->update(['Nation' => CharacterNationDictionary::GM]);

            echo "User {$this->argument('user')} set GM" . PHP_EOL;
        } else {
            echo "User not found or doesn't exist characters" . PHP_EOL;
        }
    }
}
