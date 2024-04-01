<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payrolls;
use App\Models\Departments;
use App\Models\Positions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Data Account Employee';
        $avatar = $request->user()->avatar;
        $payrolls = Payrolls::leftJoin('users', 'payrolls.user_id', '=', 'users.user_id')
        ->select('payrolls.*', 'users.username')
        ->get();
        $role = $request->user()->role_name;
        $status = $request->user()->status;
        if ($role === "Super Admin" || $status == 'Active') {
            $employees = User::all();
        } elseif ($role === "Admin" || $status == 'Active') {
            $employees = User::where('role_name', 'Employee')->get();
        }
        return view('payroll.index', compact('employees','payrolls', 'title','avatar'));
    }

    public function create(Request $request)
    {
        $title ='Add New Payroll';
        $avatar = $request->user()->avatar;
        $users = User::whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('payrolls')
                  ->whereRaw('payrolls.user_id = users.user_id');
        })->where('status', 'Active')->get();
        $departments = Departments::all();
        $positions = Positions::all();
        return view('payroll.create', compact('title','users','departments','positions','avatar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'basic_salary' => 'required',
            'meal_allowance' => 'required',
            'transportation_money' => 'required',
            'family_allowance' => 'required',
            'positional_allowance' => 'required',
        ]);

        $data = $request->all();

        $payroll = new Payrolls();
        $payroll->user_id = $data['user_id'];
        $payroll->basic_salary = $data['basic_salary'];
        $payroll->meal_allowance = $data['meal_allowance'];
        $payroll->transportation_money = $data['transportation_money'];
        $payroll->family_allowance = $data['family_allowance'];
        $payroll->positional_allowance = $data['positional_allowance'];

        $payroll->save();

        return redirect()->route('payroll.index')->with('success', 'Payroll added successfully');
    }
    

    public function edit(Request $request, $id)
    {
        $title = 'Edit Data Payroll';
        $avatar = $request->user()->avatar;
        $payroll = Payrolls::findOrFail($id);
        $departments = Departments::all();
        $positions = Positions::all();
        return view('payroll.edit', compact('payroll', 'departments', 'positions', 'title','avatar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'basic_salary' => 'required',
            'meal_allowance' => 'required',
            'transportation_money' => 'required',
            'family_allowance' => 'required',
            'positional_allowance' => 'required',
        ]);
    
        $payroll = Payrolls::findOrFail($id);
        $payroll->update([
            'basic_salary' => $request->basic_salary,
            'meal_allowance' => $request->meal_allowance,
            'transportation_allowance' => $request->transportation_allowance,
            'family_allowance' => $request->family_allowance,
            'positional_allowance' => $request->positional_allowance
        ]);
    
        return redirect()->route('payroll.index')->with('success', 'Payroll updated successfully!');
    }

    public function destroy($id)
    {
        $payroll = Payrolls::findOrFail($id);
        $payroll->delete();

        return redirect()->route('payroll.index')->with('success', 'Payroll deleted successfully!');
    }
}
