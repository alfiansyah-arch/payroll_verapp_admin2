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
                  <form class="forms-sample" action="{{ route('broadcast.update', $broadcasts->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <h5 for="publisher">Broadcast Publisher Before : <b>{{$broadcasts->username}}</b></h5>
                      <h5 for="publisher">New Publisher : <b>{{$username}}</b></h5>
                      <h5 for="date">Last Publish : <b>{{$broadcasts->date}}</b></h5>
                      <input type="hidden" name="user_id" id="user_id" value="{{$user_id}}" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="category">Category</label>
                        <select class="form-control" id="category" name="category" required>
                        <option value="" selected disabled>Choose Category</option>
                          @foreach($categorys as $category)
                          <option value="{{ $category->id }}" {{ $selectedCategoryId == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="broadcast_title">Title Broadcast</label>
                      <input type="text" class="form-control" id="broadcast_title" name="broadcast_title" value="{{$broadcasts->broadcast_title}}" required>
                    </div>
                    <div class="form-group" hidden>
                      <label for="date">Date</label>
                      <input type="date" class="form-control" id="date" name="date" value="{{date('Y-m-d')}}" required>
                    </div>
                    <div class="form-group">
                      <label for="img">Image</label>
                      <input type="file" accept="image/png, image/jpeg" class="form-control" id="img" name="img" value="{{$broadcasts->img}}">
                    </div>
                    <div class="form-group">
                      <label for="description">Broadcast Description</label>
                      <textarea class="form-control input-sm" name="description" id="description" rows="15">{{$broadcasts->description}}</textarea>
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
