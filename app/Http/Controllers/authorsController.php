<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class authorsController extends Controller
{
    public function index(Request $request){
        return view('authors.index');
    }
    public function authors_books(Request $request , $authors){

        return view('authors.books',compact('authors'));
    }

}
