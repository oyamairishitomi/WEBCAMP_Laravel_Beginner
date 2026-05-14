<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRegisterPostRequest;
use App\Models\Task as TaskModel;


class TaskController extends Controller
{
    public function list(){
        $list = TaskModel::where('user_id', Auth::id())
                        ->orderBy('priority','DESC')
                        ->orderBy('period')
                        ->orderBy('created_at')
                        ->get();
        // $sql = TaskModel::where('user_id', Auth::id())
        //                 ->orderBy('priority', 'DESC')
        //                 ->orderBy('period')
        //                 ->orderBy('created_at')
        //                 ->toSql();
        // var_dump($sql);

        return view('task.list', ['list' => $list]);
    }

    public function register(TaskRegisterPostRequest $request){
        $datum = $request->validated();
        $datum['user_id'] = Auth::id();

        try {
            TaskModel::create($datum);
        } catch(\Throwable $e) {
            echo $e->getMessage();
            exit;
        }

        $request->session()->flash('front.task_register_success', true);

        return redirect('/task/list');
    }
}
