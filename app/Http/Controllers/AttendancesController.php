<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendances;
use App\Models\CategoryBroadcast;
use Illuminate\Http\Request;

class AttendancesController extends Controller
{
    public function presensi(Request $request)
    {
        $title = 'Attendances Data';
        $avatar = $request->user()->avatar;
        
        // Ambil bulan dan tahun dari URL jika tersedia
        $currentMonth = $request->input('month', date('n'));
        $currentYear = $request->input('year', date('Y'));

        // Atur bulan dan tahun dalam rentang yang valid
        if ($currentMonth < 1) {
            $currentMonth = 12;
            $currentYear--;
        } elseif ($currentMonth > 12) {
            $currentMonth = 1;
            $currentYear++;
        }

        // Ambil data kehadiran untuk bulan dan tahun yang dipilih
        $attendances = Attendances::leftJoin('users', 'attendances.user_id', '=', 'users.user_id')
            ->select('attendances.*', 'users.username')
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->get();

        $role = $request->user()->role_name;
        $status = $request->user()->status;
        $employees = [];
        $totalEmployee = 0;

        if ($role === "Super Admin" || $status == 'Active') {
            $employees = User::all();
            $totalUser = $employees->count();
        } elseif ($role === "Admin" || $status == 'Active') {
            $employees = User::where('role_name', 'Employee')->get();
            $totalEmployee = $employees->count();
        }
        
        return view('attendances.presensi.index', compact('employees', 'attendances', 'title', 'avatar', 'totalUser', 'totalEmployee', 'currentMonth', 'currentYear'));
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

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);
    
        $attendances = Attendances::findOrFail($id);
        $attendances->update([
            'status' => $request->status
        ]);
    
        return redirect()->route('attendances.presensi')->with('success', 'Status updated successfully!');
    }

    public function destroy($id)
    {
        $broadcast = Broadcast::findOrFail($id);
        $broadcast->delete();

        return redirect()->route('broadcast.index')->with('success', 'Broadcast deleted successfully!');
    }
}
