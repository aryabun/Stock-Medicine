<?php

namespace App\Domains\Stock_Management\Http\Controllers;

use App\Domains\External\Models\ExternalAdmin;
use App\Domains\Stock_Management\Http\Requests\TransRequest;
use App\Domains\Stock_Management\Models\ProductBox;
use App\Domains\Stock_Management\Models\RequestTransfer;
use App\Domains\Stock_Management\Models\Transfer;
use App\Models\Enumeration\StateEnum;
use App\Notifications\RequestTransit;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Notification;

class TransferController extends Controller
{
    Protected Transfer $transfer;
    public function __construct(Transfer $transfer)
    {
        # code...
        $this->transfer = $transfer;
        // $this->middleware('auth:internalAdmin');
        // $this->middleware('auth:externalAdmin');
        
    }
    //SHOW ALL TRANSFER HISTORY
    public function index(Request $request)
    {
        # code...
        if($request->has('transfer_id')){
            return $this->transfer->where('transfer_id', $request->transfer_id)
            ->join('external_admins', 'external_admins.code', '=', 'transfers.contact_id')
            ->join('warehouses', 'warehouses.warehouse_code', '=', 'transfers.to_warehouse')
            ->get()->load(['trans_products.product', 'approver']);
        }else{
            return response()->json(Transfer::with('trans_products.product')->paginate());
        }
    }

    // DOING TRANSFER AFTER APPROVED REQUEST
    public function transfer(TransRequest $request, $request_id)
    {
        $req_transfer = RequestTransfer::findOrFail($request_id);
        $data = $this->transfer->create([
            // 'request_id' => $id,
            'request_id' => $request_id,
            'contact_id' => $req_transfer->user_id,
            'from_warehouse' => $req_transfer->from_warehouse,
            'to_warehouse' => $request->to_warehouse,
            'approved_by' => $request->approved_by,
            'approved_date' => $request->approved_date,
            'schedule_date' => $request->schedule_date,
            'eta' => $request->eta,
            'total_price' => $request->total_price,
            'status' => StateEnum::TRANSFER_TRANSIT,
        ]);
        // UPDATE STATUS REQUEST
        $req_transfer->update([
            'transfer_ref' => $data->transfer_id,
            'schedule_date' => $data->schedule_date,
            'eta' => $data->eta,
            'status' => StateEnum::TRANSFER_TRANSIT
        ]);
        // $this->request_transfer->requested_products()->attach($data->transfer_id);
        $input_data = $data->trans_products()->createMany($request->input('products', []));
        foreach( $input_data as $pro) {
            ProductBox::find($pro->box_code)->decrement('bottle_qty', $pro->qty);
            // print_r($product_attribute);
        }
        // $notify = ExternalAdmin::where('code', $req_transfer->user_id)->get();
        // Notification::send($notify, new RequestTransit($req_transfer));
        return response()->json([
            'status' => 'Success!',
            'data' => $data->load(['trans_products']),
            'message' => __("Transfer :number successfully made! Request Transfer :id is in status :status", [
                'number' => $data->transfer_id,
                'id' => $data->request_id,
                'status' => $data->status
                ])
            ]);
        // });
        // return DB::transaction(function () use ($request, $request_id) {
        //     // 'price',

    }
}
