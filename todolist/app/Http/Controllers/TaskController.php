<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRegisterPostRequest;
use App\Models\Task as TaskModel;
use Illuminate\Support\Facades\DB;
use App\Models\CompletedTask as CompletedTaskModel;

class TaskController extends Controller
{
    
    protected function getListBuilder(){
        return TaskModel::where('user_id', Auth::id())
            ->orderBy('priority', 'DESC')
            ->orderBy('period')
            ->orderBy('created_at');
    }

    public function list(){
        $per_page = 2;

        $list = $this->getListBuilder()
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

    public function complete(Request $request, $task_id)
{
    /* タスクを完了テーブルに移動させる */
    try {
        // トランザクション開始
        DB::beginTransaction();

            // task_idのレコードを取得する
            $task = $this->getTaskModel($task_id);
            if ($task === null) {
                throw new \Exception('');
            }

            // tasks側を削除する
            $task->delete();

            // completed_tasks側にinsertする
            $dask_datum = $task->toArray();
            unset($dask_datum['created_at']);
            unset($dask_datum['updated_at']);
            $r = CompletedTaskModel::create($dask_datum);
            if ($r === null) {
                throw new \Exception('');
            }

        // トランザクション終了
        DB::commit();
        $request->session()->flash('front.task_completed_success', true);

    } catch(\Throwable $e) {
        // トランザクション異常終了
        DB::rollBack();
        $request->session()->flash('front.task_completed_failure', true);
    }
        // 一覧に遷移する
        return redirect('/task/list');
    }

    public function csvDownload() {
        $data_list = [
            'id' => 'タスクID',
            'name' => 'タスク名',
            'priority' => '重要度',
            'period' => '期限',
            'detail' => 'タスク詳細',
            'created_at' => 'タスク作成日',
            'updated_at' => 'タスク修正日',
            ];

            $list = $this->getListBuilder()->get();
            
            ob_start();

            $file = new \SplFileObject('php://output', 'w');
            $file->fputcsv(array_values($data_list));

            foreach($list as $datum) {
                $awk = [];
                foreach ($data_list as $k => $v){
                    if($k === 'priority'){
                        $awk[] = $datum->getPriorityString();
                    } else {
                        $awk[] = $datum->$k;
                    }
                }
                $file->fputcsv($awk);
            }

            $csv_string = ob_get_clean();

            $csv_string_sjis = mb_convert_encoding($csv_string, 'SJIS', 'UTF-8');

            $download_filename = 'task_list.' . date('Ymd'). '.csv';

            return response($csv_string_sjis)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="'. $download_filename .'"');
    }

}
