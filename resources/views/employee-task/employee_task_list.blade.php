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
                    <p class="card-title">List of Employee Task</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="dataTable1" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Task Id</th>
                                            <th>Username</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>No. Task</th>
                                            <th>Date Start / Date End</th>
                                            <th>Status</th>
                                            <th>Attachment</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach($employeetaskdetail as $detail_task)
                                        <?php $no++ ?>
                                        <tr>
                                            <th scope="row">{{ $no }}</th>
                                            <td>{{$detail_task->task_id}}</td>
                                            <td>{{$detail_task->username}}</td>
                                            <td>{{$detail_task->task_title}}</td>
                                            <td>{{$detail_task->task_description}}</td>
                                            <td>{{$detail_task->no_task}}</td>
                                            <td>{{$detail_task->date_start}} / {{$detail_task->date_end}}</td>
                                            <td>{{$detail_task->status}}</td>
                                            <td>{{$detail_task->attachment}}</td>
                                            <td>
                                                <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                                    <button class="btn btn-sm btn-light dropdown-toggle" style="background-color:#2dd8eb" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                                        <a class="dropdown-item" href="#">View</a>
                                                        <a class="dropdown-item" href="{{route('employee-task.edittaskdetail', $detail_task->id)}}">Edit</a>
                                                        <form id="deleteFormTaskDetail" action="{{ route('employee-task.destroytaskdetail', $detail_task->id) }}" method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Do you really want to delete Task Id = {{ $detail_task->task_id }} Number of Task = {{ $detail_task->no_task }}?');">
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
                                <a class="btn btn-success" href="{{route('employee-task.createtaskdetail')}}">Add User Task</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">List of Task Id</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="dataTable2" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Task Id</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach($employeetask as $task)
                                        <?php $no++ ?>
                                        <tr>
                                            <th scope="row">{{ $no }}</th>
                                            <td>{{$task->task_id}}</td>
                                            <td>{{$task->status}}</td>
                                            <td>
                                                <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                                    <button class="btn btn-sm btn-light dropdown-toggle" style="background-color:#2dd8eb" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                                        <a class="dropdown-item" href="#">View</a>
                                                        <a class="dropdown-item" href="{{route('employee-task.edittask', $task->id)}}">Edit</a>
                                                        <form id="deleteFormTask" action="{{ route('employee-task.destroytask', $task->id) }}" method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Do you really want to delete Task Id = {{ $task->task_id }} ?');">
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
                                <a class="btn btn-success" href="{{route('employee-task.createtask')}}">Add New Task</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-tale">
                    <div class="card-body">
                      <p class="mb-4">Task Done</p>
                      <p class="fs-30 mb-2">4006</p>
                      <p>10.00% (30 days)</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-dark-blue">
                    <div class="card-body">
                      <p class="mb-4">Task Progress</p>
                      <p class="fs-30 mb-2">61344</p>
                      <p>22.00% (30 days)</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
    </div>
</div>
<script>
    function confirmDeleteTask(taskId) {
        if (confirm('Are you sure you want to delete this task with id = ' + taskId + '?')) {
            document.getElementById('deleteFormTask').submit();
        } else {
            return false;
        }
    }

    function confirmDeleteTaskDetail(taskId, noTask) {
        if (confirm('Are you sure you want to delete Task Id = ' + taskId + ' Number = ' + noTask + '?')) {
            document.getElementById('deleteFormTaskDetail').submit();
        } else {
            return false;
        }
    }
</script>
@endsection
