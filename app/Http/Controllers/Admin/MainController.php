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

        $this->data['student_count'] = RegisteredRfid::all()->count();
        $this->data['admin_count'] = User::all()->where('user_role', 'admin')->count();
        $this->data['personnel_count'] = User::all()->where('user_role', 'personnel')->count();

        $this->data['unpaid_order'] = Order::where('status', 'unpaid')->count();
        $this->data['paid_order'] = Order::where('status', 'paid')->count();
        $this->data['total_order'] = Order::get()->count();

        $this->data['montly_sales'] = Order::where('status', 'paid')
            ->where(DB::raw("DATE(created_at)"), '>=', $this->data['start_month'])
            ->where(DB::raw("DATE(created_at)"), '<=', $this->data['end_month'])
            ->groupBy('status')
            ->sum('total_amount');

        $this->data['daily_sales'] = Order::where('status', 'paid')
            ->where(DB::raw("DATE(created_at)"), '>=', $this->data['today_date'])
            ->where(DB::raw("DATE(created_at)"), '<=', $this->data['today_date'])
            ->groupBy('status')
            ->sum('total_amount');


        // $this->data['school_youth'] = Profiles::where('resident_type', 'school_youth')->count();
        // $this->data['senior_citizen'] = Profiles::where('resident_type', 'senior_citizen')->count();
        // $this->data['pwd'] = Profiles::where('resident_type', 'pwd')->count();

        return view('admin.pages.dashboard', $this->data);
    }
}
