<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{Topup, User};
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::guard('admin')->user();

        DB::beginTransaction();
        try {

            $student = User::find($request->get('userId'));
            $topup = new Topup;

            $student->e_money = (int)$student->e_money + (int)$request->get('amount');
            $student->save();

            if ($student) {
                $topup->topup_by = $user->id;
                $topup->topup_to = $request->get('userId');
                $topup->amount = $request->get('amount');
                $topup->save();

                $topup->transaction_number = 'PLSP' . $this->codeGenerate() . $topup->id;
                $topup->save();

                if ($topup) {
                    $topup->status = 'completed';
                    $topup->save();
                }
            }

            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Top up success.");
            return redirect()->route('admin.wallet.create');
        } catch (\Throwable $e) {
            DB::rollback();;
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Errorss: Code #{$e->getMessage()}");
            return redirect()->back();
        }
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

    function codeGenerate()
    {
        $randCode  = (string)mt_rand(1000, 9999);
        $randChar  = rand(65, 90);
        $randInx   = rand(0, 3);
        $randCode[$randInx] = chr($randChar);
        return $randCode;
    }
}
