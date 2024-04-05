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
                                                <table id="dataTable2" class="table table-sm table-hover" style="width:100%">
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
                                                                $date = date("$year-$month-" . sprintf("%02d", $j), strtotime("$firstDayOfMonth +$j days"));
                                                                $attendance = $attendances->where('user_id', $employee->user_id)
                                                                    ->where('date', $date)
                                                                    ->first();
                                                                $status = $attendance ? $attendance->status : '-';
                                                                switch ($status) {
                                                                    case 'Present':
                                                                        echo "<td style='background-color:#00c013;color:white;text-align:center;'><p style='font-size:12px;'><b>P</b></p></td>";
                                                                        break;
                                                                    case 'Sick':
                                                                        echo "<td style='background-color:#ffcf24;color:white;text-align:center;'><p style='font-size:12px;'><b>S</b></p></td>";
                                                                        break;
                                                                    case 'Absent':
                                                                        echo "<td style='background-color:#c20000;color:white;text-align:center;'><p style='font-size:12px;'><b>A</b></p></td>";
                                                                        break;
                                                                    case 'Leaves':
                                                                        echo "<td style='background-color:#818181;color:white;text-align:center;'><p style='font-size:12px;'><b>L</b></p></td>";
                                                                        break;
                                                                    case 'Absent Permission':
                                                                        echo "<td style='background-color:#4379ee;color:white;text-align:center;'><p style='font-size:12px;'><b>AP</b></p></td>";
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
                                            <th>Date</th>
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
                                            <td>{{$attendance->date}}</td>
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
                                                                    <option value="Absent Permission" {{ $attendance->status === 'Absent Permission' ? 'selected' : '' }}>Absent Permission</option>
                                                                </select>
                                                            </div>
                                                        </form>
                                            </div>
                                            </td>
                                            <td>
                                                        <form id="deleteFormTask" action="{{ route('attendances.presensi.destroy', $attendance->id) }}" method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Do you really want to delete This Attendance with Username = {{ $attendance->username }} and Date = {{$attendance->date}}?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-light" style="background-color:#c20000;color:white"><span>Delete</span></button>
                                                        </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- <a class="btn btn-success" href="{{route('settings.departments.create')}}">Add Broadcast</a> -->
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
