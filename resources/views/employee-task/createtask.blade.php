@extends ('layout')

@section ('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add New Task</h4>
                  <p class="card-description">
                    Form Add Task
                  </p>
                  <form class="forms-sample" action="{{ route('employee-task.storetask') }}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label for="task_id">Task Id</label>
                      <input type="text" class="form-control" id="task_id" name="task_id" placeholder="Task Id" value="{{ $newTaskId }}" readonly required>
                    </div>
                    <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control form-control-lg" name="status" id="status" required>
                        <option value="" selected="true" disabled="disabled">Choose Status</option>
                        <option value="Process">Process</option>
                        <option value="Done">Done</option>
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
