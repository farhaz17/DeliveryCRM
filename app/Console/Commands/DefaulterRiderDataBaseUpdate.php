<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\AssingToDc\AssignToDc;
use App\Model\Riders\DefaulterRiders\DefaulterRider;

class DefaulterRiderDataBaseUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DataBase:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is a temporary command. should removed after first execution';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Nothing changed");
    }
}
