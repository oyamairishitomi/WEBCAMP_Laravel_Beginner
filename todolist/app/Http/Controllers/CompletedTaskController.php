<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CompletedTask as CompletedTaskModel;

class CompletedTaskController extends Controller
{
    
    protected function getListBuilder(){
        return CompletedTaskModel::where('user_id', Auth::id())
            ->orderBy('priority', 'DESC')
            ->orderBy('period')
            ->orderBy('created_at');
    }

    public function list(){
        $per_page = 2;

        $list = $this->getListBuilder()
                        ->paginate($per_page);

        return view('task.completed_list', ['list' => $list]);
    }
}
