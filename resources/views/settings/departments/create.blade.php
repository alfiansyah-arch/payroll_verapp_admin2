@extends ('layout')

@section ('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add New Department</h4>
                  <p class="card-description">
                    Form Add Department
                  </p>
                  <form class="forms-sample" action="{{ route('settings.departments.store') }}" method="POST">
                    @csrf
                    <div class="form-group" hidden>
                      <label for="dept_id">Department Id</label>
                      <input type="hidden" class="form-control" id="dept_id" name="dept_id" value="{{$newDeptId}}" required>
                    </div>
                    <div class="form-group">
                      <label for="dept_name">Department Name</label>
                      <input type="text" class="form-control" id="dept_name" name="dept_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a class="btn btn-light" href="{{route('settings.departments')}}">Cancel</a>
                  </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
