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
                    <p class="card-title">Payroll Data</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="dataTable1" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th hidden>Id Payroll</th>
                                            <th>Username</th>
                                            <th>Basic Salary</th>
                                            <th>Meal</th>
                                            <th>Transportation</th>
                                            <th>Family</th>
                                            <th>Positional</th>
                                            <th>Total Salary</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0;
                                        $characters = 'abcdefghijklmnopqrstuvwxyz1234567890';
                                        $charactersLength = strlen($characters);
                                        $randomString = '';
                                        $randomString2 = '';
                                        for ($i = 0; $i < 2; $i++) {
                                            $randomString .= $characters[rand(0, $charactersLength - 1)];
                                            $randomString2 .= $characters[rand(0, $charactersLength - 1)];
                                        }
                                        ?>
                                        @foreach($payrolls as $payroll)
                                        <?php $no++;
                                        $totalSalary = $payroll->basic_salary + $payroll->meal_allowance + $payroll->transportation_money + $payroll->family_allowance + $payroll->positional_allowance;
                                         ?>
                                        <tr>
                                            <th width="5%">{{ $no }}</th>
                                            <td hidden>Payroll_#{{$randomString}}{{$payroll->id}}{{$randomString2}}</td>
                                            <td>{{$payroll->username}}</td>
                                            <td width="20%">Rp. {{ number_format($payroll->basic_salary, 0, ',', '.') }}</td>
                                            <td width="15%">Rp. {{ number_format($payroll->meal_allowance, 0, ',', '.') }}</td>
                                            <td width="10%">Rp. {{ number_format($payroll->transportation_money, 0, ',', '.') }}</td>
                                            <td width="20%">Rp. {{ number_format($payroll->family_allowance, 0, ',', '.') }}</td>
                                            <td width="15%">Rp. {{ number_format($payroll->positional_allowance, 0, ',', '.') }}</td>
                                            <td width="35%">Rp. {{ number_format($totalSalary, 0, ',', '.') }}</td>
                                            <td width="5%">
                                                <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                                    <button class="btn btn-sm btn-light dropdown-toggle" style="background-color:#2dd8eb" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                                        <a class="dropdown-item" href="{{route('payroll.edit', $payroll->id)}}">Edit</a>
                                                        <form id="deleteFormTask" action="{{ route('payroll.destroy', $payroll->id) }}" method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Do you really want to delete Payroll = {{ $payroll->username }} ?');">
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
                                <a class="btn btn-success" href="{{route('payroll.create')}}">Add Payroll</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete() {
        if (confirm('Are you sure you want to delete this employee?')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>
@endsection
