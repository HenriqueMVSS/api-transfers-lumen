<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use StarkBank\Transfer;
use StarkBank\Project;
use StarkBank\Settings;

class TransferController extends Controller
{
    public function __construct() {
        $privateKeyContent = "
        -----BEGIN EC PRIVATE KEY-----
        MHQCAQEEIFzE9cS4LV6NeEGCE8P9QRWB9YCr0+MkncNJz7Vixp3UoAcGBSuBBAAK
        oUQDQgAEalGaJ1m9bMKSq8zIZX/2FQbJQw17s6L0TkUObvHxXaUwNw9OStkbP3vY
        w2WJG1ljOjU2hIB1OtCETHP+JEdAZQ==
        -----END EC PRIVATE KEY-----
        ";

        $user = new Project([
            "environment" => env('STARKBANK_ENVIRONMENT'),
            "id" => env('STARKBANK_ID'),
            "privateKey" => $privateKeyContent
        ]);
        Settings::setUser($user);
    }

    public function index()
    {
        $transfers = Transfer::query();
        return response()->json($transfers);

    }

    public function createTransfer(Request $request)
    {
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

        return response()->json($transfer, 201);
    }
}
