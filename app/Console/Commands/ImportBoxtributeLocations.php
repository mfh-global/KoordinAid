<?php

namespace App\Console\Commands;

use App\Boxtribute\Importer\BoxtributeLocationImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportBoxtributeLocations extends Command
{  
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import-boxtribute-locations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync locations from boxtribute';

    public function __construct(private readonly BoxtributeLocationImporter $importer)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        Log::info("importing boxtribute locations and boxes...");
        $this->importer->import();
        Log::info("boxtribute locations and boxes imported");
        return 0;
    }

}
