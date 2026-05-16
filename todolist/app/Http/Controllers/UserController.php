<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User as UserModel;
use App\Http\Requests\UserRegisterPost;

class UserController extends Controller
{
    public function index(){
        return view('user.register');
    }

    public function register(UserRegisterPost $request){
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
