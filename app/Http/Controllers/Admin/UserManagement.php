<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{User, Profiles};
use DB;
use Str;

class UserManagement extends Controller
{

    protected $data;
    protected $per_page;


    public function __construct()
    {
        $this->data['js'] = "UserManagement.js";
        $this->middleware('system.guest', ['except' => "logout"]);
    }

    public function users(Request $request)
    {
        // $this->data['user'] = Profiles::with('account')->get();

        $this->data['keyword'] = Str::lower($request->get('keyword'));

        $this->data['users'] = Profiles::where(function ($query) {
            if (strlen($this->data['keyword']) > 0) {
                return $query->whereRaw("first_name LIKE  UPPER('{$this->data['keyword']}%')")
                    ->orWhereRaw("LOWER(last_name)  LIKE  '{$this->data['keyword']}%'")
                    ->orWhereRaw("LOWER(email)  LIKE  '{$this->data['keyword']}%'");
            }
        })->orderBy('created_at', "DESC")
            ->paginate($this->per_page);

        return view('admin.pages.users', $this->data);
    }

    public function store(Request $request)
    {

        if ($request->get('password') != $request->get('confirm_password')) {
            session()->flash('notification-status', "error");
            session()->flash('notification-msg', "Password not match.");

            goto callback;
        }

        DB::beginTransaction();
        try {

            $credentials = new User;
            $credentials->name = $request->get('firstname') . ' ' . $request->get('middlname') . ' ' . $request->get('lastname') . ' ' . $request->get('suffix');
            $credentials->email = $request->get('email');
            $credentials->password = bcrypt($request->get('password'));
            $credentials->user_role = $request->get('user_role');
            $credentials->account_status = 1;
            $credentials->save();
            DB::commit();


            $profile = new Profiles;
            $profile->userId = $credentials->id;
            $profile->first_name = $request->get('firstname');
            $profile->middle_name =  $request->get('middlename');
            $profile->last_name =  $request->get('lastname');
            $profile->suffix =  $request->get('suffix');
            $profile->age =  $request->get('age');
            $profile->civil_status =  $request->get('civil_status');
            $profile->gender =  $request->get('gender');
            $profile->purok =  $request->get('address');
            $profile->phone =  $request->get('phone');
            $profile->telno =  $request->get('telno');
            $profile->bday =  $request->get('bday');
            $profile->resident_type =  $request->get('resident_type');
            $profile->role =  $request->get('user_role');
            $profile->save();
            DB::commit();

            return redirect()->route('admin.users');
            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Register successfully.");
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

    public function get_user($id)
    {
        $data  = Profiles::with('account')->where('id', $id)->first();

        return  $data;
    }

    public function update(Request $request)
    {

        DB::beginTransaction();
        try {
            $profile = Profiles::with('account')->where('id', request('id'))->first();
            $profile->userId = request('users_id');
            $profile->first_name = request('firstname');
            $profile->middle_name =  request('middlename');
            $profile->last_name =  request('lastname');
            $profile->suffix =  request('suffix');
            $profile->gender = request('gender');
            $profile->address = request('address');
            $profile->age =  request('age');
            $profile->civil_status =  $request->get('civil_status');
            $profile->phone =  request('phone');
            $profile->telno =  request('telno');
            $profile->bday =  request('bday');
            $profile->role =  request('user_role');
            $profile->resident_type =  $request->get('resident_type');
            $profile->account->email = request('email');
            $profile->account->name = request('firstname') . ' ' . request('middlname') . ' ' . request('lastname') . ' ' . request('suffix');
            $profile->save();
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Update successfully.");
        } catch (\Throwable $e) {
            DB::rollback();;
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Errorss: Code #{$e->getMessage()}");
        }

        return   $profile;
    }

    public function approvedUser($id)
    {

        $user_data  = Profiles::with('account')->where('id', $id)->first();

        DB::beginTransaction();
        try {

            $user_data->role = 1;
            $user_data->save();
            DB::commit();

            $user_data->account->account_status = 1;
            $user_data->account->save();
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Approve user successfully.");
        } catch (\Throwable $e) {
            DB::rollback();;
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Errorss: Code #{$e->getMessage()}");
        }
        return $user_data;
    }

    public function blockedUser($id)
    {

        $user_data  = Profiles::with('account')->where('id', $id)->first();


        DB::beginTransaction();
        try {

            $user_data->role = 0;
            $user_data->save();
            DB::commit();

            $user_data->account->account_status = 0;
            $user_data->account->save();
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Block user successfully.");
        } catch (\Throwable $e) {
            DB::rollback();;
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Errorss: Code #{$e->getMessage()}");
        }

        return $user_data;
    }
}
