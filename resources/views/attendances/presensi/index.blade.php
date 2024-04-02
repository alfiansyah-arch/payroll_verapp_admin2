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
                                    <?php
                                    $month = date("m");
                                    $year = date("Y");
                                    if (isset($_GET['month']) && isset($_GET['year'])) {
                                        $currentMonth = $_GET['month'];
                                        $currentYear = $_GET['year'];
                    
                                        if ($currentMonth < 1) {
                                            $currentMonth = 12; 
                                            $currentYear--;
                                        } elseif ($currentMonth > 12) {
                                            $currentMonth = 1; 
                                            $currentYear++;
                                        }
                                    }
                                    $currentMonth = $currentMonth ?? date('n');
                                    $currentYear = $currentYear ?? date('Y');
                                    
                                    $firstDayOfMonth = date("$currentYear-$currentMonth-01");
                                    $totalDaysInMonth = date("t", strtotime($firstDayOfMonth));
                                    ?>
                                    <p class="card-title">Attendances Calendar</p>
                                    <p class="card-title">Month : <?php echo date("F", strtotime($firstDayOfMonth)); ?></p>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="dataTable2" class="table table-striped" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2">No.</th>
                                                            <th rowspan="2">Names</th>
                                                            <?php
                                                            for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                                                                echo "<th>$j</th>";
                                                            }
                                                            ?>
                                                        </tr>
                                                        <tr>
                                                            <?php
                                                            for ($j = 0; $j < $totalDaysInMonth; $j++) {
                                                                echo "<th>" . date("D", strtotime("$firstDayOfMonth +$j days")) . "</th>";
                                                            }
                                                            ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        foreach($employees as $employee) {
                                                            echo "<tr>";
                                                            echo "<td>" . $no++ . "</td>";
                                                            echo "<td>" . $employee->username . "</td>";
                                                            for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                                                                $date = date("$year-$month-0$j", strtotime("$firstDayOfMonth +$j days"));
                                                                $attendance = $attendances->where('user_id', $employee->user_id)
                                                                    ->where('date', $date)
                                                                    ->first();
                                                                $status = $attendance ? $attendance->status : '-';
                                                                switch ($status) {
                                                                    case 'Present':
                                                                        echo "<td>P</td>";
                                                                        break;
                                                                    case 'Sick':
                                                                        echo "<td>S</td>";
                                                                        break;
                                                                    case 'Absent':
                                                                        echo "<td>A</td>";
                                                                        break;
                                                                    case 'Leaves':
                                                                        echo "<td>L</td>";
                                                                        break;
                                                                    default:
                                                                        echo "<td></td>";
                                                                }
                                                            }
                                                            echo "</tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-3">
                                    <a href="{{ route('attendances.presensi', ['month' => $currentMonth - 1, 'year' => $currentYear]) }}" class="btn btn-primary">Back</a>
                                    <a href="{{ route('attendances.presensi', ['month' => $currentMonth + 1, 'year' => $currentYear]) }}" class="btn btn-primary">Next</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Attendances Confirmation List</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="dataTable1" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Username</th>
                                            <th>Entry / Exit Time</th>
                                            <th>Entry / Exit Location</th>
                                            <th>Entry Photo</th>
                                            <th>Exit Photo</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0;?>
                                        @foreach($attendances as $attendance)
                                        <?php $no++;?>
                                        <tr>
                                            <th width="5%">{{ $no }}</th>
                                            <td>{{$attendance->username}}</td>
                                            <td>{{$attendance->entry_time}} / {{$attendance->exit_time}}</td>
                                            <td>{{$attendance->entry_location}} / {{$attendance->exit_location}}</td>
                                            <td>{{$attendance->entry_photo}}</td>
                                            <td>{{$attendance->exit_photo}}</td>
                                            <td>
                                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                                        <form id="statusForm{{$no}}" action="{{ route('attendances.presensi.updatestatus', $attendance->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <select class="btn btn-sm btn-light dropdown-toggle" name="status" id="status{{$no}}" onchange="submitForm({{$no}})" required>
                                                                    <option value="" selected="true" disabled="disabled">Choose Status</option>
                                                                    <option value="Present" {{ $attendance->status === 'Present' ? 'selected' : '' }}>Present</option>
                                                                    <option value="Leaves" {{ $attendance->status === 'Leaves' ? 'selected' : '' }}>Leaves</option>
                                                                    <option value="Sick" {{ $attendance->status === 'Sick' ? 'selected' : '' }}>Sick</option>
                                                                    <option value="Absent" {{ $attendance->status === 'Absent' ? 'selected' : '' }}>Absent</option>
                                                                </select>
                                                            </div>
                                                        </form>
                                            </div>
                                            </td>
                                            <td>
                                                <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                                    <button class="btn btn-sm btn-light dropdown-toggle" style="background-color:#2dd8eb" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                                        <a class="dropdown-item" href="{{route('settings.departments.edit', $attendance->id)}}">Edit</a>
                                                        <form id="deleteFormTask" action="{{ route('settings.departments.destroy', $attendance->id) }}" method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Do you really want to delete Broadcast = {{ $attendance->dept_name }} ?');">
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
                                <a class="btn btn-success" href="{{route('settings.departments.create')}}">Add Broadcast</a>
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
