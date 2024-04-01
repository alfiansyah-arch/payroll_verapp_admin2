@extends ('layout')

@section ('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Hello, {{ auth()->user()->username }}</h3>
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
                    <h6 class="font-weight-normal mb-0">All systems are running smoothly! You have <span class="text-primary">3 unread alerts!</span></h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Employees Data</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="dataTable1" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th hidden>Id User</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role Name</th>
                                            <th>Department</th>
                                            <th>Position</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach($users as $employee)
                                        <?php $no++ ?>
                                        <tr>
                                            <th scope="row">{{ $no }}</th>
                                            <td hidden>{{$employee->id}}</td>
                                            <td>{{$employee->username}}</td>
                                            <td>{{$employee->email}}</td>
                                            <td>{{$employee->role_name}}</td>
                                            <td>{{$employee->dept_name}}</td>
                                            <td>{{$employee->position_name}}</td>
                                            <td>{{$employee->status}}</td>
                                            <td>
                                                <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                                    <button class="btn btn-sm btn-light dropdown-toggle" style="background-color:#2dd8eb" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                                        <a class="dropdown-item" href="#">View</a>
                                                        <a class="dropdown-item" href="{{route('employees.editusers', $employee->id)}}">Edit</a>
                                                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item" onclick="confirmDelete()">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <a class="btn btn-success" href="{{route('employees.createusers')}}">Add Form</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete() {
        if (confirm('Are you sure you want to delete this employee?')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>
@endsection
