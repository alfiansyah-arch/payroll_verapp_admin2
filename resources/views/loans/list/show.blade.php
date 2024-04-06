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
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="dataTable1" class="table">
                                <thead>
                                    <tr>
                                        <td>No.</td>
                                        <td>Username</td>
                                        <td>Id Loan</td>
                                        <td>Id Payment</td>
                                        <td>Installment</td>
                                        <td>Payment</td>
                                        <td>Due Date</td>
                                        <td>Status</td>
                                    </tr>
                                </thead>
                            <tbody>
                                        <?php $no = 0;?>
                                        @foreach($loanPayments as $loanPayment)
                                        <?php $no++;?>
                                        <tr>
                                            <th width="5%">{{ $no }}</th>
                                            <td>{{$username}}</td>
                                            <td>{{$loanPayment->loan_id}}</td>
                                            <td>{{$loanPayment->payment_id}}</td>
                                            <td>{{$loanPayment->installments}}</td>
                                            <td>Rp. {{ number_format($loanPayment->payment_per_installments, 0, ',', '.') }}</td>
                                            <td>{{$loanPayment->due_date}}</td>
                                            <?php
                                            switch ($loanPayment->status) {
                                                case 'Paid Off':
                                                    echo "<td class='font-weight-medium'><div class='badge badge-success'>Paid Off</div></td>";
                                                    break;
                                                case 'Unpaid':
                                                    echo "<td class='font-weight-medium'><div class='badge badge-danger'>Unpaid</div></td>";
                                                    break;
                                                default:
                                                    echo "<td></td>";
                                            }
                                            ?>
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
    <div class="col-md-4 grid-margin">
        <a type="button" class="btn btn-warning" href="{{route('broadcast.index')}}">Back</a>
    </div>
</div>
@endsection
