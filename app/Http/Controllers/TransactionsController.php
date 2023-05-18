<?php
namespace App\Http\Controllers;

use App\Http\Controllers\TransferController;

use Illuminate\Http\Request;

use StarkBank\Project;
use StarkBank\Settings;

class TransactionsController extends Controller
{
    private $transfers;

    public function __construct(TransferController $transferController)
    {
        $this->transfers = $transferController;

        $user = new Project([
            "environment" => env('STARKBANK_ENVIRONMENT'),
            "id" => env('STARKBANK_ID'),
            "privateKey" => env('STARKBANK_PRIVATE_KEY')
        ]);

        Settings::setUser($user);
    }

    public function index()
    {
        $allTransfers = $this->transfers->index();

        return $allTransfers;
    }

    public function getTransferById($id)
    {
        $transferById = $this->transfers->getTransferById($id);

        return $transferById;
    }

    public function createTransfer(Request $request)
    {
        $createdTransfer = $this->transfers->createTransfer($request);

        return $createdTransfer;
    }

}
