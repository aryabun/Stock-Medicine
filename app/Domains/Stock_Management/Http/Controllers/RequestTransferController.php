<?php

namespace App\Domains\Stock_Management\Http\Controllers;

use App\Domains\External\Models\ExternalAdmin;
use App\Domains\Internal\Models\InternalAdmin;
use App\Domains\Stock_Management\Http\Requests\ReqTransferRequest;
use App\Domains\Stock_Management\Models\ProductBox;
use App\Domains\Stock_Management\Models\ProductLot;
use App\Domains\Stock_Management\Models\Received;
use App\Domains\Stock_Management\Models\RequestTransfer;
use App\Domains\Stock_Management\Models\Transfer;
use App\Events\NewRequestNotification;
use App\Events\RequestApprovedNotification;
use App\Models\Enumeration\StateEnum;
use App\Notifications\ProductReceive;
use App\Notifications\RequestApproved;
use App\Notifications\RequestReject;
use App\Notifications\RequestSubmit;
use Arr;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Notification;

class RequestTransferController extends Controller
{
    Protected RequestTransfer $request_transfer;
    public function __construct(RequestTransfer $request_transfer)
    {
        # code...
        $this->request_transfer = $request_transfer;
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if($request->has('request_id')){
            $request_transfers  = $this->request_transfer
            ->where('request_id', $request->request_id)
            ->join('external_admins', 'external_admins.code', '=', 'request_transfers.user_id')
            ->join('warehouses', 'warehouses.warehouse_code', '=', 'request_transfers.to_warehouse')
            ->get()->load(['requested_products.products', 'approver']);
        }else{
            $request_transfers = $this->request_transfer
            ->join('external_admins', 'external_admins.code', '=', 'request_transfers.user_id')
            ->join('warehouses', 'warehouses.warehouse_code', '=', 'request_transfers.to_warehouse')
            ->with('requested_products.products')
            ->paginate(10);
        }
        return response()->json($request_transfers);
    }
    /**
     * Save a newly created resource in status 'DRAFT'.

     */
    public function store(ReqTransferRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $this->request_transfer->create([
                // 'request_id' => $id,
                'user_id' => $request->user_id,
                'from_warehouse' => $request->from_warehouse, 
                'to_warehouse' => $request->to_warehouse,
                'approved_by' => $request->approved_by,
                'approved_date' => $request->approved_date,
                'schedule_date' => $request->schedule_date,
                'eta' => $request->eta,
                'status' => StateEnum::TRANSFER_DRAFT,
            ]);
            // $this->request_transfer->requested_products()->attach($data->request_id);
            $data->requested_products()->createMany($request->input('products', []));
            return response()->json([
                'status' => 'success',
                'data' => $data->load(['requested_products']),
                'message' => __("Request Transfer :number successfully saved!", [
                    'number' => $data->request_id
                ])
            ]);
        });
    }
    /**
     * On button Submit
     */
    public function submit($request_id)
    {
        // Find Product ID
        $request_transfer = $this->request_transfer->findOrFail($request_id);
        if(Auth::guard('externalAdmin')->user()->code != $request_transfer->user_id){
            return response()->json([ 
                'status' => 'ERROR',
                'message' => __('Only Owner of the request can submit this request. Owner id: :id',['id' => $request_transfer->user_id]),
                'data' => Auth::guard('externalAdmin')->user()
            ]);
        }else{
            $request_transfer->update([
                'status' => StateEnum::TRANSFER_SUBMIT
            ]);
            $notify = InternalAdmin::where('code', 'IN001')->get();
            Notification::send($notify, new RequestSubmit($request_transfer));
            return response()->json([
                'status' => 'Success!',
                'data' => $request_transfer->load(['requested_products']),
                'message' => __(':id successfully submitted',['id' => $request_id])
            ]);
        }
    }
    /**
     * on Button Confirm = Approved
     */
    public function confirm(Request $request, $request_id)
    {
        // $this->middleware('internalAdmins');
        $request_transfer = $this->request_transfer->findOrFail($request_id);
        $notify = ExternalAdmin::where('code', $request_transfer->user_id)->get();
        $request_transfer->update([
            'approved_by' => Auth::guard('internalAdmin')->user()->code,
            'approved_date' => Carbon::now(),
            'status' => StateEnum::TRANSFER_APPROVED
        ]);
        // $notify->notify(new RequestApproved($request_transfer));
        Notification::send($notify, new RequestApproved($request_transfer));
        // RequestApprovedNotification::dispatch($request_transfer);
        return response()->json([
            'status' => 'Success!',
            'data' => $request_transfer->load(['requested_products']),
            'message' => __(':id has been approved by :approved_by',['id' => $request_id, 'approved_by' => $request_transfer->approved_by])
        ]);
    }
    public function reject(Request $request, $request_id)
    {
        // $this->middleware('internalAdmins');
        $request_transfer = $this->request_transfer->findOrFail($request_id);
        $notify = ExternalAdmin::where('code', $request_transfer->user_id)->get();
        $request_transfer->update([
            'rejected_by' => Auth::guard('internalAdmin')->user()->code,
            'rejected_date' => Carbon::now(),
            'status' => StateEnum::TRANSFER_REJECTED
        ]);
        // $notify->notify(new RequestReject($request_transfer));
        Notification::send($notify, new RequestReject($request_transfer));
        return response()->json([
            'status' => 'Success',
            'data' => $request_transfer->load(['requested_products']),
            'message' => __(':id has been rejected!',['id' => $request_id])
        ]);
    }
    /**
     * on Button Update Form before submit
     */
    public function update(ReqTransferRequest $request, $request_id)
    {
        //
        $request_transfer = $this->request_transfer->findOrFail($request_id);
        $request_transfer->update([
            // 'request_id' => $id,
            'user_id' => $request->user_id,
            'from_warehouse' => $request->from_warehouse, 
            'to_warehouse' => $request->to_warehouse,
            'approve_by' => $request->approve_by,
            'approve_date' => $request->approve_date,
            'schedule_date' => $request->schedule_date,
            'eta' => $request->eta,
            'status' => StateEnum::TRANSFER_DRAFT,
        ]);
         // sync requested products
         $excluded = collect($request->input('products', []))->filter(function ($item) {
            return !empty($item['id']);
        });
        $request_transfer->requested_products()->whereNotIn('id', $excluded->pluck('id'))->delete();
        foreach ($request->input('products', []) as $item) {
            $request_transfer->requested_products()->updateOrCreate(
                ['id' => data_get($item, 'id')],
                $item
            );
        }
        return response()->json([
            'status' => 'success',
            'data' => $request_transfer->load(['requested_products']),
            'message' => __("Request Transfer :number successfully saved!", [
                'number' => $request_transfer->request_id
            ])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($requestTransfer)
    {
        //
    }
    /**
     * RECEIVE STOCK STATUS DONE
     */
    public function receive($transfer_id){
        return DB::transaction(function () use ($transfer_id) {
            // 'price',
            $transfer = Transfer::findOrFail($transfer_id);
            $request_transfer = RequestTransfer::where('request_id', $transfer->request_id)->first();
            $lot = ProductLot::where('warehouse_code', $transfer->to_warehouse)->pluck('lot_code')->toArray();
            // return $lot;
            $data = Received::create([
                'transfer_id' => $transfer_id,
                'received_user' => Auth::guard('externalAdmin')->user()->code,
                'received_date' => Carbon::now(),
                'total_price'=> $transfer->total_price,
            ]);
            // UPDATE STATUS REQUEST
            $request_transfer->update([
                'received_by'=> $data->received_user,
                'received_date'=> $data->received_date,
                'received_ref' => $data->received_id,
                'status' => StateEnum::TRANSFER_DONE,
            ]);
            $transfer->update([
                'status' => StateEnum::TRANSFER_DONE,
            ]);
            // $this->request_transfer->requested_products()->attach($data->transfer_id);
            // $products = $transfer->trans_products->join('product_boxes', 'product_boxes.box_code', '=', 'transfer_products.box_code')
            //   ->get(['product_code', 'qty', 'unit', 'box_code', 'exp_date']);
            $array =$transfer->trans_products()->with('box')->get();
            $keys = [
                "product_code",
                "qty",
                "unit",
                "lot",
                "exp_date",
            ];
            $products = collect($array)->map(function ($row) use ($keys, $lot) {
                return [
                    $keys[0] => $row['product_code'],
                    $keys[1] => $row['qty'],
                    $keys[2] => $row['unit'],
                    $keys[3] => $row['lot']=collect(Arr::random($lot, 1))->implode(''),
                    $keys[4] => $row['box']['exp_date'] ?? '',
                ];
            });
            // return $products;
            $data->receive_products()->createMany($products);
            foreach( $products as $pro) {
                $product_attribute = ProductBox::create([
                    'product_code' => $pro['product_code'],
                    'lot_code' => $pro['lot'],
                    'exp_date' => $pro['exp_date'],
                    'bottle_qty' => $pro['qty']
                ]);
                // print_r($product_attribute);
            }
            $notify = InternalAdmin::where('code', 'IN001')->get();
            Notification::send($notify, new ProductReceive($request_transfer));
            return response()->json([
                'status' => 'Success!',
                'data' => $data->load(['receive_products']),
                'message' => __("Recieved Transfer No. :number! Find products at :lot", [
                    'number' => $data->transfer_id,
                    'lot' => $product_attribute->lot_code
                ])
            ]);
        });

    }
}
