@extends('layouts.app')

@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/admin/dept.js') }}"></script>
    <script>
        var login_id = {{ Auth::user()->id }};
        var token = "{{ csrf_token() }}";
    </script>
@endpush

@section('content')
    <div class="container" style="margin-top: 0px; margin-left: 225px; width:83%">
        <h1 class="page-header">Department</h1>
        <div class="row">
            <div class="col-md-6">
                <h4>List of Departments</h4>
            </div>
            <div class="col-md-6 text-right">
                <a href="/admin/sys_mgnt/dept/create" class="btn btn-primary">Add Department</a>
            </div>
        </div>
        <br>
        <div class="conatiner" style="width: 100%;  background-color: white; ">
            <table id="departmenttable" class="table table-striped"
                style="border-left: 1px solid grey; border-right: 2px solid grey; border-top: 1px solid grey;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $department)
                        <tr>
                            <td>{{ $department->name }}</td>
                            <td>
                                <div class="row">
                                    <div class="col-md-1" style="margin-right: 20px">
                                        <form action="/admin/sys_mgnt/dept/{{ $department->id }}/edit" method="get"><input
                                                type="submit" class="btn btn-warning" value="Edit"></form>
                                    </div>
                                    <div class="col-md-1"><button class="btn btn-danger"
                                            onclick="delete_dept({{ $department->id }})">Delete</button></div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
