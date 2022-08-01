<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Authenticated;
use Helper,Route,Request,Carbon,stdClass,DB;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $data = array();


    public function __construct(){
        self::set_system_routes();
        self::set_user_info();
    }

    public function set_system_routes(){
		$this->data['routes'] = [
			'masterfile'	=> [
				'admin' => ['system.admin.login','system.admin.create','system.admin.edit'],
			],
		];
	}

    public function get_data(){
		$this->data['page_title'] = env("APP_NAME","");
		return $this->data;
	}

    public function set_user_info(){
		$this->data['auth'] = false;
		Event::listen(Authenticated::class, function ($event) {
           $this->data['auth'] = $event->user;
        });
	}
}
