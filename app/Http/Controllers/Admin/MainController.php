<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{Order, RegisteredRfid, User};

use Carbon\Carbon, DB;

class MainController extends Controller
{
    protected $data = array();
    protected $per_page;

    public function __construct()
    {
        parent::__construct();
        array_merge($this->data, parent::get_data());
        $this->data['page_title'] .= " :: Dashboard";
        $this->data['js'] = "Dashboard";
    }


    public function index()
    {
        $this->data['start_month'] = Carbon::now()->startOfMonth()->format("Y-m-d");
        $this->data['end_month'] = Carbon::now()->endOfMonth()->format("Y-m-d");
        $this->data['today_date'] = Carbon::now()->format("Y-m-d");

        $this->data['student_count'] = User::all()->where('user_role', 'customer')->count();
        $this->data['admin_count'] = User::all()->where('user_role', 'admin')->count();
        $this->data['personnel_count'] = User::all()->where('user_role', 'personnel')->count();

        $this->data['unpaid_order'] = Order::where('payment_status', 'unpaid')->count();
        $this->data['paid_order'] = Order::where('payment_status', 'paid')->count();
        $this->data['total_order'] = Order::get()->count();

        $this->data['montly_sales'] = Order::where('payment_status', 'paid')
            ->where(DB::raw("DATE(created_at)"), '>=', $this->data['start_month'])
            ->where(DB::raw("DATE(created_at)"), '<=', $this->data['end_month'])
            ->groupBy('payment_status')
            ->sum('total_amount');

        $this->data['daily_sales'] = Order::where('payment_status', 'paid')
            ->where(DB::raw("DATE(created_at)"), '>=', $this->data['today_date'])
            ->where(DB::raw("DATE(created_at)"), '<=', $this->data['today_date'])
            ->groupBy('payment_status')
            ->sum('total_amount');


        return view('admin.pages.dashboard', $this->data);
    }
}
