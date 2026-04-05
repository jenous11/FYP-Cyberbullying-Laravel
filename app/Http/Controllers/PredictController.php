<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PredictController extends Controller
{
    //
    function predict(Request $request){
        $response = Http::post('http://127.0.0.1:5000/predict',[
            'prediction' => $request->input('prediction')
        ]);
        $prediction = $response->json();
        return view('form', ['prediction' => $prediction]);
    }
}
