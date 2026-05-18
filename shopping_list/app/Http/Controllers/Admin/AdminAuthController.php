<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminAuthController extends Controller
{
    public function index(){
        return view('admin.login');
    }

    public function top(){
        return view('admin.top');
    }

    public function login(LoginPostRequest $request){
        $datum = $request->validated();

        if (Auth::guard('admin')->attempt($datum) === false){
            return back()
            ->withInput()
            ->withErrors(['auth' => 'emailかパスワードに誤りがあります',]);
        }

        $request->session()->regenerate();
        return redirect('/admin/top');
    }

    public function list(){
        $group_by_columns = ['users.id', 'users.name', 'users.email'];

        $users = User::select($group_by_columns)
                    ->selectRaw('COUNT(items.id) as item_count')
                    ->leftJoin('items', 'users.id', '=', 'items.user_id')
                    ->groupBy($group_by_columns)
                    ->paginate(10);

        return view('admin.userlist', ['users' => $users]);

    }

    public function logout(Request $request){
        Auth::guard('admin')->logout();
        $request->session()->regenerateToken();
        $request->session()->regenerate();
        return redirect('/admin/login');
    }
}