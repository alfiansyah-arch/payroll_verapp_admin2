@extends ('layout')

@section ('content')
<div class="content-wrapper">
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('danger'))
        <div class="alert alert-danger" role="alert">
            {{ session('danger') }}
        </div>
    @endif
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                    <h4 class="card-title">{{ $broadcasts->broadcast_title }}</h4>
                        <p class="card-description">
                            <code>Publisher:</code> {{ $broadcasts->username }} <code>Category:</code> {{ $broadcasts->category_name }} <code>Date:</code> {{ $broadcasts->date }}
                        </p>
                        <hr>
                <div class="row">
                    <div class="col-md-12">
                        <p>{!! $broadcasts->description !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 grid-margin">
        <a type="button" class="btn btn-warning" href="{{route('broadcast.index')}}">Back</a>
    </div>
</div>
@endsection
