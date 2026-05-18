<?php

namespace App\Http\Controllers;

use App\Models\CompletedItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class CompletedShoppingListController extends Controller
{
    protected function getListBuilder (){
        return CompletedItem::where('user_id', Auth::id())
            ->orderBy('completed_at', 'DESC');
    }

    public function list(){
        $per_page = 10;
        
        $list = $this->getListBuilder()
                        ->paginate($per_page);

        return view('list.completed_list', ['list' => $list]);
    }
}
