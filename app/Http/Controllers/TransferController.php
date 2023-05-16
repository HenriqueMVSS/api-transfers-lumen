<?php
namespace App\Http\Controllers;

use App\Models\Transfers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use League\Flysystem\AwsS3V3\PortableVisibilityConverter;

use StarkBank\Transfer;
use StarkBank\Project;
use StarkBank\Settings;

class TransferController extends Controller
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

    public function index()
    {
        $index = 0;
        $transfers = [];
        $allTransfers = Transfer::query([]);

        foreach($allTransfers as $transfer) {
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

        if ($transfer[$index]->status !== 'created') {
            response()->json(['error' => 'Transfer failed'], 500);
            return redirect(env('ENDPOINT_URL'));
        }

        $pdf = $this->getTransferPdf($transfer[$index]->id);
        $pdfFilename = $this->generatePdfFilename();
        Storage::disk('s3')->put($pdfFilename, $pdf);

        $transfers = new Transfers();
        $transfers->transferId = $transfer[$index]->id;
        $transfers->transferStatus = $transfer[$index]->status;
        $transfers->updateHistory = $transfer[$index]->updated;
        $transfers->pdfUrl = Storage::disk('s3')->url($pdfFilename);
        $transfers->save();

        response()->json(['message' => 'Payment created successfully']);

        return redirect(env('ENDPOINT_URL'));
    }

    public function getTransferPdf($transferId)
    {
        $pdf = Transfer::pdf($transferId);
        return $pdf;
    }

    public function generatePdfFilename()
    {
        $pdfFilename = 'transfer_' . time() . '_' . uniqid() . '.pdf';
        return $pdfFilename;
    }
}
