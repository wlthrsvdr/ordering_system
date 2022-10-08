<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{RegisteredRfid, Topup, User};
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

        // $this->data['data'] = RegisteredRfid::where(function ($query) {
        //     if (strlen($this->data['keyword']) > 0) {
        //         return $query->whereRaw("name LIKE  UPPER('{$this->data['keyword']}%')");
        //     }
        // })->orderBy('created_at', "DESC")
        //     ->paginate($this->per_page);


        $this->data['data'] = User::where('user_role', 'customer')
            ->where(function ($query) {
                if (strlen($this->data['keyword']) > 0) {
                    return $query->whereRaw("name LIKE  UPPER('{$this->data['keyword']}%')");
                }
            })->orderBy('created_at', "DESC")
            ->paginate($this->per_page);

        return view('admin.pages.topup.index', $this->data);
    }


    public function create(Request $request)
    {

        $this->data['auth'] = $request->user();

        return view('admin.pages.topup.create', $this->data);
    }



    public function store(Request $request)
    {
        $user = Auth::guard('admin')->user();


        $if_exists_card = User::where('rfid_number', $request->get('rfid_text'))->first();

        if ($if_exists_card) {
            session()->flash('notification-status', "error");
            session()->flash('notification-msg', "RFID number already exist.");
            return redirect()->route('admin.wallet.create');
        }

        DB::beginTransaction();
        try {

            // $topup = new RegisteredRfid;

            // $topup->firstname = $request->get('firstname');
            // $topup->middlename = $request->get('middlename');
            // $topup->lastname = $request->get('lastname');
            // $topup->contact_number = $request->get('contact_number');
            // $topup->rfid_number = $request->get('rfid_text');
            // $topup->e_money = $request->get('amount');
            // $topup->registered_by = $user->id;
            // $topup->save();


            // if ($topup) {
            //     $history = new Topup;

            //     $history->topup_by = $topup->id;
            //     $history->topup_to = $request->get('userId');
            //     $history->amount = $request->get('amount');
            //     $history->save();

            //     $history->transaction_number = 'PLSP' . $this->codeGenerate() . $topup->id;
            //     $history->save();

            //     if ($history) {
            //         $history->status = 'completed';
            //         $history->save();
            //     }
            // }

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
            $this->data['msg'] = "Register success.";
            $this->data['status_code'] = 200;
            // session()->flash('notification-status', "success");
            // session()->flash('notification-msg', "Card Registration success.");
            // return redirect()->route('admin.wallet.create');
        } catch (\Throwable $e) {
            DB::rollback();
            $this->data['msg'] = "Payment unsuccessful.";
            $this->data['status_code'] = 200;
            // session()->flash('notification-status', "failed");
            // session()->flash('notification-msg', "Server Errorss: Code #{$e->getMessage()}");
            // return redirect()->back();
        }
    }

    public function goto_topup(Request $request)
    {

        $this->data['auth'] = $request->user();

        return view('admin.pages.topup.create1', $this->data);
    }



    public function store_topup(Request $request)
    {
        $user = Auth::guard('admin')->user();

        DB::beginTransaction();
        try {

            $customer = User::find($request->get('userId'));
            $topup = new Topup;

            $customer->e_money = (int)$customer->e_money + (int)$request->get('amount');
            $customer->save();

            if ($customer) {
                $topup->transaction_type = 1;
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
            return redirect()->route('admin.wallet.topup');
        } catch (\Throwable $e) {
            DB::rollback();;
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Errorss: Code #{$e->getMessage()}");
            return redirect()->back();
        }
    }

    public function get_info(Request $request)
    {

        $user = User::where('rfid_number', $request->get('rfidText'))->first();

        return $user;
    }

    public function update_status(Request $request, $id)
    {

        $user_data  = User::where('id', $id)->first();

        DB::beginTransaction();
        try {

            $user_data->card_status =   $user_data->card_status ==  'active' ? 'inactive' : 'active';
            $user_data->save();
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Update card status successfully.");
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollback();;
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Errorss: Code #{$e->getMessage()}");
            return redirect()->back();
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
