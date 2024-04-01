@extends ('layout')

@section ('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add New Broadcast Category</h4>
                  <p class="card-description">
                    Form Add Broadcast Category
                  </p>
                  <form class="forms-sample" action="{{ route('broadcast.storeCategory') }}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label for="category_name">Category Name</label>
                      <input type="text" name="category_name" id="category_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a class="btn btn-light" href="{{route('broadcast.index')}}">Cancel</a>
                  </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
