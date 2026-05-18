<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterPostRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
      return view('user.register');
    }

    public function register(UserRegisterPostRequest $request){
      $datum = $request->validated();
      $datum['password'] = Hash::make($datum['password']);

      DB::table('users')->insert([
        'name' => $datum['name'],
        'email' => $datum['email'],
        'password' => $datum['password'],
      ]);

      $request->session()->flash('front.user_register_success', true);

      return redirect('/');
    }
}
