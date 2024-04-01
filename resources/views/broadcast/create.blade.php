@extends ('layout')

@section ('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add New Broadcast</h4>
                  <p class="card-description">
                    Form Add Broadcast
                  </p>
                  <form class="forms-sample" action="{{ route('broadcast.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                      <h5 for="publisher">Broadcast Publisher : <b>{{$username}}</b></h5>
                      <h5 for="date">Date : <b>{{date('Y-m-d')}}</b></h5>
                      <input type="hidden" name="user_id" id="user_id" value="{{$user_id}}" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="category">Category</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="" selected="true" disabled="disabled">Choose Category</option>
                            @foreach($categorys as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="broadcast_title">Title Broadcast</label>
                      <input type="text" class="form-control" id="broadcast_title" name="broadcast_title" required>
                    </div>
                    <div class="form-group" hidden>
                      <label for="date">Date</label>
                      <input type="date" class="form-control" id="date" name="date" value="{{date('Y-m-d')}}" required>
                    </div>
                    <div class="form-group">
                      <label for="img">Image</label>
                      <input type="file" accept="image/png, image/jpeg" class="form-control" id="img" name="img">
                    </div>
                    <div class="form-group">
                      <label for="description">Broadcast Description</label>
                      <textarea class="form-control input-sm" name="description" id="description" rows="15"></textarea>
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
