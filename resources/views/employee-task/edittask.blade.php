@extends ('layout')

@section ('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Old Task</h4>
                  <p class="card-description">
                    Form Edit Task
                  </p>
                  <form class="forms-sample" action="{{ route('employee-task.updatetask', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="task_id">Task Id</label>
                      <input type="text" class="form-control" id="task_id" name="task_id" placeholder="Task Id" value="{{$task->task_id}}" readonly required>
                    </div>
                    <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control form-control-lg" name="status" id="status" required>
                        <option value="" selected="true" disabled="disabled">Choose Status</option>
                        <option value="Process" {{ $task->status === 'Process' ? 'selected' : '' }}>Process</option>
                        <option value="Done" {{ $task->status === 'Done' ? 'selected' : '' }}>Done</option>
                    </select>
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
@endsection
