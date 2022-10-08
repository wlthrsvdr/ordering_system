<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{Category, Product, User};
use Illuminate\Support\Facades\Auth;
use DB, Str, File, URL, Illuminate\Support\Carbon;
use  Illuminate\Support\Facades\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;

class ApplicationController extends Controller
{

    protected $data;
    protected $per_page;


    public function __construct()
    {
        $this->data['js'] = "Application";
        $this->middleware('system.guest', ['except' => "logout"]);
    }


    public function index(Request $request)
    {

        $dirs = File::allFiles(public_path() . '/assets/downloads');
        $arr = [];

        foreach ($dirs as  $file) {
            // dd($file->getPathInfo());
            array_push($arr, [
                'filename' => $file->getBasename(),
                'filesize' => $file->getSize(),
                'date' => Carbon::parse($file->getCTime())->format('m/d/y'),
                'path' => $file->getPathname()
            ]);
        }

        $this->data['application'] = $this->paginate($arr);

        return view('admin.pages.application.index', $this->data);
    }

    public function create(Request $request)
    {
        $this->data['auth'] = $request->user();
        return view('admin.pages.application.create', $this->data);
    }

    public function store(Request $request)
    {
        // $dirs = File::allFiles(public_path() . '/assets/downloads');
        $dirs = File::allFiles('public/assets/downloads');

        if (count($dirs) > 0) {
            session()->flash('notification-status', "error");
            session()->flash('notification-msg', "There is a existing installer. Please remove first the current installer before uploading a new installer");
            return redirect()->back();
        } else {

            if ($request->file('apk')) {
                $apk = $request->file('apk');
                $fileName =  $apk->getClientOriginalName();
                $destinationPath = public_path('assets/downloads');
                $file = $apk->move($destinationPath, $fileName);
            }

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Add installer success.");
            return redirect()->route('admin.application.index');
        }
    }

    public function remove_apk(Request $request, $filename)
    {

        if (File::exists(public_path('assets/downloads/' . $filename))) {
            File::delete(public_path('assets/downloads/' . $filename));


            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Remove success.");
            return redirect()->back();
        } else {
            session()->flash('notification-status', "error");
            session()->flash('notification-msg', "Apk doesnt exists.");
            return redirect()->back();
        }
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function download_apk(Request $request)
    {
        // $dirs = File::allFiles(public_path() . '/assets/downloads');

        $dirs = File::allFiles('public/assets/downloads');

        if (count($dirs) == 0) {
            return abort(404);
        } else {
            return Response::download($dirs[0]);
        }
    }
}
