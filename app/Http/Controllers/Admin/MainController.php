<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{User, Requests, Announcement, Profiles};

class MainController extends Controller
{
    protected $data = array();
    protected $per_page;

    public function __construct()
    {
        parent::__construct();
        array_merge($this->data, parent::get_data());
        $this->data['page_title'] .= " :: Dashboard";
    }


    public function index()
    {
        $this->data['user'] = User::all()->where('user_role', 1)->count();
        $this->data['admins'] = User::all()->where('user_role', 2)->count();
        $this->data['annoucements'] = Announcement::all()->count();

        $this->data['pending_request'] = Requests::where('is_completed', 0)->count();

        $this->data['school_youth'] = Profiles::where('resident_type', 'school_youth')->count();
        $this->data['senior_citizen'] = Profiles::where('resident_type', 'senior_citizen')->count();
        $this->data['pwd'] = Profiles::where('resident_type', 'pwd')->count();

        return view('admin.pages.dashboard', $this->data);
    }
}
