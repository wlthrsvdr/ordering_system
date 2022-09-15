<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{User};
use DB, Str;

class WalletController extends Controller
{

    protected $data;
    protected $per_page;


    public function __construct()
    {
        $this->data['js'] = "Topup";
        $this->middleware('system.guest', ['except' => "logout"]);
    }

    public function index(Request $request)
    {

        $this->data['keyword'] = Str::lower($request->get('keyword'));
        $this->data['status'] = $request->get('status');

        $this->data['students'] = User::where('user_role', 'student')
            ->where(function ($query) {
                if (strlen($this->data['keyword']) > 0) {
                    return $query->whereRaw("firstname LIKE  UPPER('{$this->data['keyword']}%')")
                        ->orWhereRaw("LOWER(lastname)  LIKE  '{$this->data['keyword']}%'")
                        ->orWhereRaw("LOWER(email)  LIKE  '{$this->data['keyword']}%'")
                        ->orWhereRaw("LOWER(student_number)  LIKE  '{$this->data['keyword']}%'");
                }
            })
            ->where(function ($query) {
                if (strlen($this->data['status']) > 0) {
                    return $query->where('account_status', $this->data['status']);
                }
            })->orderBy('created_at', "DESC")
            ->paginate($this->per_page);

        return view('admin.pages.topup.index', $this->data);
    }


    public function topup(Request $request)
    {

        $this->data['auth'] = $request->user();

        return view('admin.pages.topup.create', $this->data);
    }



    public function store(Request $request)
    {
    }

    public function get_info(Request $request, $id = '')
    {
        // $user = User::find(1);

        $user = User::where('rfid', $id)->first();

        return $user;
        // if ($user) {
        //     return $user;
        // } else {
        //     session()->flash('notification-status', "failed");
        //     session()->flash('notification-msg', "Invalid Rfid");
        //     // return redirect()->back();
        // }
    }
}
