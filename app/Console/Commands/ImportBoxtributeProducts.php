<?php

namespace App\Console\Commands;

use App\Boxtribute\Importer\BoxtributeProductImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class importBoxtributeProducts extends Command
{  
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import-boxtribute-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync products from boxtribute';

    public function __construct(private readonly BoxtributeProductImporter $importer)
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
        Log::info("importing boxtribute products...");
        $this->importer->import();
        Log::info("boxtribute products imported");
        return 0;
    }

}
