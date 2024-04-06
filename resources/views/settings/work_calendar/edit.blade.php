@extends ('layout')

@section ('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Interest</h4>
                  <p class="card-description">
                    Form Edit Interest
                  </p>
                  <form class="forms-sample" action="{{ route('settings.interests.update', $interests->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="interest_amount">Interest Amount</label>
                      <input type="text" class="form-control" id="interest_amount" name="interest_amount" value="{{$interests->interest_amount}}" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a class="btn btn-light" href="{{route('settings.interests')}}">Cancel</a>
                  </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
