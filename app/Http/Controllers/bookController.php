<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class bookController extends Controller
{
    public function index(){
        $url = "https://candidate-testing.api.royal-apps.io/api/v2/authors/";

        $options = [
            "http" => [
                "method" => "GET",
                "header" => "Authorization: Bearer ".session('token')
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        $authors = json_decode($response, true);

    $authersdata = [];
        foreach ($authors['items'] as $store){
            $authersdata[] = ['id' => $store['id'] , 'name' => $store['first_name'].' '.$store['last_name']];
        }
        return view('books.add',compact('authersdata'));
    }

}
