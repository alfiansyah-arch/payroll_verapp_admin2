@extends ('layout')

@section ('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Position</h4>
                  <p class="card-description">
                    Form Edit Position
                  </p>
                  <form class="forms-sample" action="{{ route('settings.positions.update', $positions->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="dept_id">Department</label>
                        <select class="form-control" id="dept_id" name="dept_id" required>
                            <option value="" selected="true" disabled="disabled">Choose Department</option>
                            @foreach($departments as $department)
                              <option value="{{ $department->dept_id }}" {{ $selectedDepartment == $department->dept_id ? 'selected' : '' }}>{{ $department->dept_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="position_name">Position Name</label>
                      <input type="text" class="form-control" id="position_name" name="position_name" value="{{$positions->position_name}}" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a class="btn btn-light" href="{{route('settings.positions')}}">Cancel</a>
                  </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
