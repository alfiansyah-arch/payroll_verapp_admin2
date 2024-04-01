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
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">List of Broadcast</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="dataTable1" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Username</th>
                                            <th>Category</th>
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Image</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0;?>
                                        @foreach($broadcasts as $broadcast)
                                        <?php $no++;
                                        $totalSalary = $broadcast->basic_salary + $broadcast->meal_allowance + $broadcast->transportation_money + $broadcast->family_allowance + $broadcast->positional_allowance;
                                         ?>
                                        <tr>
                                            <th width="5%">{{ $no }}</th>
                                            <td>{{$broadcast->username}}</td>
                                            <td>{{$broadcast->category_name}}</td>
                                            <td>{{$broadcast->broadcast_title}}</td>
                                            <td>{{$broadcast->date}}</td>
                                            <td>{{$broadcast->img}}</td>
                                            <td>{{$broadcast->description}}</td>
                                            <td>
                                                <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                                    <button class="btn btn-sm btn-light dropdown-toggle" style="background-color:#2dd8eb" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                                        <a class="dropdown-item" href="{{route('broadcast.show', $broadcast->id)}}">Show</a>
                                                        <a class="dropdown-item" href="{{route('broadcast.edit', $broadcast->id)}}">Edit</a>
                                                        <form id="deleteFormTask" action="{{ route('broadcast.destroy', $broadcast->id) }}" method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Do you really want to delete Broadcast = {{ $broadcast->broadcast_title }} ?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item"><span>Delete</span></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <a class="btn btn-success" href="{{route('broadcast.create')}}">Add Broadcast</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">List of Broadcast Category</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="dataTable2" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Category Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0;?>
                                        @foreach($categorys as $category)
                                        <?php $no++;
                                         ?>
                                        <tr>
                                            <th width="5%">{{ $no }}</th>
                                            <td>{{$category->category_name}}</td>
                                            <td>
                                                <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                                    <button class="btn btn-sm btn-light dropdown-toggle" style="background-color:#2dd8eb" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                                        <a class="dropdown-item" href="{{route('broadcast.editcategory', $category->id)}}">Edit</a>
                                                        <form id="deleteFormTask" action="{{ route('broadcast.destroycategory', $category->id) }}" method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Do you really want to delete category = {{ $category->category_name }} ?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item"><span>Delete</span></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <a class="btn btn-success" href="{{route('broadcast.createcategory')}}">Add New Category</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
</div>
@endsection
