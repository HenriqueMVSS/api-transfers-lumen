<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\WebhookController;

use StarkBank\Transfer;
use StarkBank\Project;
use StarkBank\Settings;

class TransferController extends Controller
{
    private $webhookController;

    public function __construct(WebhookController $webhookController)
    {
        $this->webhookController = $webhookController;

        $user = new Project([
            "environment" => env('STARKBANK_ENVIRONMENT'),
            "id" => env('STARKBANK_ID'),
            "privateKey" => env('STARKBANK_PRIVATE_KEY')
        ]);
        Settings::setUser($user);
    }

    public function index()
    {
        $index = 0;
        $transfers = [];
        $allTransfers = Transfer::query([]);

        foreach($allTransfers as $transfer){
            $transfers[$index] = $transfer;
            $index++;
        }

        return response()->json($transfers);
    }

    public function getTransferById($id)
    {
        $transfer = Transfer::get($id);

        return response()->json($transfer);
    }

    public function createTransfer(Request $request)
    {
        $index = 0;
        $amount = $request->input('amount');
        $bankCode = $request->input('bankCode');
        $branchCode = $request->input('branchCode');
        $accountNumber = $request->input('accountNumber');
        $taxId = $request->input('taxId');
        $name = $request->input('name');

        $transfer = Transfer::create([
            new Transfer([
                'amount' => $amount,
                'bankCode' => $bankCode,
                'branchCode' => $branchCode,
                'accountNumber' => $accountNumber,
                'taxId' => $taxId,
                'name' => $name,
            ])
        ]);

        $transferId = $transfer[$index]->id;
        $transferStatus = $transfer[$index]->status;

        $this->webhookController->createWebhook($transferId, $transferStatus);

        return response()->json($transfer, 201);
    }
}
