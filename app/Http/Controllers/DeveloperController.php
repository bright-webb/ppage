<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DeveloperController extends Controller
{
    public function index(){
        $user = Session::get('user');
        $data = [
            'user' => $user
        ];

        $query = DB::table('api_keys')->where('user_id', $user);
        if($query->exists()){
            $data['api_key'] = $query->first()->apiKey;
        } else {
            $data['api_key'] = ''; 
        }

        return view('portal.index')->with('data', $data);
    }
}
