<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListItem;
use Illuminate\Support\Facades\Auth;

class ToDoListController extends Controller{

    public function index(){
        $user = Auth::user();
        $listItems = $user->listItems; 

        return view('list', ['listItems' => $listItems]);
    }

    public function markCompl($item_id){
        $listItem = ListItem::where('item_id', $item_id)
            ->where('user_id', Auth::id())
            ->first();

        $listItem->is_complete = !$listItem->is_complete;
        $listItem->save();

        return redirect('/');
    }

    public function saveItem(Request $request){
        $request->validate([
            'listItem' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $newListItem = new ListItem;
        $newListItem->name = $request->listItem;
        $newListItem->is_complete = 0;
        $newListItem->user_id = $user->user_id; 
        $newListItem->save();

        return redirect('/');
    }

    public function deleteItem($item_id){
        $listItem = ListItem::where('item_id', $item_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $listItem->delete();

        return redirect('/');
    }
}
