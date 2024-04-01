@extends ('layout')

@section ('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add New Detail Task</h4>
                  <p class="card-description">
                    Form Add Detail Task for Employee
                  </p>
                  <form class="forms-sample" action="{{ route('employee-task.storetaskdetail') }}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label for="user_id">User</label>
                      <select class="form-control" id="user_id" name="user_id" required>
                          <option value="" selected disabled>Choose User</option>
                          @foreach($employees as $employee)
                              @if($employee->status == "Active")
                                  <option value="{{ $employee->user_id }}">{{ $employee->username }}</option>
                              @endif
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="task_id">Task Id</label>
                      <select class="form-control" id="task_id" name="task_id" required>
                          <option value="" selected disabled>Choose Task Id</option>
                          @foreach($tasks as $task)
                              @if($task->status == "Process")
                              <option value="{{ $task->task_id }}" id="task_{{ $task->task_id }}">{{ $task->task_id }}</option>
                              @endif
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                        <label for="no_task">Number of Task</label>
                        <input type="text" name="no_task" id="no_task" class="form-control" value="{{ $maxNoTask }}" readonly required>
                    </div>
                    <div class="form-group">
                      <label for="task_title">Title Task</label>
                      <input type="text" name="task_title" id="task_title" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label for="task_description">Description of Task</label>
                      <textarea name="task_description" id="task_description" cols="30" rows="10" class="form-control" required>Write a job description for the employee here</textarea>
                    </div>
                    <div class="form-group">
                      <label for="date_start">Start Date of Task</label>
                      <input type="date" name="date_start" id="date_start" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label for="date_end">End Date of Task</label>
                      <input type="date" name="date_end" id="date_end" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a class="btn btn-light" href="{{route('employee_task_list')}}">Cancel</a>
                  </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('task_id').addEventListener('change', function() {
        var selectedTask = this.value;
        var taskDetails = <?php echo json_encode($taskdetail); ?>;
        var maxNoTask = 1;

        taskDetails.forEach(function(detail) {
            if (detail.task_id == selectedTask) {
                maxNoTask = parseInt(detail.no_task) + 1;
            }
        });

        var noTaskInput = document.getElementById('no_task');
        noTaskInput.value = maxNoTask;
    });
</script>
@endsection
