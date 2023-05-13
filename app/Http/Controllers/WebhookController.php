<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use StarkBank\Webhook;
use StarkBank\Project;
use StarkBank\Settings;

class WebhookController extends Controller
{
    public function __construct()
    {
        $user = new Project([
            "environment" => env('STARKBANK_ENVIRONMENT'),
            "id" => env('STARKBANK_ID'),
            "privateKey" => env('STARKBANK_PRIVATE_KEY')
        ]);
        Settings::setUser($user);
    }

    public function createWebhook($transferId, $transferStatus)
    {
        $webhookUrl = "https://winterfell.westeros.gov/starkbanks/";

        $webhook = Webhook::create([
            'url' => $webhookUrl,
            'subscriptions' => [
                "transfer"
            ],
        ]);

        $this->getWebhooks();
    }

    public function getWebhooks()
    {
        $index = 0;
        $webhooks = [];
        $allWebhooks = Webhook::query();

        foreach($allWebhooks as $webhook) {
            $webhooks[$index] = $webhook;
            $index++;
        }

        return response()->json($webhooks);
    }

    public function getWebhookById($id)
    {
        $webhook = Webhook::get($id);

        return response()->json($webhook);
    }
}
