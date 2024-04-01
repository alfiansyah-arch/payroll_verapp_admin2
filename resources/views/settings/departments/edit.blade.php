@extends ('layout')

@section ('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Broadcast</h4>
                  <p class="card-description">
                    Form Edit Broadcast
                  </p>
                  <form class="forms-sample" action="{{ route('settings.departments.update', $departments->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="dept_name">Department Name</label>
                      <input type="text" class="form-control" id="dept_name" name="dept_name" value="{{$departments->dept_name}}" required>
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
