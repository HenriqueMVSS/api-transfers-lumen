<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use StarkBank\Transfer;
use StarkBank\Settings;

class TransferController extends Controller
{
    public function __construct() {
        Settings::setUser(env('STARKBANK_USER'));
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
