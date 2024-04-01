<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Departments;
use App\Models\Positions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function getPositions($departmentId)
    {
        $positions = Positions::where('dept_id', $departmentId)->get();
        return response()->json($positions);
    }
    public function index(Request $request)
    {
        $title = 'Data Account Employee';
        $avatar = $request->user()->avatar;
        $users = User::leftJoin('departments', 'users.department', '=', 'departments.dept_id')
        ->leftJoin('positions', 'users.position', '=', 'positions.id')
        ->select('users.*', 'departments.dept_name', 'positions.position_name')
        ->get();
        $role = $request->user()->role_name;
        $status = $request->user()->status;
        if ($role === "Super Admin" || $status == 'Active') {
            $employees = User::all();
        } elseif ($role === "Admin" || $status == 'Active') {
            $employees = User::where('role_name', 'Employee')->get();
        }
        return view('employees.employee_data', compact('employees','users', 'title','avatar'));
    }

    public function create(Request $request)
    {
        $title ='Add New Employee';
        $avatar = $request->user()->avatar;
        $maxUserId = User::max('user_id');
        if ($maxUserId !== null) {
            preg_match('/(\d+)$/', $maxUserId, $matches);
            $lastNumber = (int)$matches[1];
            $newNumber = $lastNumber + 1;
            $newUserId = 'user_' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        } else {
            $newUserId = 'user_0001';
        }
        $departments = Departments::all();
        $positions = Positions::all();
        return view('employees.createusers', compact('title','newUserId','departments','positions','avatar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|unique:users',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'role_name' => 'required',
            'status' => 'required',
            'department' => 'required',
            'position' => 'required',
            'password' => 'required|min:8',
        ]);

        $data = $request->all();

        $user = new User();
        $user->user_id = $data['user_id'];
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->role_name = $data['role_name'];
        $user->status = $data['status'];
        $user->department = $data['department'];
        $user->position = $data['position'];
        $user->join_date = date('Y-m-d');
        $user->avatar = 'default.jpg';
        $user->password = Hash::make($data['password']);

        $user->save();

        return redirect()->route('employees_data')->with('success', 'Employee added successfully');
    }
    

    public function edit(Request $request, $id)
    {
        $title = 'Edit Data Employee';
        $avatar = $request->user()->avatar;
        $employee = User::findOrFail($id);
        $departments = Departments::all();
        $positions = Positions::all();
        return view('employees.editusers', compact('employee', 'departments', 'positions', 'title','avatar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'role_name' => 'required',
            'status' => 'required',
            'department' => 'required',
            'position' => 'required',
            'password' => 'required|min:8',
        ]);
    
        $employee = User::findOrFail($id);
        $employee->update([
            'username' => $request->username,
            'email' => $request->email,
            'role_name' => $request->role_name,
            'status' => $request->status,
            'department' => $request->department,
            'position' => $request->position,
            'password' => Hash::make($request->password)
        ]);
    
        return redirect()->route('employees_data')->with('success', 'Employee updated successfully!');
    }

    public function destroy($id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees_data')->with('success', 'Employee deleted successfully!');
    }
}
