<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Departments;
use App\Models\Positions;
use App\Models\EmployeeTask;
use App\Models\EmployeeTaskDetail;

class EmployeeTaskController extends Controller
{
    public function index(Request $request)
    {
        $title = 'List of Employee Task';
        $avatar = $request->user()->avatar;
        $employeetask = EmployeeTask::all();
        $employeetaskdetail = EmployeeTaskDetail::leftJoin('users', 'employee_task_details.user_id', '=', 'users.user_id')
        ->select('employee_task_details.*', 'users.username')
        ->get();
        $role = $request->user()->role_name;
        $status = $request->user()->status;
        if ($role === "Super Admin" || $status == 'Active') {
            $employees = User::all();
        } elseif ($role === "Admin" || $status == 'Active') {
            $employees = User::where('role_name', 'Employee')->get();
        }
        return view('employee-task.employee_task_list', compact('employees', 'title','avatar','employeetask','employeetaskdetail'));
    }

    public function create_task(Request $request)
    {
        $title ='Add New Employee';
        $avatar = $request->user()->avatar;
        $maxTaskId = EmployeeTask::max('task_id');
        if ($maxTaskId !== null) {
            preg_match('/(\d+)$/', $maxTaskId, $matches);
            $lastNumber = (int)$matches[1]; 
            $newNumber = $lastNumber + 1;
            $newTaskId = 'task_#' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
        } else {
            $newTaskId = 'task_#00001';
        }
        $departments = Departments::all();
        $positions = Positions::all();
        return view('employee-task.createtask', compact('title','newTaskId','departments','positions','avatar'));
    }

    public function storetask(Request $request)
    {
        $request->validate([
            'task_id' => 'required|unique:employee_tasks',
            'status' => 'required',
        ]);

        $data = $request->all();

        $task = new EmployeeTask();
        $task->task_id = $data['task_id'];
        $task->status = $data['status'];

        $task->save();

        return redirect()->route('employee_task_list')->with('success', 'Task added successfully');
    }

    public function create_task_detail(Request $request)
    {
        $title ='Add New Detail Task for Employee';
        $avatar = $request->user()->avatar;
        $tasks = EmployeeTask::all();
        $taskdetail = EmployeeTaskDetail::all();
        $employees = User::all();
        $selectedTaskId = $request->input('task_id');
        $existingTask = EmployeeTaskDetail::where('task_id', $selectedTaskId)->first();
        if ($existingTask) {
            $maxNoTask = EmployeeTaskDetail::where('task_id', $selectedTaskId)->max('no_task') + 1;
        } else {
            $maxNoTask = 1;
        }
        return view('employee-task.createtaskdetail', compact('title','tasks','taskdetail','employees','avatar','maxNoTask'));
    }
    

    public function storetaskdetail(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'task_id' => 'required',
            'no_task' => 'required',
            'task_description' => 'required|min:30',
            'date_start' => 'required',
            'date_end' => 'required',
            'task_title' => 'required',
        ]);

        $data = $request->all();

        $taskdetail = new EmployeeTaskDetail();
        $taskdetail->user_id = $data['user_id'];
        $taskdetail->task_id = $data['task_id'];
        $taskdetail->task_title = $data['task_title'];
        $taskdetail->task_description = $data['task_description'];
        $taskdetail->no_task = $data['no_task'];
        $taskdetail->date_start = $data['date_start'];
        $taskdetail->date_end = $data['date_end'];
        $taskdetail->status = 'Pending';

        $taskdetail->save();

        return redirect()->route('employee_task_list')->with('success', 'Detail Task added successfully');
    }
    

    public function edittask(Request $request, $id)
    {
        $title = 'Edit Old Task Id';
        $avatar = $request->user()->avatar;
        $task = EmployeeTask::findOrFail($id);
        return view('employee-task.edittask', compact('task', 'title', 'avatar'));
    }

    public function updatetask(Request $request, $id)
    {
        $request->validate([
            'task_id' => 'required',
            'status' => 'required',
        ]);
    
        $task = EmployeeTask::findOrFail($id);
        $task->update([
            'task_id' => $request->task_id,
            'status' => $request->status
        ]);
    
        return redirect()->route('employee_task_list')->with('success', 'Task updated successfully!');
    }

    public function edittaskdetail(Request $request, $id)
    {
        $title = 'Edit Old Task Id';
        $avatar = $request->user()->avatar;
        $tasks = EmployeeTask::all();
        $taskdetail = EmployeeTaskDetail::findOrFail($id);
        $no_taskedit = EmployeeTaskDetail::all();
        $employees = User::all();
        $selectedTaskId = $request->input('task_id');
        $existingTask = EmployeeTaskDetail::where('task_id', $selectedTaskId)->first();
        if ($existingTask) {
            $maxNoTask = EmployeeTaskDetail::where('task_id', $selectedTaskId)->max('no_task') + 1;
        } else {
            $maxNoTask = 1;
        }
        return view('employee-task.edittaskdetail', compact('tasks','taskdetail','no_taskedit','employees', 'title', 'avatar','maxNoTask'));
    }

    public function updatetaskdetail(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'task_id' => 'required',
            'no_task' => 'required',
            'task_description' => 'required|min:30',
            'date_start' => 'required',
            'date_end' => 'required',
            'task_title' => 'required',
            'status' => 'required',
        ]);
    
        $task = EmployeeTaskDetail::findOrFail($id);
        $task->update([
            'user_id' => $request->user_id,
            'task_id' => $request->task_id,
            'no_task' => $request->no_task,
            'task_description' => $request->task_description,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'task_title' => $request->task_title,
            'status' => $request->status
        ]);
    
        return redirect()->route('employee_task_list')->with('success', 'Detail Task updated successfully!');
    }

    public function destroytask($id)
    {
        $task = EmployeeTask::findOrFail($id);
    
        $selectedTaskId = $task->task_id;

        $isUsed = EmployeeTaskDetail::where('task_id', $selectedTaskId)->exists();
    
        if ($isUsed) {
            return redirect()->route('employee_task_list')->with('danger', 'Task Id is used, cannot delete!');
        }
        $task->delete();
    
        return redirect()->route('employee_task_list')->with('success', 'Task deleted successfully!');
    }

    public function destroytaskdetail($id)
    {
        $taskdetails = EmployeeTaskDetail::findOrFail($id);
        $taskdetails->delete();

        return redirect()->route('employee_task_list')->with('success', 'Detail Task deleted successfully!');
    }
}
