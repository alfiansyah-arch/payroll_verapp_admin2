@extends ('layout')

@section ('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Payroll</h4>
                  <p class="card-description">
                    Form Edit Payroll
                  </p>
                  <form class="forms-sample" action="{{ route('payroll.update', $payroll->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group" hidden>
                      <label for="user_id">User</label>
                      <input type="hidden" name="user_id" id="user_id" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label for="basic_salary">Basic Salary</label>
                      <input type="number" class="form-control" id="basic_salary" name="basic_salary" min="0" max="10000000" value="{{$payroll->basic_salary}}" required>
                    </div>
                    <div class="form-group">
                      <label for="meal_allowance">Meal Allowance</label>
                      <input type="number" class="form-control" id="meal_allowance" name="meal_allowance" min="0" max="10000000" value="{{$payroll->meal_allowance}}" required>
                    </div>
                    <div class="form-group">
                      <label for="transportation_money">Transportation Money</label>
                      <input type="number" class="form-control" id="transportation_money" name="transportation_money" min="0" max="10000000" value="{{$payroll->transportation_money}}" required>
                    </div>
                    <div class="form-group">
                      <label for="family_allowance">Family Allowance</label>
                      <input type="number" class="form-control" id="family_allowance" name="family_allowance" min="0" max="10000000" value="{{$payroll->family_allowance}}" required>
                    </div>
                    <div class="form-group">
                      <label for="positional_allowance">Positional Allowance</label>
                      <input type="number" class="form-control" id="positional_allowance" name="positional_allowance" min="0" max="10000000" value="{{$payroll->positional_allowance}}" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a class="btn btn-light" href="{{route('payroll.index')}}">Cancel</a>
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
