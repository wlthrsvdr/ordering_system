<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{Category, User};
use Illuminate\Support\Facades\Auth;
use DB, Str;

class CategoryController extends Controller
{

    protected $data;
    protected $per_page;


    public function __construct()
    {
        $this->middleware('system.guest', ['except' => "logout"]);
        $this->data['js'] = "Category";
    }


    public function index(Request $request)
    {

        $this->data['keyword'] = Str::lower($request->get('keyword'));

        $this->data['categories'] = Category::with('addedBy', 'updatedBy')
            ->where(function ($query) {
                if (strlen($this->data['keyword']) > 0) {
                    return $query->whereRaw("category_name LIKE  UPPER('{$this->data['keyword']}%')");
                }
            })
            ->orderBy('created_at', "DESC")
            ->paginate($this->per_page);


        return view('admin.pages.categories.index', $this->data);
    }

    public function create(Request $request)
    {
        $this->data['auth'] = $request->user();


        return view('admin.pages.categories.create', $this->data);
    }

    public function store(Request $request)
    {

        $user = Auth::guard('admin')->user();

        DB::beginTransaction();
        try {

            $category = new Category;

            $category->category_name = $request->get('category_name');
            // $category->category_code = $request->get('category_code');
            $category->added_by =  $user->id;
            $category->save();
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Register successfully.");
            return redirect()->route('admin.categories.index');
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
        $this->data['category'] = Category::find($id);

        return view('admin.pages.categories.edit', $this->data);
    }

    public function update(Request $request, $id)
    {
        $user_data = Auth::guard('admin')->user();

        DB::beginTransaction();
        try {

            $user = Category::find($id);

            $user->category_name = $request->get('category_name');
            // $user->category_code = $request->get('category_code');
            $user->updated_by =  $user_data->id;
            $user->save();

            DB::commit();
            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Update successfully.");
            return redirect()->route('admin.categories.index');
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

        $category  = Category::where('id', $id)->first();

        DB::beginTransaction();
        try {

            $category->status =   $category->status ==  'active' ? 'inactive' : 'active';
            $category->save();
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Update category status successfully.");
            return redirect()->route('admin.categories.index');
        } catch (\Throwable $e) {
            DB::rollback();;
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Errorss: Code #{$e->getMessage()}");
            return redirect()->back();
        }
    }
}
