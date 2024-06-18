<?php

namespace App\Library\MSTeams;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class Webhook
{

    /**
     * @throws GuzzleException
     */
    public static function postMessage(string $message)
    {
        if($webhook = config('services.msteams.webhook','')) {
            $client = new Client();
            $client->request('POST', $webhook, [
                RequestOptions::JSON => ['text' => $message]
            ]);
        }
    }

}
