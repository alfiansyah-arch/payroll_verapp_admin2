@extends ('layout')

@section ('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add New Installments</h4>
                  <p class="card-description">
                    Form Add Installments
                  </p>
                  <form class="forms-sample" action="{{ route('settings.installments.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label for="installments_amount">Installments Amount</label>
                      <input type="number" min="1" max="36" class="form-control" id="installments_amount" name="installments_amount" required>
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
