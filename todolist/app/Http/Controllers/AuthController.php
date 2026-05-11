<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginPostRequest;

class AuthController extends Controller
{
    public function index(){
        return view('index');
    }

    public function login(LoginPostRequest $request)
    {
        $datum = $request->validated();

        var_dump($datum); exit;
    }
}
