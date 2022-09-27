<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{Category, Order, RegisteredRfid, User};
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
        // dd($this->data['orders']);

        return view('admin.pages.order.index', $this->data);
    }

    public function update_order_status(Request $request, $id)
    {
        $status = '';

        DB::beginTransaction();
        try {
            $order = Order::where('id', $id)->first();

            switch ($order->order_status) {
                case 'pending':
                    $status = 'preparing';
                    break;
                case 'preparing':
                    $status = 'prepared';
                    break;
                default:
                    # code...
                    break;
            }

            $order->order_status = $status;
            $order->save();

            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Update order status successfully.");
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Errorss: Code #{$e->getMessage()}");
            return redirect()->back();
        }
    }



    public function rfid_pay(Request $request)
    {

        $check_balance = User::where('rfid_number', $request->get('card'))->first();
        $order_info = Order::find($request->get('orderId'));

        if ($check_balance->card_status == 'inactive') {
            $this->data['msg'] = "Inactive Card. Please contact the administrator.";
            $this->data['status_code'] = 401;

            return $this->data;
        }

        if (!$check_balance) {
            $this->data['msg'] = "Invalid Card. Please contact the administrator.";
            $this->data['status_code'] = 401;
        } else {
            if ($check_balance->e_money < $order_info->total_amount) {
                $this->data['msg'] = "Insufficient Balance. Please reload first";
                $this->data['status_code'] = 401;
            } else {
                $check_balance->e_money = (int)$check_balance->e_money -  (int)$order_info->total_amount;
                $check_balance->save();

                $order_info->payment_status = "paid";
                $order_info->order_status = "completed";
                $order_info->paid_by =  $check_balance->id;
                $order_info->save();

                $this->data['msg'] = "Payment success.";
                $this->data['status_code'] = 200;
            }
        }


        return $this->data;
    }
}
