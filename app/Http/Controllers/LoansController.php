<?php

namespace App\Http\Controllers;

use App\Models\Installments;
use App\Models\Interests;
use App\Models\Loans;
use App\Models\User;
use App\Models\LoansPayments;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoansController extends Controller
{
    // Fungsi Presensi
    public function index(Request $request)
    {
        $title = 'List Loans';
        $avatar = $request->user()->avatar;

        $loansPending = Loans::leftJoin('users', 'loans.user_id', '=', 'users.user_id')
            ->select('loans.*','users.username')
            ->where('loans.status', '=', 'Pending')
            ->get();

        $loansAccepted = Loans::leftJoin('users', 'loans.user_id', '=', 'users.user_id')
        ->select('loans.*','users.username')
        ->where('loans.status', '=', 'Accepted')
        ->get();

        $loansRejected = Loans::leftJoin('users', 'loans.user_id', '=', 'users.user_id')
        ->select('loans.*','users.username')
        ->where('loans.status', '=', 'Rejected')
        ->get();

        $role = $request->user()->role_name;
        $status = $request->user()->status;
        $employees = [];

        if ($role === "Super Admin" || $status == 'Active') {
            $employees = User::all();
        } elseif ($role === "Admin" || $status == 'Active') {
            $employees = User::where('role_name', 'Employee')->get();
        }
        
        return view('loans.list.index', compact('employees', 'loansPending','loansAccepted','loansRejected', 'title', 'avatar'));
    }

    public function create(Request $request)
    {
        $title = 'Add New Loan';
        $avatar = $request->user()->avatar;
        $users = User::where('status', 'Active')->get();
        
        $maxLoanId = Loans::max('loan_id');
        if ($maxLoanId !== null) {
            preg_match('/(\d+)$/', $maxLoanId, $matches);
            $lastNumber = (int)$matches[1];
            $newNumber = $lastNumber + 1;
            $newLoanId = 'loan_#' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        } else {
            $newLoanId = 'loan_#0001';
        }
    
        $installments = Installments::all();
        $interests = Interests::orderBy('id', 'asc')->first()->interest_amount;
        return view('loans.list.create', compact('title', 'installments', 'interests', 'users', 'newLoanId', 'avatar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'loan_id' => 'required',
            'loan_amount' => 'required',
            'installments' => 'required',
            'loan_date' => 'required',
            'status' => 'required',
        ]);

        $data = $request->all();

        $loans = new Loans();
        $loans->user_id = $data['user_id'];
        $loans->loan_id = $data['loan_id'];

        $loans->loan_amount = str_replace('.', '', $data['loan_amount']);
        $loans->installments = $data['installments'];
        $loans->loan_date = $data['loan_date'];
        $loans->status = $data['status'];
        $loans->interest = $data['interest'];

        $loans->save();

        if ($request->status === 'Accepted') {
            $loan_amount = $loans->loan_amount;
            $installments = $request->installments;
            $interest = $loans->interest;
            
            $interest = Interests::orderBy('id', 'asc')->first()->interest_amount;

            $payment_per_installments = ($loan_amount / $installments) + (($loan_amount / $installments) * ($interest / 100));

            $due_date = Carbon::parse($request->loan_date)->addMonth();

            for ($i = 1; $i <= $installments; $i++) {
                $payment_id = 'payment_#' . str_pad($i, 2, '0', STR_PAD_LEFT);
                LoansPayments::create([
                    'payment_id' => $payment_id,
                    'loan_id' => $loans->loan_id,
                    'installments' => $installments,
                    'total_loan' => $loan_amount,
                    'interest' => $interest,
                    'payment_per_installments' => $payment_per_installments,
                    'status' => 'Unpaid',
                    'due_date' => $due_date->format('Y-m-d'),
                ]);
                $due_date->addMonth();
            }
        }

        return redirect()->route('loans.list')->with('success', 'Loan added successfully');
    }   

    public function edit(Request $request, $id)
    {
        $title = 'Edit Loans';
        $avatar = $request->user()->avatar;
        $users = User::all();
        $loans = Loans::leftJoin('users', 'loans.user_id', '=', 'users.user_id')
        ->select('loans.*', 'users.username')
        ->findOrFail($id);
        $installments = Installments::all();
        $selectedInstallments = $loans->installments;
        return view('loans.list.edit', compact('loans','selectedInstallments','users','installments','title','avatar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'loan_id' => 'required',
            'loan_amount' => 'required',
            'installments' => 'required',
            'loan_date' => 'required',
            'status' => 'required',
        ]);

        $loans = Loans::findOrFail($id);

        $loan_amount = str_replace(['.', ','], '', $request->loan_amount);
        $interest = $request->interest;

        $loans->update([
            'loan_id' => $request->loan_id,
            'loan_amount' => $loan_amount,
            'installments' => $request->installments,
            'loan_date' => $request->loan_date,
            'status' => $request->status,
            'interest' => $interest,
        ]);

        if ($request->status === 'Accepted') {
            $loan_amount = $loans->loan_amount;
            $installments = $request->installments;

            $payment_per_installments = ($loan_amount / $installments) + (($loan_amount / $installments) * ($interest / 100));

            $due_date = Carbon::parse($request->loan_date)->addMonth();

            LoansPayments::where('loan_id', $loans->loan_id)->delete();

            for ($i = 1; $i <= $installments; $i++) {
                $payment_id = 'payment_#' . str_pad($i, 2, '0', STR_PAD_LEFT);
                LoansPayments::create([
                    'payment_id' => $payment_id,
                    'loan_id' => $loans->loan_id,
                    'installments' => $installments,
                    'total_loan' => $loan_amount,
                    'interest' => $interest,
                    'payment_per_installments' => $payment_per_installments,
                    'status' => 'Unpaid',
                    'due_date' => $due_date->format('Y-m-d'),
                ]);
                $due_date->addMonth();
            }
        }
        return redirect()->route('loans.list')->with('success', 'Loan updated successfully');
    }

    public function destroy($id)
    {
        $loans = Loans::findOrFail($id);
        $loans->delete();
    
        return redirect()->route('loans.list')->with('success', 'Loan deleted successfully!');
    }

    public function show(Request $request, $id)
    {
        $title = 'Show Loans';
        $avatar = $request->user()->avatar;

        try {
            $loan = Loans::findOrFail($id);
            
            $loanPayments = LoansPayments::where('loan_id', $loan->loan_id)->get();
            $username = User::where('user_id', $loan->user_id)->value('username');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('danger', 'Loan not found.');
        }
        
        return view('loans.list.show', compact('loan', 'loanPayments','username', 'title', 'avatar'));
    }    

    public function completely(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $loans = Loans::findOrFail($id);

        $loans->update([
            'status' => $request->status,
        ]);
        return redirect()->route('loans.list')->with('success', 'Loan updated successfully');
    }
}
