<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class authorsController extends Controller
{
//    DISPLAY AUTHORS INDEX PAGE
    public function index(Request $request){
        return view('authors.index');
    }
//    DISPLAY AUTHORS RELATED BOOKS PAGE
    public function authors_books(Request $request , $authors){

        return view('authors.books',compact('authors'));
    }
//CHECK THE AUTHOS HAVE ANY BOOKS OR NOT
 public function authors_books_check(Request $request){
     $url = "https://candidate-testing.api.royal-apps.io/api/v2/authors/".$request->id;
     $options = [
         "http" => [
             "method" => "GET",
             "header" => "Authorization: Bearer ".session('token')
         ]
     ];

     $context = stream_context_create($options);
     $response = file_get_contents($url, false, $context);

     $authors = json_decode($response, true);
     if(empty($authors['books'])){
         return response()->json(['status' => 1, 'message' => 'This Authors dosent have any books']);
     }else{
         return response()->json(['status' => 0, 'message' => "Can't Delete this authors have books"]);
     }



 }

}
