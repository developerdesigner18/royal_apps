<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class clientController extends Controller
{
    public function index(){
        return view('client.login');

    }

    public function store_token(Request $request){
//        $user = User::where('email' , $request->email)->first();
//        $user->api_token = $request->remember_token;
//        $user->save();
        $user = true;
        if($user){
            session(['token' => $request->remember_token]);
            return response()->json(['status' => 1, 'message' => 'Token Saved successfully' , 'token' => $request->remember_token]);
        }else{
            return response()->json(['status' => 0, 'message' => 'Token Cannot saved' , 'token' => $request->remember_token]);
        }
    }

    public function create(Request $request){

    }

    public  function create_index(){
        return view('client.create');
    }
}
