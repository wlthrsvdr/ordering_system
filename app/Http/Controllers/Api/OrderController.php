<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Str, DB;

class OrderController extends Controller
{
    protected $response = [];
    protected $response_code;
    protected $guard = 'api';

    public function __construct()
    {
        $this->middleware('system.guest', ['except' => "logout"]);
    }

    public function show(Request $request)
    {
        $this->data['id'] = $request->get('id');
        $this->data['keyword'] = $request->get('keyword');
        $this->data['status'] = $request->get('status');


        $order = Order::where(function ($query) {
            if (strlen($this->data['id']) > 0) {
                return $query->where('order_by', $this->data['id']);
            }
        })
            ->where(function ($query) {
                if (strlen($this->data['status']) > 0) {
                    return $query->where('status', $this->data['status']);
                }
            })
            ->where(function ($query) {
                if (strlen($this->data['keyword']) > 0) {
                    return $query->whereRaw("LOWER(transaction_number)  LIKE  '{$this->data['keyword']}%'");
                }
            })
            ->orderBy('created_at', "DESC")
            ->get();


        $this->response['status'] = TRUE;
        $this->response['status_code'] = "ORDER_LIST";
        $this->response['msg'] = "Order informations.";
        $this->response['data'] = $order;
        $this->response_code = 200;

        callback:
        return response()->json($this->response, $this->response_code);
    }

    public function store(Request $request, $format = NULL)
    {

        $user = User::find($request->get('order_by'));

        if ($user->account_status == 'inactive') {
            $this->response['status'] = TRUE;
            $this->response['status_code'] = "FAILED_ORDER";
            $this->response['msg'] = "Blocked Account. Please contact administrator";
            $this->response_code = 401;

            goto callback;
        }


        DB::beginTransaction();
        try {

            $order = new Order;

            $order->order_by = $request->get('order_by');
            $order->order = $request->get('order');
            $order->total_amount = $request->get('total_amount');
            $order->status = 'unpaid';
            $order->save();

            $order->transaction_number = 'PLSP' . $this->codeGenerate() . $order->id;
            $order->save();

            DB::commit();

            $this->response['status'] = TRUE;
            $this->response['status_code'] = "ORDER_SUCCESS";
            $this->response['msg'] = "Success.";
            $this->response['data'] = $order;
            $this->response_code = 200;
        } catch (\Exception $e) {
            DB::rollback();


            $this->response['status'] = FALSE;
            $this->response['status_code'] = "SERVER_ERROR";
            $this->response['msg'] = "Server Error: Code #{$e->getMessage()}";
            $this->response_code = 500;
        }

        callback:
        switch (Str::lower($format)) {
            case 'json':
                return response()->json($this->response, $this->response_code);
                break;
            case 'xml':
                return response()->xml($this->response, $this->response_code);
                break;
        }
    }


    public function check_unpaid_order(Request $request, $format = NULL)
    {

        $order = Order::where('order_by', $request->get('order_by'))
            ->where('status', 'unpaid')
            ->get();

        if (count($order) >= 3) {
            $this->response['status'] = TRUE;
            $this->response['status_code'] = "UNPAID_ORDER";
            $this->response['msg'] = "You still have a 3 unpaid orders. Please settle first your unpaid order to administrator";
            $this->response['data'] = $order;
            $this->response_code = 401;

            goto callback;
        }

        $this->response['status'] = TRUE;
        $this->response['status_code'] = "SUCCESS";
        $this->response['msg'] = "Success.";
        // $this->response['data'] = $order;
        $this->response_code = 200;

        callback:
        switch (Str::lower($format)) {
            case 'json':
                return response()->json($this->response, $this->response_code);
                break;
            case 'xml':
                return response()->xml($this->response, $this->response_code);
                break;
        }
    }

    function codeGenerate()
    {
        $randCode  = (string)mt_rand(1000, 9999);
        $randChar  = rand(65, 90);
        $randInx   = rand(0, 3);
        $randCode[$randInx] = chr($randChar);
        return $randCode;
    }
}