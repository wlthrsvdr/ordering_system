<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{Topup, User};
use DB, Str;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\callback;

class UserManagementController extends Controller
{

    protected $data;
    protected $per_page;


    public function __construct()
    {
        $this->data['js'] = "UserManagement";
        $this->middleware('system.guest', ['except' => "logout"]);
    }

    public function students(Request $request)
    {

        $this->data['keyword'] = Str::lower($request->get('keyword'));
        $this->data['status'] = $request->get('status');

        $this->data['students'] = User::where('user_role', 'customer')
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

        return view('admin.pages.user-management.student.index', $this->data);
    }

    public function create_student(Request $request)
    {
        $this->data['auth'] = $request->user();


        return view('admin.pages.user-management.admin.create', $this->data);
    }

    public function store_student(Request $request)
    {

        if ($request->get('password') != $request->get('confirm_password')) {
            session()->flash('notification-status', "error");
            session()->flash('notification-msg', "Password not match.");

            goto callback;
        }

        DB::beginTransaction();
        try {

            $user = new User;
            // $user->student_number = $request->get('student_number');
            $user->firstname = $request->get('firstname');
            $user->middlename = $request->get('middlename');
            $user->lastname = $request->get('lastname');
            $user->suffix = $request->get('suffix');
            $user->email = $request->get('email');
            $user->password = bcrypt($request->get('password'));
            $user->user_role = 'customer';
            $user->account_status = 'active';
            $user->save();
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Register successfully.");
            return redirect()->route('admin.users.student.index');
        } catch (\Throwable $e) {
            DB::rollback();;
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Errorss: Code #{$e->getMessage()}");
            return redirect()->back();
        }

        callback:
        session()->flash('notification-status', "failed");
        return redirect()->back();
    }

    public function admins(Request $request)
    {

        $this->data['keyword'] = Str::lower($request->get('keyword'));
        $this->data['status'] = $request->get('status');
        $this->data['account_type'] = $request->get('account_type');

        $this->data['admins'] = User::where('user_role', '!=', 'customer')
            ->where(function ($query) {
                if (strlen($this->data['keyword']) > 0) {
                    return $query->whereRaw("firstname LIKE  UPPER('{$this->data['keyword']}%')")
                        ->orWhereRaw("LOWER(lastname)  LIKE  '{$this->data['keyword']}%'")
                        ->orWhereRaw("LOWER(email)  LIKE  '{$this->data['keyword']}%'");
                }
            })
            ->where(function ($query) {
                if (strlen($this->data['status']) > 0) {
                    return $query->where('account_status', $this->data['status']);
                }
            })
            ->where(function ($query) {
                if (strlen($this->data['account_type']) > 0) {
                    return $query->where('user_role', $this->data['account_type']);
                }
            })->orderBy('created_at', "DESC")
            ->paginate($this->per_page);


        return view('admin.pages.user-management.admin.index', $this->data);
    }

    public function create_admin(Request $request)
    {
        $this->data['auth'] = $request->user();


        return view('admin.pages.user-management.admin.create', $this->data);
    }

    public function store_admin(Request $request)
    {

        if ($request->get('password') != $request->get('confirm_password')) {
            session()->flash('notification-status', "error");
            session()->flash('notification-msg', "Password not match.");

            goto callback;
        }

        DB::beginTransaction();
        try {

            $user = new User;
            // $user->student_number = $request->get('student_number');
            $user->firstname = $request->get('firstname');
            $user->middlename = $request->get('middlename');
            $user->lastname = $request->get('lastname');
            $user->suffix = $request->get('suffix');
            $user->email = $request->get('email');
            $user->password = bcrypt($request->get('password'));
            $user->user_role = $request->get('user_role');
            $user->account_status = 'active';
            $user->save();
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Register successfully.");
            return redirect()->route('admin.users.admin.index');
        } catch (\Throwable $e) {
            DB::rollback();;
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Errorss: Code #{$e->getMessage()}");
            return redirect()->back();
        }

        callback:
        session()->flash('notification-status', "failed");
        return redirect()->back();
    }

    public function edit_admin(Request $request, $id)
    {
        $this->data['admin'] = User::find($id);

        return view('admin.pages.user-management.admin.edit', $this->data);
    }

    public function update_admin(Request $request, $id)
    {

        // dd($request);
        DB::beginTransaction();
        try {

            $user = User::find($id);
            // $user->student_number = $request->get('student_number');
            $user->firstname = $request->get('firstname');
            $user->middlename = $request->get('middlename');
            $user->lastname = $request->get('lastname');
            $user->suffix = $request->get('suffix');
            $user->email = $request->get('email');
            $user->user_role = $request->get('user_role');
            $user->save();

            DB::commit();
            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Update successfully.");
            return redirect()->route('admin.users.admin.index');
        } catch (\Throwable $e) {
            DB::rollback();;
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Errorss: Code #{$e->getMessage()}");
            return redirect()->back();
        }

        callback:
        session()->flash('notification-status', "failed");
        return redirect()->back();
    }

    public function update_status(Request $request, $id)
    {

        $user_data  = User::where('id', $id)->first();

        DB::beginTransaction();
        try {

            $user_data->account_status =   $user_data->account_status ==  'active' ? 'inactive' : 'active';
            $user_data->save();
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Update user status successfully.");
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollback();;
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Errorss: Code #{$e->getMessage()}");
            return redirect()->back();
        }
    }


    public function store(Request $request)
    {
        $user = Auth::guard('admin')->user();


        $if_exists_card = User::where('rfid_number', $request->get('rfidText'))->first();

        if ($if_exists_card) {
            $this->data['msg'] = "RFID Number already register.";
            $this->data['status_code'] = 401;
            goto callback;
        }

        $student = User::find($request->get('userId'));


        $student->rfid_number = $request->get('rfidText');
        $student->card_status = 'active';
        $student->save();

        if ($student) {
            $topup = new Topup;

            $topup->transaction_type = 2;
            $topup->topup_by = $user->id;
            $topup->topup_by = 50;
            $topup->status = 'completed';
            $topup->save();

            $topup->transaction_number = 'PLSP' . $this->codeGenerate() . $topup->id;
            $topup->save();
        }

        if ($student) {
            $this->data['msg'] = "Register success.";
            $this->data['status_code'] = 200;
            $this->data['data'] = $student;
        } else {
            $this->data['msg'] = "Register unsuccessful.";
            $this->data['status_code'] = 401;
        }

        callback:
        return $this->data;
    }

    public function update_card_status(Request $request, $id)
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
