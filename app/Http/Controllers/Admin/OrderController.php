<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{Category, Order, User};
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB, Str;

class OrderController extends Controller
{

    protected $data;
    protected $per_page;


    public function __construct()
    {
        $this->middleware('system.guest', ['except' => "logout"]);
        $this->data['js'] = "Order";
    }


    public function index(Request $request)
    {

        $this->data['keyword'] = Str::lower($request->get('keyword'));
        $this->data['status'] = Str::lower($request->get('status'));
        $this->data['start_date'] = Carbon::parse($request->get('start_date'))->format("Y-m-d");
        // $this->data['start_date'] = Carbon::now()->format("Y-m-d");
        $this->data['end_date'] = Carbon::now()->format("Y-m-d");

        $this->data['orders'] = Order::with('orderBy')
            ->where(function ($query) {
                if (strlen($this->data['keyword']) > 0) {
                    return $query->whereRaw("transaction_number LIKE  UPPER('{$this->data['keyword']}%')");
                }
            })
            ->where(function ($query) {
                if (strlen($this->data['status']) > 0) {
                    return $query->where('status', $this->data['status']);
                }
            })
            ->where(DB::raw("DATE(created_at)"), '>=', $this->data['start_date'])
            ->where(DB::raw("DATE(created_at)"), '<=', $this->data['end_date'])
            ->orderBy('created_at', "DESC")
            ->paginate($this->per_page);


        return view('admin.pages.order.index', $this->data);
    }


    public function rfid_pay(Request $request)
    {

        $check_balance = User::where('rfid', $request->get('card'))->first();
        $order_info = Order::find($request->get('orderId'));


        if (!$check_balance) {
            $this->data['msg'] = "Invalid Card. Please contact the administrator.";
            $this->data['status_code'] = 401;
        } else {
            if ($check_balance->e_money < $order_info->total_amount) {
                $this->data['msg'] = "Insufficient Balance. Please reload first";
                $this->data['status_code'] = 401;
            } else {
                $check_balance->e_money = $check_balance->e_money -  $order_info->total_amount;
                $check_balance->save();

                $order_info->status = "paid";
                $order_info->save();

                $this->data['msg'] = "Payment success.";
                $this->data['status_code'] = 200;
            }
        }


        return $this->data;
    }
}