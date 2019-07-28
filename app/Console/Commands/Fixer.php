<?php

namespace App\Console\Commands;

use Helper;
use Illuminate\Console\Command;

class Fixer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fixer {args}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show exchange rates';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo $args = $this->argument('args') . "\n";
        $arr       = explode('/', $args);
        echo Helper::getExchangeRate($arr[0], $arr[1]) . "\n";
    }
}
