@extends('layout')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Employee</h4>
                        <p class="card-description">
                            Edit Employee Details
                        </p>
                        <form class="forms-sample" action="{{ route('employees.update', $employee->id) }}" method="POST" onsubmit="return validateForm()">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Name" value="{{ $employee->username }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $employee->email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="role_name">Role</label>
                                <select class="form-control form-control-lg" name="role_name" id="role_name" required>
                                    @if(auth()->user()->role_name === 'Super Admin')
                                        <option value="" selected="true" disabled="disabled">Choose Role</option>
                                        <option value="Admin" {{ $employee->role_name === 'Admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="Employee" {{ $employee->role_name === 'Employee' ? 'selected' : '' }}>Employee</option>
                                    @elseif(auth()->user()->role_name === 'Admin')
                                        <option value="" selected="true" disabled="disabled">Choose Role</option>
                                        <option value="Employee" {{ $employee->role_name === 'Employee' ? 'selected' : '' }}>Employee</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control form-control-lg" name="status" id="status" required>
                                    <option value="" selected="true" disabled="disabled">Choose Status</option>
                                    <option value="Active" {{ $employee->status === 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ $employee->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="Disable" {{ $employee->status === 'Disable' ? 'selected' : '' }}>Disable</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="department">Department</label>
                                <select class="form-control" id="department" name="department" required>
                                    <option value="" selected="true" disabled="disabled">Choose Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->dept_id }}" {{ $employee->department === $department->dept_id ? 'selected' : '' }}>{{ $department->dept_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="position">Position</label>
                                <select class="form-control" id="position" name="position" required>
                                    <option value="" selected="true" disabled="disabled">Choose Position</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position->id }}" {{ $employee->position === $position->id ? 'selected' : '' }}>{{ $position->position_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a class="btn btn-light" href="{{ route('employees_data') }}">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('department').addEventListener('change', function() {
              var departmentId = this.value;
              var positionDropdown = document.getElementById('position');

              positionDropdown.innerHTML = '<option value="" selected="true" disabled="disabled">Choose Position</option>';

              fetch('/get-positions/' + departmentId)
                  .then(response => response.json())
                  .then(data => {
                      data.forEach(position => {
                          var option = document.createElement('option');
                          option.value = position.id;
                          option.textContent = position.position_name;
                          positionDropdown.appendChild(option);
                      });
                  });
          });
</script>
<script>
    function validateForm() {
        var password = document.getElementById("password").value;
        var confirm_password = document.getElementById("confirm_password").value;
        if (password !== confirm_password) {
            alert("Password tidak sesuai");
            return false;
        }
        return true;
    }
</script>
@endsection
