<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Controller;
use App\Models\User;
use Str, DB;

class AuthController extends Controller
{
    protected $response = [];
    protected $response_code;
    protected $guard = 'api';

    public function __construct()
    {
        $this->middleware('system.guest', ['except' => "logout"]);
    }


    public function authenticate(Request $request)
    {

        $email =  Str::lower($request->get('email'));
        $password  = $request->get('password');

        $field = filter_var($email, FILTER_VALIDATE_EMAIL) ? 'email' : 'student_number';



        if (Auth::guard($this->guard)->attempt(['email' => $request->get('email'), 'password' => $request->get('password'), 'user_role' => 'customer'])) {

            $user =  auth($this->guard)->user();
            $user_data =  User::where('id',   $user->id)->get();

            if ($user->account_status  == 'inactive') {
                $this->response['status'] = FALSE;
                $this->response['status_code'] = "LOGIN_FAILED";
                $this->response['msg'] = "Account is inactive. Please contact administrator.";
                $this->response_code = 401;
                goto callback;
            }

            $this->response['status'] = TRUE;
            $this->response['status_code'] = "LOGIN_SUCCESS";
            $this->response['msg'] = "Welcome {$user->name}!";
            $this->response['data'] = $user_data;
            $this->response_code = 200;
        } else {
            $this->response['status'] = FALSE;
            $this->response['status_code'] = "LOGIN_FAILED";
            $this->response['msg'] = "User not found";
            $this->response_code = 400;
        }

        callback:
        return response()->json($this->response, $this->response_code);
    }

    public function logout()
    {
        $user = auth($this->guard)->user();

        if (!$user) {
            $this->response['status'] = FALSE;
            $this->response['status_code'] = "UNAUTHORIZED";
            $this->response['msg'] = "Invalid";
            $this->response_code = 401;
            goto  callback;
        }

        auth($this->guard)->logout(true);


        $this->response['status'] = TRUE;
        $this->response['status_code'] = "LOGOUT_SUCCESS";
        $this->response['msg'] = "Session closed.";
        $this->response_code = 200;

        callback:
        return response()->json($this->response, $this->response_code);
    }

    public function register(Request $request)
    {

        $email_validation = User::where('email', $request->get('email'))
            ->where('user_role', 'student')->first();

        // $student_num_validation = User::where('student_number', $request->get('student_number'))
        //     ->where('user_role', 'student')->first();


        if ($request->get('password') != $request->get('confirm_password')) {
            $this->response['status'] = FALSE;
            $this->response['status_code'] = "REGISTRATION_FAILED";
            $this->response['msg'] = "Password not match.";
            $this->response_code = 401;
            goto callback;
        }

        if (!empty($email_validation)) {
            $this->response['status'] = FALSE;
            $this->response['status_code'] = "REGISTRATION_FAILED";
            $this->response['msg'] = "Email Already Exists.";
            $this->response_code = 401;
            goto callback;
        }


        // if (!empty($student_num_validation)) {
        //     $this->response['status'] = FALSE;
        //     $this->response['status_code'] = "REGISTRATION_FAILED";
        //     $this->response['msg'] = "Student Number Already Exists";
        //     $this->response_code = 401;
        //     goto callback;
        // }


        try {
            DB::beginTransaction();
            $user = new User;
            // $user->student_number = $request->get('student_number');
            $user->contact_number = $request->get('contact_number');
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
            $this->response['status'] = TRUE;
            $this->response['status_code'] = "REGISTERED";
            $this->response['msg'] = "Successfully registered.";
            $this->response_code = 200;
        } catch (\Throwable $e) {
            DB::rollback();

            $this->response['status'] = FALSE;
            $this->response['status_code'] = "SERVER_ERROR";
            $this->response['msg'] = "Server Error: Code #{$e->getMessage()}";
            $this->response_code = 500;
        }

        callback:
        return response()->json($this->response, $this->response_code);
    }

    public function show(Request $request)
    {
        $user = User::where('id', $request->get('id'))->get();

        if (!$user) {
            $this->response['status'] = FALSE;
            $this->response['status_code'] = "INVALID_CREDENDIAL";
            $this->response['msg'] = "User not found.";
            $this->response_code = 401;
            goto callback;
        }

        $this->response['status'] = TRUE;
        $this->response['status_code'] = "PROFILE_INFO";
        $this->response['msg'] = "Profile information.";
        $this->response['data'] = json_decode($user, true);
        $this->response_code = 200;

        callback:
        return response()->json($this->response, $this->response_code);
    }

    public function forgot_password(Request $request)
    {
        $user = User::where('email', $request->get('email'))->get();

        if (!$user) {
            $this->response['status'] = FALSE;
            $this->response['status_code'] = "INVALID_CREDENDIAL";
            $this->response['msg'] = "Email not found.";
            $this->response_code = 401;
            goto callback;
        }

        $user->password = bcrypt($request->get('password'));
        $user->save();

        $this->response['status'] = TRUE;
        $this->response['status_code'] = "PROFILE_INFO";
        $this->response['msg'] = "Profile information.";
        $this->response['data'] = json_decode($user, true);
        $this->response_code = 200;

        callback:
        return response()->json($this->response, $this->response_code);
    }

    public function update(Request $request)
    {
        $email_validation = User::where('email', $request->get('email'))
            ->where('user_role', 'customer')
            ->where('id', '!=', $request->get('userId'))
            ->first();

        // $student_num_validation = User::where('student_number', $request->get('student_number'))
        //     ->where('user_role', 'student')
        //     ->where('id', '!=', $request->get('userId'))
        //     ->first();


        if ($request->get('password') != $request->get('confirm_password')) {
            $this->response['status'] = FALSE;
            $this->response['status_code'] = "UPDATE_FAILED";
            $this->response['msg'] = "Password not match.";
            $this->response_code = 401;
            goto callback;
        }

        if (!empty($email_validation)) {
            $this->response['status'] = FALSE;
            $this->response['status_code'] = "UPDATE_FAILED";
            $this->response['msg'] = "Email Already Exists.";
            $this->response_code = 401;
            goto callback;
        }


        // if (!empty($student_num_validation)) {
        //     $this->response['status'] = FALSE;
        //     $this->response['status_code'] = "UPDATE_FAILED";
        //     $this->response['msg'] = "Student Number Already Exists";
        //     $this->response_code = 401;
        //     goto callback;
        // }


        try {
            DB::beginTransaction();
            $user = User::find($request->get('userId'));
            $user->contact_number = $request->get('contact_number');
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
            $this->response['status'] = TRUE;
            $this->response['status_code'] = "UPDATED";
            $this->response['msg'] = "Successfully updated.";
            $this->response_code = 200;
        } catch (\Throwable $e) {
            DB::rollback();

            $this->response['status'] = FALSE;
            $this->response['status_code'] = "SERVER_ERROR";
            $this->response['msg'] = "Server Error: Code #{$e->getMessage()}";
            $this->response_code = 500;
        }

        callback:
        return response()->json($this->response, $this->response_code);
    }
}
