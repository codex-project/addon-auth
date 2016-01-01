<?php

namespace Codex\AuthHook\Console;

use Sebwite\Support\Command;

class AuthHookTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var  string
     */
    protected $signature = 'auth-hook:test';

    /**
     * The console command description.
     *
     * @var  string
     */
    protected $description = 'auth-hook test command';

    /**
     * Execute the console command.
     *
     * @return  mixed
     */
    public function handle()
    {
        $this->line('Test');
    }
}
