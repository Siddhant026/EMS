@extends('layouts.app')

@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/admin/employee.js') }}"></script>
    <script>
        var login_id = {{ Auth::user()->id }};
        var token = "{{ csrf_token() }}";
    </script>
@endpush

@section('content')
    <div class="container" style="margin-top: 0px; margin-left: 225px; width:83%">
        <h1 class="page-header">Employee</h1>
        <div class="row">
            <div class="col-md-6">
                <h4>List of Employees</h4>
            </div>
            <div class="col-md-6 text-right">
                <a href="/admin/emp_mgnt/employee/create" class="btn btn-primary">Add Employee</a>
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
                <label for="department" class="col-md-1">Department</label>
                <div class="col-md-3">
                    {{-- <input type="text" name="search_department" id="search_department" class="col-md-4 form-control"
                        placeholder="Search Department" /> --}}
                    <select name="search_dept_id" id="search_dept_id" class="form-control" required autofocus>
                        <option selected value="">Search Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <label for="pincode" class="col-md-1">Pincode</label>
                <div class="col-md-3">
                    <input type="number" name="search_pincode" id="search_pincode" class="col-md-4 form-control"
                        placeholder="Search Pincode" />
                </div>
                <div class="col-md-1"></div>
                <label for="date_of_joining" class="col-md-1">Date of Joining</label>
                <div class="col-md-3">
                    {{-- <input type="text" name="search_department" id="search_department" class="col-md-4 form-control"
                        placeholder="Search Department" /> --}}
                    <input id="search_date_of_joining" type="text" class="form-control" name="search_date_of_joining"
                        placeholder="Search Date of Joining" required autofocus>
                    {{-- @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach --}}
                    </select>
                </div>
            </div>
        </div>
        <button class="btn btn-primary" id="search">Filter</button>
        <br>
        <br>
        <div class="conatiner" style="width: 100%;  background-color: white; ">
            <table id="employeetable" class="table table-striped"
                style="border-left: 1px solid grey; border-right: 2px solid grey; border-top: 1px solid grey;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection
