<?php

namespace App\Domains\Stock_Management\Http\Controllers;

use App\Domains\Stock_Management\Models\DashboardModel;
use App\Domains\Stock_Management\Models\RequestTransfer;
use App\Domains\Stock_Management\Models\Transfer;
use App\Models\Enumeration\StateEnum;
use Illuminate\Http\Request;

class DashboardController
{
    //
    public function index(DashboardModel $dashboard)
    {
        $data = [
            'requestTransferTotal' => RequestTransfer::count(),
            'requestTransferSubmit' => RequestTransfer::where('status',StateEnum::TRANSFER_SUBMIT)->count(),
            'transferTotal' => Transfer::count(),
            'transferDone' => Transfer::where('status',StateEnum::TRANSFER_DONE)->count(),
            'transferTransit' => Transfer::where('status', StateEnum::TRANSFER_TRANSIT)->count(),
            'requestWeekly' => $dashboard->getTotalWeeklyRequest()->take(10)->get(),
            'transferWeekly' => $dashboard->getTotalWeeklyDelivery()->take(10)->get(),
        ];

        return response()->json($data);
    }
}
