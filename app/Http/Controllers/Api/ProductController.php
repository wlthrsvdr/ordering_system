<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Controller;
use App\Models\Product;
use Str, DB;

class ProductController extends Controller
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
        $this->data['keyword'] = $request->get('keyword');
        $this->data['category'] = $request->get('category');

        $product = Product::where('status', 'available')
            ->where(function ($query) {
                if (strlen($this->data['id']) > 0) {
                    return $query->where('id', $this->data['id']);
                }
            })
            ->where(function ($query) {
                if (strlen($this->data['keyword']) > 0) {
                    return $query->whereRaw("LOWER(product_name)  LIKE  '{$this->data['keyword']}%'");
                }
            })
            ->where(function ($query) {
                if (strlen($this->data['category']) > 0) {
                    return $query->where('product_category', $this->data['category']);
                }
            })
            ->orderBy('created_at', "DESC")
            ->get();

        // dd($product);

        $this->response['status'] = TRUE;
        $this->response['status_code'] = "PRODUCT_LIST";
        $this->response['msg'] = "Product information.";
        $this->response['data'] = $product;
        $this->response_code = 200;

        callback:
        return response()->json($this->response, $this->response_code);
    }

    public function store(Request $request)
    {
    }
}
