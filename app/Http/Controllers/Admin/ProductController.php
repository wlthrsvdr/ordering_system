<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{Category, Product, User};
use Illuminate\Support\Facades\Auth;
use DB, Str, File, URL;

class ProductController extends Controller
{

    protected $data;
    protected $per_page;


    public function __construct()
    {
        $this->data['js'] = "Product";
        $this->middleware('system.guest', ['except' => "logout"]);
    }


    public function index(Request $request)
    {

        $this->data['keyword'] = Str::lower($request->get('keyword'));
        $this->data['status'] = $request->get('status');

        $this->data['products'] = Product::with('addedBy', 'updatedBy', 'category')
            ->where(function ($query) {
                if (strlen($this->data['keyword']) > 0) {
                    return $query->whereRaw("product_name LIKE  UPPER('{$this->data['keyword']}%')");
                }
            })
            ->where(function ($query) {
                if (strlen($this->data['status']) > 0) {
                    return $query->where('status', $this->data['status']);
                }
            })
            ->orderBy('created_at', "DESC")
            ->paginate($this->per_page);

        dd($this->data['products']);
        return view('admin.pages.products.index', $this->data);
    }

    public function create(Request $request)
    {
        $this->data['auth'] = $request->user();

        $this->data['categories'] = Category::select('id', 'category_name')->where('status', 'active')->groupBy('category_name', 'id')->get();

        return view('admin.pages.products.create', $this->data);
    }

    public function store(Request $request)
    {

        $user = Auth::guard('admin')->user();
        // dd($request);
        // $request->validate([
        //     'image' => 'required|mimes:jpg,jpeg,png'
        // ]);


        DB::beginTransaction();
        try {

            $product = new Product;
            $host =  $request->getSchemeAndHttpHost();

            if ($request->file('image')) {
                $image = $request->file('image');
                $fileName = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('uploads/product-images');
                $file = $image->move($destinationPath, $fileName);
                $product->image_directory = 'uploads/product-images';
                $product->image_filename =  $fileName;
                $product->image_path = $host . '/uploads/product-images/' . $fileName;
                // $filePath = $request->file('image')->storeAs('uploads', $fileName, 'public');
                // $product->image_path = '/storage/' . $filePath;
            }

            $product->product_name = $request->get('product_name');
            $product->product_category = $request->get('product_category');
            $product->price = $request->get('price');
            $product->description = $request->get('description');
            $product->added_by = $user->id;
            $product->save();
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Add product successfully.");
            return redirect()->route('admin.products.index');
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

    public function edit(Request $request, $id)
    {
        $this->data['product'] = Product::find($id);

        $this->data['categories'] = Category::select('id', 'category_name')->where('status', 'active')->groupBy('category_name', 'id')->get();
        // dd($this->data);
        return view('admin.pages.products.edit', $this->data);
    }

    public function update(Request $request, $id)
    {
        $user_data = Auth::guard('admin')->user();

        DB::beginTransaction();
        try {

            $product = Product::find($id);
            $host =  $request->getSchemeAndHttpHost();

            if ($request->file('image')) {
                $image = $request->file('image');
                $fileName = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('uploads/product-images');
                $file = $image->move($destinationPath, $fileName);
                $product->image_directory = 'uploads/product-images';
                $product->image_filename =  $fileName;
                $product->image_path = $host . '/uploads/product-images/' . $fileName;
                // $filePath = $request->file('image')->storeAs('uploads', $fileName, 'public');
                // $product->image_path = '/storage/' . $filePath;
            }


            $product->product_name = $request->get('product_name');
            $product->product_category = $request->get('product_category');
            $product->price = $request->get('price');
            $product->description = $request->get('description');
            $product->updated_by =  $user_data->id;
            $product->save();

            DB::commit();
            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Update successfully.");
            return redirect()->route('admin.products.index');
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

        $product  = Product::where('id', $id)->first();
        $user_data = Auth::guard('admin')->user();

        DB::beginTransaction();
        try {

            $product->status =   $product->status ==  'available' ? 'not available' : 'available';
            $product->updated_by =  $user_data->id;
            $product->save();
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Update product status successfully.");
            return redirect()->route('admin.products.index');
        } catch (\Throwable $e) {
            DB::rollback();;
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Errorss: Code #{$e->getMessage()}");
            return redirect()->back();
        }
    }
}
