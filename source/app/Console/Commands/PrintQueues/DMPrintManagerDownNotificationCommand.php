<?php

namespace App\Console\Commands\PrintQueues;

use App\Http\Controllers\ITPortal\PrintQueues\DMDebtsolvController;
use App\Library\MSTeams\Webhook;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class DMPrintManagerDownNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dm-print-manager-down:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify IT Support if DM Print Manager is down.';

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
     * @throws GuzzleException
     */
    public function handle()
    {
        $controller = new DMDebtsolvController();

        if ($controller->getLettersStatus() === 'red' &&
            ($controller->getEmailsStatus() === 'red' || $controller->getEmailsStatus() === 'emailsDown') &&
            $controller->getSMSsStatus() === 'red') {

            Webhook::postMessage('DM Print Manager is down.');
        }


    }
}
