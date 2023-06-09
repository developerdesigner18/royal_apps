<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class clientController extends Controller
{
//    LOGIN PAGE
    public function index(){
        return view('client.login');

    }
//    DASHBOARD
    public function dashboard(){
        $user = session('user');
        return view('dashboard',compact('user'));

    }
//    LOGOUT USER
    public function logout(){

        if (session()->has('token')) {
            session()->forget('token');
        }
        if (session()->has('user')) {
            session()->forget('user');
        }
        return redirect('client');
    }

//    FOR SESSION STORE
    public function store_token(Request $request){
        $user = true;
        if($user){
            session(['token' => $request->remember_token,'user'=> $request->userdetails]);
            return response()->json(['status' => 1, 'message' => 'Token Saved successfully' , 'token' => $request->remember_token]);
        }else{
            return response()->json(['status' => 0, 'message' => 'Token Cannot saved' , 'token' => $request->remember_token]);
        }
    }
//    CLIENT CREATE PAGE
    public  function create_index(){
        return view('client.create');
    }
}
