<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRegisterPostRequest;
use App\Models\Task as TaskModel;


class TaskController extends Controller
{
    public function list(){
        $per_page = 2;

        $list = TaskModel::where('user_id', Auth::id())
                        ->orderBy('priority','DESC')
                        ->orderBy('period')
                        ->orderBy('created_at')
                        ->paginate($per_page);

        return view('task.list', ['list' => $list]);
    }

    public function detail($task_id){
        return $this->singleTaskRender($task_id, 'task.detail');
    } 

    public function edit($task_id){
        return $this->singleTaskRender($task_id, 'task.edit');
    }

    protected function getTaskModel($task_id){
        $task = TaskModel::find($task_id);
        if ($task === null) {
            return null;
        }

        if ($task->user_id !== Auth::id()) {
            return null;
        }
        return $task;
    }

    protected function singleTaskRender($task_id, $template_name){
        $task = $this->getTaskModel($task_id);
        if ($task === null) {
            return redirect('/task/list');
        }
        return view($template_name, ['task' => $task]);
    }

    public function editSave(TaskRegisterPostRequest $request,$task_id){
        $datum = $request->validated();

        $task = $this->getTaskModel($task_id);
        if ($task === null){
            return redirect('/task/list');
        }

        $task->name = $datum['name'];
        $task->period = $datum['period'];
        $task->detail = $datum['detail'];
        $task->priority = $datum['priority'];

        $task->save();

        $request->session()->flash('front.task_edit_success',true);
        
        return redirect(route('detail', ['task_id' => $task->id]));
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
