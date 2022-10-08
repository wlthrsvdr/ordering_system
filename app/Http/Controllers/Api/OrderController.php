<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\RegisteredRfid;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Str, DB, File;

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
        $this->data['order_status'] = $request->get('order_status');
        $this->data['payment_status'] = $request->get('payment_status');

        // $dirs = File::directories(public_path() . '/assets/contents');
        // $arr = [];

        // foreach ($dirs as  $value) {

        //     $grade_folder_dir = File::directories($value);

        //     foreach ($grade_folder_dir as  $grade_folder) {
        //         $grade_folder_files = File::allFiles($grade_folder);

        //         foreach ($grade_folder_files as $files) {
        //             $file_info = pathinfo($files);


        //             $col = collect([
        //                 'main_folder' => basename($value),
        //                 'grade_folder' => basename($grade_folder),
        //                 'filename' => $file_info['basename']
        //             ]);
        //             array_push($arr, $col);
        //         }
        //     }
        // }

        // $namelist = collect($arr)->groupBy(['grade_folder', 'main_folder']);
        // $this->response['status'] = TRUE;
        // $this->response['status_code'] = "FILE_LIST";
        // $this->response['msg'] = "File informations.";
        // $this->response['files'] = $namelist[$request->get('grade')];
        // $this->response_code = 200;

        $order = Order::where(function ($query) {
            if (strlen($this->data['payment_status']) > 0) {
                return $query->where('payment_status', $this->data['payment_status']);
            }
        })
            ->where(function ($query) {
                if ($this->data['id']) {
                    return $query->where('id', $this->data['id']);
                }
            })
            ->where(function ($query) {
                if (strlen($this->data['order_status']) > 0) {
                    return $query->where('order_status', $this->data['order_status']);
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

        $this->data['date']  = Carbon::now()->format("Y-m-d");

        if ($user->account_status == 'inactive') {
            $this->response['status'] = TRUE;
            $this->response['status_code'] = "FAILED_ORDER";
            $this->response['msg'] = "Blocked Account. Please contact administrator";
            $this->response_code = 401;

            goto callback;
        }

        $order_data = Order::where('order_status', '!=', 'completed')
            ->where(DB::raw("DATE(created_at)"), '>=', $this->data['date'])
            ->where(DB::raw("DATE(created_at)"), '<=', $this->data['date'])
            ->orderBy('created_at', "ASC")
            ->first();


        DB::beginTransaction();
        try {

            $order = new Order;

            $order->order_by = $request->get('order_by');
            $order->order_number = $order_data ? $order_data->order_number + 1 : 1;
            $order->order = $request->get('order');
            $order->total_amount = $request->get('total_amount');
            $order->order_status = 'pending';
            $order->payment_status = 'unpaid';
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
