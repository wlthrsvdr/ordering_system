<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exports\SalesReport;
use App\Models\Exports\ViewSalesReport;
use Illuminate\Http\Request;
use App\Models\{Category, Order, User};
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB, Str, Excel;

class ReportController extends Controller
{

    protected $data;
    protected $per_page;


    public function __construct()
    {
        $this->middleware('system.guest', ['except' => "logout"]);
        $this->data['js'] = "Report";
    }


    public function index(Request $request)
    {

        $this->data['status'] = Str::lower($request->get('status'));
        $this->data['start_date'] = Carbon::parse($request->get('start_date'))->format("Y-m-d");
        // $this->data['start_date'] = Carbon::now()->format("Y-m-d");
        $this->data['end_date'] = Carbon::now()->format("Y-m-d");

        $this->data['orders'] = Order::with('orderBy')
            ->where(function ($query) {
                if (strlen($this->data['status']) > 0) {
                    return $query->where('status', $this->data['status']);
                }
            })
            ->where(DB::raw("DATE(created_at)"), '>=', $this->data['start_date'])
            ->where(DB::raw("DATE(created_at)"), '<=', $this->data['end_date'])
            ->orderBy('created_at', "DESC")
            ->paginate($this->per_page);

        $this->data['grand_total'] = $this->data['orders']->sum('total_amount');
        $this->excel = new ViewSalesReport($this->data);
        session()->put('excelData', $this->excel->data);

        return view('admin.pages.report.index', $this->data);
    }

    public function generate_report(Request $request)
    {
        $this->data['status'] = Str::lower($request->get('status'));
        $this->data['start_date'] = Carbon::parse($request->get('start_date'))->format("Y-m-d");
        $this->data['end_date'] = Carbon::now()->format("Y-m-d");

        $this->data['orders'] = Order::with('orderBy')
            ->where(function ($query) {
                if (strlen($this->data['status']) > 0) {
                    return $query->where('status', $this->data['status']);
                }
            })
            ->where(DB::raw("DATE(created_at)"), '>=', $this->data['start_date'])
            ->where(DB::raw("DATE(created_at)"), '<=', $this->data['end_date'])
            ->orderBy('created_at', "DESC")
            ->get();

        $newData = session()->get('excelData');

        // dd($newData);

        return Excel::download(new ViewSalesReport($newData), "Sales - Report" . " " . "as of" . " "  . $newData['start_date'] .  " " . 'to' . " " . $newData['end_date'] . ".xlsx");
    }
}
