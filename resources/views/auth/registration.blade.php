@extends ('layout_login')

@section ('content')

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="../../images/logo.svg" alt="logo">
              </div>
              <h4>Register</h4>

              <form class="pt-3" action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
              @csrf
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="user_id" name="user_id" placeholder="User Id">
                </div>

                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Username">
                </div>

                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="join_date" name="join_date" placeholder="Join Date" value="{{ date('Y-m-d') }}">
                </div>
                
                <div class="form-group">
                  <select class="form-control form-control-lg" id="role_name" name="role_name">
                      <option value="">Pilih Role</option>
                      @foreach($role_status_name as $role)
                          <option value="{{ $role->role_status_name }}">{{ $role->role_status_name }}</option>
                      @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <input type="file" class="form-control form-control-lg" name="avatar" id="avatar">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="department" name="department">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="position" name="position">
                </div>

                <div class="form-group">
                  <select class="form-control form-control-lg" name="status" id="status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Disable">Disable</option>
                  </select>
                </div>

                <div class="form-group">
                  <input type="password" name="password" id="password">
                </div>

                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN UP</button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="{{route('login')}}" class="text-primary">Login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>