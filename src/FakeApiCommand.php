<?php

namespace Araiyusuke\FakeApi;

use Illuminate\Console\Command;

class FakeApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'display:hello-world';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'hello-worldを出力します';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dump('さかな!!!');
    }
}
