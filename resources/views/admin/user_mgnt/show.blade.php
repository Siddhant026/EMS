@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/admin/user_mgnt.js') }}"></script>
    <script>
        var login_id = {{ Auth::user()->id }};
        var token = "{{ csrf_token() }}";
    </script>
@endpush

@section('content')
    <div class="container" style="margin-top: 0px; margin-left: 225px; width:83%">
        <h1 class="page-header">User Management</h1>
        <div class="row">
            <div class="col-md-6">
                <h4>List of Users</h4>
            </div>
            <div class="col-md-6 text-right">
                <a href="/admin/user_mgnt/create" class="btn btn-primary">Add User</a>
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="row">
                <label for="name" class="col-md-1">Name</label>
                <div class="col-md-3">
                    <input type="text" name="search_name" id="search_name" class="col-md-4 form-control"
                        placeholder="Search Name" />
                </div>
                <div class="col-md-1"></div>
                <label for="email" class="col-md-1">Email</label>
                <div class="col-md-3">
                    <input type="text" name="search_email" id="search_email" class="col-md-4 form-control"
                        placeholder="Search Email" />
                </div>
            </div>
            <br>
            <div class="row">
                <label for="role" class="col-md-1">Role</label>
                <div class="col-md-3">
                    <input type="text" name="search_role" id="search_role" class="col-md-4 form-control"
                        placeholder="Search Role" />
                </div>
            </div>
        </div>
        <button class="btn btn-primary" id="search">Filter</button>
        {{-- <div class="row"><div class="col-md-1"><form action="/admin/user_mgnt/'+ data.users[i].id +'/edit" method="get"><input type="submit" class="btn btn-warning" value="Edit"></form></div><div class="col-md-1"><button class="btn btn-danger" onclick="delete_user(' + data.users[i].id + ')">Delete</button></div></div> --}}
        {{-- <form action="/admin/user_mgnt/id/edit" method="get"><input type="submit" class="btn btn-warning" value="Edit"></form> --}}
        <br>
        <br>
        <div class="conatiner" style="width: 100%;  background-color: white; ">
            {{-- <div class="div" id="data"></div> --}}
            <table id="usertable" class="table table-striped"
                style="border-left: 1px solid grey; border-right: 2px solid grey; border-top: 1px solid grey;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection
