<?php
namespace App\Http\Controllers;

use App\Models\Transfers;

use StarkBank\Transfer;
use StarkBank\Project;
use StarkBank\Settings;

use StarkBank\Webhook;
use Carbon\Carbon;

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


    public function createdWebhook()
    {
        $webhook = Webhook::create([
            "url" => env("STARKBANK_WEBHOOK_URL"),
            "subscriptions" =>
            [
                "transfer"
            ]
        ]);
    }

    public function webhookSavedHistoryAndStatus($transferId, $transferStatus)
    {
        $transfers = Transfers::where('transferId', $transferId)->first();

        if ($transfers && $transferId == $transfers['transferId']) {
            if ($transferStatus !== $transfers["transferStatus"]) {
                $transfers->transferStatus = $transferStatus;
                $transfers->updateHistory = Carbon::now();
                $transfers->save();
            }
        }
    }
}
