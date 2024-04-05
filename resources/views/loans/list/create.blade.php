@extends ('layout')

@section ('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add New Loan</h4>
                  <p class="card-description">
                    Form Add Loan
                  </p>
                  <form class="forms-sample" action="{{ route('loans.list.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label for="user_id">User</label>
                      <select class="form-control" id="user_id" name="user_id" onchange="updateLoanId()" required>
                          <option value="" selected disabled>Choose User</option>
                          @foreach($users as $user)
                              @if($user->status == "Active")
                                  <option value="{{ $user->user_id }}">{{ $user->username }}</option>
                              @endif
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="loan_id">Id Loan</label>
                      <input type="text" class="form-control" id="loan_id" name="loan_id" value="{{$newLoanId}}" readonly required>
                    </div>
                    <div class="form-group">
                      <label for="loan_amount">Loan Amount</label>
                      <input type="text" class="form-control" id="loan_amount" name="loan_amount" placeholder="Max. 100.000.000" required>
                    </div>
                    <div class="form-group">
                      <label for="installments">Installments</label>
                      <select class="form-control" id="installments" name="installments" required>
                          <option value="" selected disabled>Choose Installments</option>
                          @foreach($installments as $installment)
                                  <option value="{{ $installment->installments_amount }}">{{ $installment->installments_amount }}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="loan_date">Date</label>
                      <input type="date" class="form-control" id="loan_date" name="loan_date" required>
                    </div>
                    <div class="form-group">
                      <label for="status">Status</label>
                      <select class="form-control" id="status" name="status" required>
                          <option value="" selected disabled>Choose Status</option>
                          <option value="Pending">Pending</option>
                          <option value="Accepted">Accept</option>
                          <option value="Rejected">Reject</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="interest">Interests (%)</label>
                      <input type="text" class="form-control" id="interest" name="interest" value="{{$interests}}" readonly required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a class="btn btn-light" href="{{route('loans.list')}}">Cancel</a>
                  </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<script>
    function formatRupiah(angka) {
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    document.getElementById('loan_amount').addEventListener('input', function() {
        var input = this.value.replace(/\./g, '');
        var loanAmount = parseInt(input);
        if (!isNaN(loanAmount) && loanAmount <= 1000000000) {
            this.value = formatRupiah(loanAmount);
        } else {
            this.value = '';
        }
    });

    window.addEventListener('DOMContentLoaded', function() {
        var input = document.getElementById('loan_amount');
        var loanAmount = parseInt(input.value.replace(/\./g, '')); 
        if (!isNaN(loanAmount)) {
            input.value = formatRupiah(loanAmount);
        }
    });
</script>
@endsection
