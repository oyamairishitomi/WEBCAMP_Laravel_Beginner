<?php

declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\AdminLoginPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function login(AdminLoginPostRequest $request)
    {
        $datum = $request->validated();

        if (Auth::guard('admin')->attempt($datum) === false){
            return back()
                ->withInput()
                ->withErrors(['auth' => 'ログインIDかパスワード2誤りがあります',]);
        }

        $request->session()->regenerate();
        return redirect()->intended('/admin/top');
    }

    public function logout(Request $request){
        Auth::guard('admin')->logout();
        $request->session()->regenerateToken();
        $request->session()->regenerate();
        return redirect(route('admin.index'));
    }
}
