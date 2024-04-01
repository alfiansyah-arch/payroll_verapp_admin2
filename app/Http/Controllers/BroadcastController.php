<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Broadcast;
use App\Models\CategoryBroadcast;
use Illuminate\Http\Request;

class BroadcastController extends Controller
{
    public function index(Request $request)
    {
        $title = 'List Broadcast';
        $avatar = $request->user()->avatar;
        $broadcasts = Broadcast::leftJoin('users', 'broadcasts.user_id', '=', 'users.user_id')
        ->leftJoin('category_broadcasts', 'broadcasts.category', '=', 'category_broadcasts.id')
        ->select('broadcasts.*', 'users.username', 'category_broadcasts.category_name')
        ->get();
        $categorys = CategoryBroadcast::all();
        $role = $request->user()->role_name;
        $status = $request->user()->status;
        if ($role === "Super Admin" || $status == 'Active') {
            $employees = User::all();
        } elseif ($role === "Admin" || $status == 'Active') {
            $employees = User::where('role_name', 'Employee')->get();
        }
        return view('broadcast.index', compact('employees','broadcasts','categorys', 'title','avatar'));
    }

    public function create(Request $request)
    {
        $title ='Add New Broadcast';
        $avatar = $request->user()->avatar;
        $username = $request->user()->username;
        $user_id = $request->user()->user_id;
        $categorys = CategoryBroadcast::all();
        return view('broadcast.create', compact('title','categorys','username','user_id','avatar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'category' => 'required',
            'broadcast_title' => 'required',
            'date' => 'required',
            'description' => 'required',
        ]);

        $data = $request->all();

        $broadcasts = new Broadcast();
        $broadcasts->user_id = $data['user_id'];
        $broadcasts->category = $data['category'];
        $broadcasts->broadcast_title = $data['broadcast_title'];
        $broadcasts->date = $data['date'];
        $broadcasts->img = $data['img'];
        $broadcasts->description = $data['description'];

        $broadcasts->save();

        return redirect()->route('broadcast.index')->with('success', 'Broadcast added successfully');
    }

    public function upload(Request $request){
        if($request->hasFile('upload')){
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->move(public_path('media_broadcast'), $fileName);

            $url = asset('media_broadcast/'. $fileName);
            return response()->json(['fileName'=>$fileName,'uploaded'=>1,'url'=>$url]);
        }
    }

    public function createCategory(Request $request)
    {
        $title ='Add New Category';
        $avatar = $request->user()->avatar;
        $username = $request->user()->username;
        $user_id = $request->user()->user_id;
        $categorys = CategoryBroadcast::all();
        return view('broadcast.createcategory', compact('title','categorys','username','user_id','avatar'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        $data = $request->all();

        $categorys = new CAtegoryBroadcast();
        $categorys->category_name = $data['category_name'];

        $categorys->save();

        return redirect()->route('broadcast.index')->with('success', 'Category Broadcast added successfully');
    }

    public function show(Request $request, $id)
    {
        $title = 'Show Broadcast';
        $avatar = $request->user()->avatar;
        try {
            $broadcasts = Broadcast::leftJoin('users', 'broadcasts.user_id', '=', 'users.user_id')
                ->leftJoin('category_broadcasts', 'broadcasts.category', '=', 'category_broadcasts.id')
                ->select('broadcasts.*', 'users.username', 'category_broadcasts.category_name')
                ->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('danger', 'Broadcast not found.');
        }
        return view('broadcast.show', compact('broadcasts', 'title', 'avatar'));
    }
    

    public function edit(Request $request, $id)
    {
        $title = 'Edit Broadcast';
        $avatar = $request->user()->avatar;
        $broadcasts = Broadcast::leftJoin('users', 'broadcasts.user_id', '=', 'users.user_id')
        ->select('broadcasts.*', 'users.username')
        ->findOrFail($id);
        $user_id = $request->user()->user_id;
        $username = $request->user()->username;
        $categorys = CategoryBroadcast::all();
        $selectedCategoryId = $broadcasts->category;
        return view('broadcast.edit', compact('broadcasts','categorys','selectedCategoryId','username','user_id','title','avatar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'category' => 'required',
            'broadcast_title' => 'required',
            'date' => 'required',
            'description' => 'required',
        ]);
    
        $broadcasts = Broadcast::findOrFail($id);
        $broadcasts->update([
            'user_id' => $request->user_id,
            'category' => $request->category,
            'broadcast_title' => $request->broadcast_title,
            'date' => $request->date,
            'description' => $request->description
        ]);
    
        return redirect()->route('broadcast.index')->with('success', 'Broadcast updated successfully!');
    }

    public function editCategory(Request $request, $id)
    {
        $title = 'Edit Broadcast Category';
        $avatar = $request->user()->avatar;
        $categorys = CategoryBroadcast::findOrFail($id);
        return view('broadcast.editcategory', compact('categorys','title','avatar'));
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required',
        ]);
    
        $broadcasts = CategoryBroadcast::findOrFail($id);
        $broadcasts->update([
            'category_name' => $request->category_name
        ]);
    
        return redirect()->route('broadcast.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $broadcast = Broadcast::findOrFail($id);
        $broadcast->delete();

        return redirect()->route('broadcast.index')->with('success', 'Broadcast deleted successfully!');
    }

    public function destroyCategory($id)
    {
        $categorys = CategoryBroadcast::findOrFail($id);
        $selectedCategoryId = $categorys->id;
        $isUsed = Broadcast::where('category', $selectedCategoryId)->exists();
        if ($isUsed) {
            return redirect()->route('broadcast.index')->with('danger', 'Category is used, cannot delete!');
        }
        $categorys->delete();
    
        return redirect()->route('broadcast.index')->with('success', 'Category deleted successfully!');
    }
}
