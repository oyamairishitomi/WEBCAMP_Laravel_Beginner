<?php

namespace App\Http\Controllers;

use App\Models\ItemModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRegisterPostRequest;
use App\Models\CompletedItem;

class ShoppingListController extends Controller
{
    protected function getListBuilder(){
        return ItemModel::where('user_id', Auth::id())
            ->orderBy('created_at');
    }

    public function list(){
        $per_page = 10;

        $list = $this->getListBuilder()
                    ->paginate($per_page);

        return view('list.list', ['list' => $list]);
    }

    public function delete(Request $request, $id){
        try{
            DB::beginTransaction();

            $item = ItemModel::find($id);
            if($item === null || $item->user_id !== Auth::id()) {
                throw new \Exception('');
            }

            $item->delete();
            DB::commit();
            
        } catch (\Throwable $e){
            DB::rollBack();
        }
        
        return redirect()->route('list.list');
    }

    public function complete(Request $request, $id){
        try{
            DB::beginTransaction();

            $item = ItemModel::find($id);
            if ($item === null || $item->user_id !== Auth::id()) {
                throw new \Exception('');
            }

            $item->delete();

            CompletedItem::create([
                'name' => $item->name,
                'user_id' => $item->user_id,
            ]);

            DB::commit();
            $request->session()->flash('front.complete_success',true);
            
        } catch (\Throwable $e){
            DB::rollBack();
        }
        
        return redirect()->route('list.list');
    }

    public function register(ItemRegisterPostRequest $request){
        $datum = $request->validated();
        $datum['user_id'] = Auth::id();

        try {
            ItemModel::create($datum);
        } catch (\Throwable $e) {
            echo $e->getMessage();
            exit;
        }

        $request->session()->flash('front.list_register_success', true);

        return redirect()->route('list.list');
    }
}
