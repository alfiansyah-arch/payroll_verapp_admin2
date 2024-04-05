@extends ('layout')

@section ('content')
<div class="content-wrapper">
@if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if (session('danger'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('danger') }}
                    </div>
                    @endif
                    
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">List Pending Loans</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="dataTable1" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Username</th>
                                            <th>Loan Id</th>
                                            <th>Loan Amount</th>
                                            <th>Installments</th>
                                            <th>Loan Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0;?>
                                        @foreach($loansPending as $loanPending)
                                        <?php $no++;?>
                                        <tr>
                                            <th width="5%">{{ $no }}</th>
                                            <td>{{$loanPending->username}}</td>
                                            <td>{{$loanPending->loan_id}}</td>
                                            <td>{{$loanPending->loan_amount}}</td>
                                            <td>{{$loanPending->installments}}</td>
                                            <td>{{$loanPending->loan_date}}</td>
                                            <td class='font-weight-medium'><div class='badge badge-warning'>{{$loanPending->status}}</div></td>
                                            <td>
                                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                                    <button class="btn btn-sm btn-light dropdown-toggle" style="background-color:#2dd8eb" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                                        <!-- <a class="dropdown-item" href="#">Show</a> -->
                                                        <a class="dropdown-item" href="{{route('loans.list.edit', $loanPending->id)}}">Edit</a>
                                                        <form action="{{ route('loans.list.destroy', $loanPending->id) }}" method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Do you really want to delete Loan = {{ $loanPending->loan_id }} ?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item"><span>Delete</span></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <a class="btn btn-outline-info btn-fw" href="{{route('loans.list.create')}}">Add Loans</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">List Accepted Loans</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="dataTable2" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Username</th>
                                            <th>Loan Id</th>
                                            <th>Loan Amount</th>
                                            <th>Installments</th>
                                            <th>Loan Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0;?>
                                        @foreach($loansAccepted as $loanAccepted)
                                        <?php $no++;?>
                                        <tr>
                                            <th width="5%">{{ $no }}</th>
                                            <td>{{$loanAccepted->username}}</td>
                                            <td>{{$loanAccepted->loan_id}}</td>
                                            <td>{{$loanAccepted->loan_amount}}</td>
                                            <td>{{$loanAccepted->installments}}</td>
                                            <td>{{$loanAccepted->loan_date}}</td>
                                            <td class='font-weight-medium'><div class='badge badge-success'>{{$loanAccepted->status}}</div></td>
                                            <td>
                                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                                    <button class="btn btn-sm btn-light dropdown-toggle" style="background-color:#2dd8eb" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                                    <form action="{{ route('loans.list.completely', $loanAccepted->id) }}" method="POST" style="display: inline;"
                                                        onsubmit="return confirm('This loans is Compltely Paid Off = {{ $loanAccepted->loan_id }} ?');">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" id="status" value="Completely" required>
                                                            <button type="submit" class="dropdown-item"><span>Completely Paid Off</span></button>
                                                        </form>
                                                        <form action="{{ route('loans.list.destroy', $loanAccepted->id) }}" method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Do you really want to delete Loan = {{ $loanAccepted->loan_id }} ?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item"><span>Delete</span></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">List Rejected Loans</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="dataTable3" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Username</th>
                                            <th>Loan Id</th>
                                            <th>Loan Amount</th>
                                            <th>Installments</th>
                                            <th>Loan Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0;?>
                                        @foreach($loansRejected as $loanRejected)
                                        <?php $no++;?>
                                        <tr>
                                            <th width="5%">{{ $no }}</th>
                                            <td>{{$loanRejected->username}}</td>
                                            <td>{{$loanRejected->loan_id}}</td>
                                            <td>{{$loanRejected->loan_amount}}</td>
                                            <td>{{$loanRejected->installments}}</td>
                                            <td>{{$loanRejected->loan_date}}</td>
                                            <td class='font-weight-medium'><div class='badge badge-danger'>{{$loanRejected->status}}</div></td>
                                            <td>
                                            <form action="{{ route('loans.list.destroy', $loanRejected->id) }}" method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Do you really want to delete Loan = {{ $loanRejected->loan_id }} ?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"><span>Delete</span></button>
                                                        </form>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function submitForm(no) {
        document.getElementById("statusForm"+no).submit();
    }
</script>
@endsection
