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
                    <p class="card-title">Leaves Appraisals List</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="dataTable1" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Username</th>
                                            <th>From Date - To Date</th>
                                            <th>Reason</th>
                                            <th>Picture</th>
                                            <th>Information</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0;?>
                                        @foreach($leaves as $leave)
                                        <?php $no++;?>
                                        <tr>
                                            <th width="5%">{{ $no }}</th>
                                            <td>{{$leave->username}}</td>
                                            <td>{{$leave->from_date}} - {{$leave->to_date}}</td>
                                            <td>{{$leave->reason}}</td>
                                            <td>{{$leave->picture}}</td>
                                            <td>{{$leave->information}}</td>
                                            <td>{{$leave->status}}</td>
                                            <td>
                                                <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                                    <button class="btn btn-sm btn-light dropdown-toggle" style="background-color:#2dd8eb" type="button" id="dropdownMenuLeaves" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLeaves">
                                                        <form action="{{ route('attendances.leaves.update', $leave->id) }}" method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Do you really want to accept this leave = {{ $leave->username }} ?');">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="user_id" value="{{$leave->user_id}}" required>
                                                            <input type="hidden" name="status" value="Accepted" required>
                                                            <button type="submit" class="dropdown-item"><span>Accept</span></button>
                                                        </form>
                                                        <form action="{{ route('attendances.leaves.update', $leave->id) }}" method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Do you really want to reject Leaves = {{ $leave->username }} ?');">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="user_id" value="{{$leave->user_id}}" required>
                                                            <input type="hidden" name="status" value="Rejected" required>
                                                            <button type="submit" class="dropdown-item"><span>Reject</span></button>
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
                    <p class="card-title">Leaves Appraisals History</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="dataTable2" class="table table-striped table-borderless" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Username</th>
                                            <th>From Date - To Date</th>
                                            <th>Reason</th>
                                            <th>Picture</th>
                                            <th>Information</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0;?>
                                        @foreach($leavesHistory as $history)
                                        <?php $no++;?>
                                        <tr>
                                            <th width="5%">{{ $no }}</th>
                                            <td>{{$history->username}}</td>
                                            <td>{{$history->from_date}} - {{$history->to_date}}</td>
                                            <td>{{$history->reason}}</td>
                                            <td>{{$history->picture}}</td>
                                            <td>{{$history->information}}</td>
                                            <?php
                                            switch ($history->status) {
                                                case 'Accepted':
                                                    echo "<td class='font-weight-medium'><div class='badge badge-success'>Accepted</div></td>";
                                                    break;
                                                case 'Rejected':
                                                    echo "<td class='font-weight-medium'><div class='badge badge-danger'>Rejected</div></td>";
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
    </div>
</div>
<script>
    function submitForm(no) {
        document.getElementById("statusForm"+no).submit();
    }
</script>
@endsection
