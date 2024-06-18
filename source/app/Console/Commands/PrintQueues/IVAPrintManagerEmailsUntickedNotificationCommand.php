<?php

namespace App\Console\Commands\PrintQueues;

use App\Http\Controllers\ITPortal\PrintQueues\IVADebtsolvController;
use App\Library\MSTeams\Webhook;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class IVAPrintManagerEmailsUntickedNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iva-print-manager-emails-unticked:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify IT Support if IVA Print Manager emails have been unticked.';

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
        $controller = new IVADebtsolvController();

        if (($controller->getLettersStatus() === 'green' ||
            $controller->getSMSsStatus() === 'green') &&
            $controller->getEmailsStatus() === 'emailsDown') {

            Webhook::postMessage('IVA Print Manager emails have been unticked.');
        }
    }
}
