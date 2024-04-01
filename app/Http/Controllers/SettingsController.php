<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Loans;
use App\Models\Departments;
use App\Models\Positions;
use App\Models\Installments;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    // Controller Department
    public function departments(Request $request)
    {
        $title = 'Settings Fill Departments';
        $avatar = $request->user()->avatar;
        $departments = Departments::all();
        $role = $request->user()->role_name;
        $status = $request->user()->status;
        if ($role === "Super Admin" || $status == 'Active') {
            $employees = User::all();
        } elseif ($role === "Admin" || $status == 'Active') {
            $employees = User::where('role_name', 'Employee')->get();
        }
        return view('settings.departments.index', compact('employees','departments', 'title','avatar'));
    }

    public function createDepartment(Request $request)
    {
        $title ='Add New Department';
        $avatar = $request->user()->avatar;
        $departments = Departments::all();
        $maxDeptId = Departments::max('dept_id');
        if ($maxDeptId !== null) {
            preg_match('/(\d+)$/', $maxDeptId, $matches);
            $lastNumber = (int)$matches[1];
            $newNumber = $lastNumber + 1;
            $newDeptId = 'dept_' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
        } else {
            $newDeptId = 'dept_01';
        }
        return view('settings.departments.create', compact('title','newDeptId','departments','avatar'));
    }

    public function storeDepartment(Request $request)
    {
        $request->validate([
            'dept_id' => 'required',
            'dept_name' => 'required',
        ]);

        $data = $request->all();

        $department = new Departments();
        $department->dept_id = $data['dept_id'];
        $department->dept_name = $data['dept_name'];

        $department->save();

        return redirect()->route('settings.departments')->with('success', 'Department added successfully');
    }
    

    public function editDepartment(Request $request, $id)
    {
        $title = 'Edit Data Department';
        $avatar = $request->user()->avatar;
        $departments = Departments::findOrFail($id);
        return view('settings.departments.edit', compact('departments','title','avatar'));
    }

    public function updateDepartment(Request $request, $id)
    {
        $request->validate([
            'dept_name' => 'required',
        ]);
    
        $department = Departments::findOrFail($id);
        $department->update([
            'dept_name' => $request->dept_name
        ]);
    
        return redirect()->route('settings.departments')->with('success', 'Department updated successfully!');
    }

    public function destroyDepartment($dept_id)
    {
        $department = Departments::where('dept_id', $dept_id)->firstOrFail();
        $selectedDepartment = $department->dept_id;
        $isUsedEmployee = User::where('department', $selectedDepartment)->exists();
        if ($isUsedEmployee) {
            return redirect()->route('employees_data')->with('danger', 'Department is used in Employee, cannot delete!');
        }
        $isUsedPosition = Positions::where('dept_id', $selectedDepartment)->exists();
        if ($isUsedPosition) {
            return redirect()->route('employees_data')->with('danger', 'Department is used in Position, cannot delete!');
        }
        $department->delete();
    
        return redirect()->route('settings.departments')->with('success', 'Department deleted successfully!');
    }

    // End Controller Department
    // ----------------------------------------------------------------------------------------------------------

    // Controller Position
    public function positions(Request $request)
    {
        $title = 'Settings Fill Positions';
        $avatar = $request->user()->avatar;
        $positions = Positions::leftJoin('departments', 'positions.dept_id', '=', 'departments.dept_id')
        ->select('positions.*', 'departments.dept_name')
        ->get();
        $role = $request->user()->role_name;
        $status = $request->user()->status;
        if ($role === "Super Admin" || $status == 'Active') {
            $employees = User::all();
        } elseif ($role === "Admin" || $status == 'Active') {
            $employees = User::where('role_name', 'Employee')->get();
        }
        return view('settings.positions.index', compact('employees','positions', 'title','avatar'));
    }

    public function createPosition(Request $request)
    {
        $title ='Add New Positions';
        $avatar = $request->user()->avatar;
        $positions = Positions::all();
        $departments = Departments::all();
        return view('settings.positions.create', compact('title','positions','departments','avatar'));
    }

    public function storePosition(Request $request)
    {
        $request->validate([
            'dept_id' => 'required',
            'position_name' => 'required',
        ]);

        $data = $request->all();

        $positions = new Positions();
        $positions->dept_id = $data['dept_id'];
        $positions->position_name = $data['position_name'];

        $positions->save();

        return redirect()->route('settings.positions')->with('success', 'Position added successfully');
    }
    

    public function editPosition(Request $request, $id)
    {
        $title = 'Edit Data Positions';
        $avatar = $request->user()->avatar;
        $positions = Positions::findOrFail($id);
        $departments = Departments::all();
        $selectedDepartment = $positions->dept_id;
        return view('settings.positions.edit', compact('positions','departments','title','avatar','selectedDepartment'));
    }

    public function updatePosition(Request $request, $id)
    {
        $request->validate([
            'dept_id' => 'required',
            'position_name' => 'required',
        ]);
    
        $positions = Positions::findOrFail($id);
        $positions->update([
            'dept_id' => $request->dept_id,
            'position_name' => $request->position_name
        ]);
    
        return redirect()->route('settings.positions')->with('success', 'Position updated successfully!');
    }

    public function destroyPosition($id)
    {
        $positons = Positions::findOrFail($id);
        $selectedPosition = $positons->id;
        $isUsed = User::where('position', $selectedPosition)->exists();
        if ($isUsed) {
            return redirect()->route('employees_data')->with('danger', 'Position is used, cannot delete!');
        }
        $positons->delete();
    
        return redirect()->route('settings.positions')->with('success', 'Position deleted successfully!');
    }

    // End Controller Positions
    // ----------------------------------------------------------------------------------------------------------

    // Controller Installsments

    public function installsments(Request $request)
    {
        $title = 'Settings Fill Installments';
        $avatar = $request->user()->avatar;
        $installments = Installments::all();
        $role = $request->user()->role_name;
        $status = $request->user()->status;
        if ($role === "Super Admin" || $status == 'Active') {
            $employees = User::all();
        } elseif ($role === "Admin" || $status == 'Active') {
            $employees = User::where('role_name', 'Employee')->get();
        }
        return view('settings.installments.index', compact('installments', 'title','avatar'));
    }

    public function createInstallments(Request $request)
    {
        $title ='Add New Installments';
        $avatar = $request->user()->avatar;
        $installments = Installments::all();
        return view('settings.installments.create', compact('title','installments','avatar'));
    }

    public function storeInstallments(Request $request)
    {
        $request->validate([
            'installments_amount' => 'required',
        ]);

        $data = $request->all();

        $installments = new Installments();
        $installments->installments_amount = $data['installments_amount'];

        $installments->save();

        return redirect()->route('settings.installments')->with('success', 'Installment added successfully');
    }
    

    public function editInstallments(Request $request, $id)
    {
        $title = 'Edit Data Installment';
        $avatar = $request->user()->avatar;
        $installments = Installments::findOrFail($id);
        return view('settings.installments.edit', compact('installments','title','avatar'));
    }

    public function updateInstallments(Request $request, $id)
    {
        $request->validate([
            'installments_amount' => 'required',
        ]);
    
        $installments = Installments::findOrFail($id);
        $installments->update([
            'installments_amount' => $request->installments_amount
        ]);
    
        return redirect()->route('settings.installments')->with('success', 'Installments updated successfully!');
    }

    public function destroyInstallments($id)
    {
        $installments = Installments::findOrFail($id);
        $selectedInstallments = $installments->id;
        $isUsed = Loans::where('installments', $selectedInstallments)->exists();
        if ($isUsed) {
            return redirect()->route('settings.installments')->with('danger', 'Installments is used, cannot delete!');
        }
        $installments->delete();
    
        return redirect()->route('settings.installments')->with('success', 'Installments deleted successfully!');
    }

    // End Controller Installsment
    // ----------------------------------------------------------------------------------------------------------
}