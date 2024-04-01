@extends ('layout')

@section ('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Installments</h4>
                  <p class="card-description">
                    Form Edit Installments
                  </p>
                  <form class="forms-sample" action="{{ route('settings.installments.update', $installments->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="installments_amount">Installments Amount</label>
                      <input type="text" class="form-control" id="installments_amount" name="installments_amount" value="{{$installments->installments_amount}}" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a class="btn btn-light" href="{{route('settings.installments')}}">Cancel</a>
                  </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
