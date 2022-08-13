<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Controller;
use App\Models\Category;
use Str, DB;

class CategoryController extends Controller
{
    protected $response = [];
    protected $response_code;
    protected $guard = 'api';

    public function __construct()
    {
        $this->middleware('system.guest', ['except' => "logout"]);
    }

    public function show(Request $request)
    {
        $this->data['id'] = $request->get('id');


        try {
            $category = Category::where('status', 'active')
                ->where(function ($query) {
                    if (strlen($this->data['id']) > 0) {
                        return $query->where('id', $this->data['id']);
                    }
                })->orderBy('created_at', "DESC")
                ->get();

            $this->response['status'] = TRUE;
            $this->response['status_code'] = "CATEGORY_INFO";
            $this->response['msg'] = "Category information.";
            $this->response['data'] = $category;
            $this->response_code = 200;
        } catch (\Exception $e) {
            $this->response['status'] = FALSE;
            $this->response['status_code'] = "SERVER_ERROR";
            $this->response['msg'] = "Server Error: Code #{$e->getMessage()}";
            $this->response_code = 500;
        }



        callback:
        return response()->json($this->response, $this->response_code);
    }
}
