<?php

namespace App\Console\Commands\PrintQueues;

use App\Http\Controllers\ITPortal\PrintQueues\SSRSController;
use App\Library\MSTeams\Webhook;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class SSRSPrintQueueOverloadedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ssrs-print-queue-overloaded:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify IT Support if SSRS Print Queue has overloaded.';

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
     * @return void
     * @throws GuzzleException
     */
    public function handle()
    {
        $controller = new SSRSController();

        if ($controller->getThirtyMinCount() > 0) {

           Webhook::postMessage('SSRS Print Queue has overloaded.');
        }

    }
}
