@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 0px; margin-left: 225px; width:83%">
        <h1 class="page-header">Manager</h1>
        <div class="row">
            <div class="col-md-3">
                <h4>Select Manager by Email</h4>
            </div>
            <div class="col-md-3">
                <select name="manager" id="manager" class="form-control" onchange="manager_change();" required autofocus>
                    <option selected value="none">Open this select menu</option>
                    @foreach ($managers as $manager)
                        <option value="{{ $manager }}">{{ $manager->email }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <div class="conatiner" style="width: 100%;  background-color: white; ">
            <table id="managertable" class="table table-striped "
                style="border-left: 1px solid grey; border-right: 2px solid grey; border-top: 1px solid grey; border-bottom: 1px solid grey;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date of Joining</th>
                        <th>Position</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h4>Employees Managed</h4>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#empAddModal" id="empAdd"
                    disabled>
                    Add Employee
                </button>
            </div>
        </div>
        <div class="modal fade" id="empAddModal" tabindex="-1" role="dialog" aria-labelledby="empAddModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="empAddModalTitle">Add Employee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="height: 100%">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Email</label>
                            <div class="col-md-6">
                                <select name="email" id="email" class="form-control" onchange="add_modal_values();"
                                    required autofocus>
                                    <option selected value="">Open this select menu</option>
                                </select>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="" required autofocus
                                    disabled>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('date_of_joining') ? ' has-error' : '' }}">
                            <label for="date_of_joining" class="col-md-4 control-label">Date of Joining</label>

                            <div class="col-md-6">
                                <input id="date_of_joining" type="text" class="form-control" name="date_of_joining"
                                    value="" required autofocus disabled>

                                @if ($errors->has('date_of_joining'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date_of_joining') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('department') ? ' has-error' : '' }}">
                            <label for="department" class="col-md-4 control-label">Department</label>

                            <div class="col-md-6">
                                <input id="department" type="text" class="form-control" name="department" value=""
                                    required autofocus disabled>

                                @if ($errors->has('department'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('department') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                            <label for="position" class="col-md-4 control-label">Position</label>

                            <div class="col-md-6">
                                <input id="position" type="text" class="form-control" name="position" value="" required
                                    autofocus disabled>


                                @if ($errors->has('position'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('position') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" class="close" data-dismiss="modal"
                            onclick="assign_emp_to_manager()">Add</button>
                        {{-- <a href="" type="button" class="btn btn-primary" id="assign_emp_to_manager" onclick="assign_emp_to_manager()">Add</a> --}}
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="conatiner" style="width: 100%;  background-color: white; ">
            <table id="employeetable" class="table table-striped"
                style="border-left: 1px solid grey; border-right: 2px solid grey; border-top: 1px solid grey;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Address</th>
                        <th>Pincode</th>
                        <th>Email</th>
                        <th>Date of Joining</th>
                        <th>Position</th>
                        <th>Department</th>
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


@push('scripts')
    {{-- <script type="text/javascript" src="{{ asset('/js/admin/employee.js') }}"></script> --}}
    <script>
        $("#employeetable").DataTable();
        // var login_id = {{ Auth::user()->id }};
        var token = "{{ csrf_token() }}";
        var employee_role = {{ App\User::EMPLOYEE_ROLE }}
        var manager_role = {{ App\User::MANAGER_ROLE }}

        function assign_emp_to_manager() {
            console.log('assign_emp_to_manager');
            name = '';
            dept_id = '';
            pincode = '';
            date_of_joining = '';
            if (document.getElementById("manager").value != 'none') {
                var manager = JSON.parse(document.getElementById("manager").value);
            }
            var employee = document.getElementById("email").value;
            employee = JSON.parse(employee);
            //console.log("delete user "+id);
            $.ajax({
                url: "/assign_emp_to_manager/" + employee.eid + "/" + manager
                    .eid,
                method: 'GET',
                // data: {
                //     _token: token,
                //     id: id
                // },
                dataType: 'json',
                success: function(data) {
                    //location.reload();
                    // location.replace("/admin/user_mgnt");
                }
            });
            //location.reload();
            fetch_employee_data(name, dept_id, pincode, date_of_joining, manager.eid)
            //location.replace("/admin/user_mgnt");
        }

        function add_modal_values() {
            var employee = document.getElementById("email").value;
            employee = JSON.parse(employee);
            document.getElementById("name").value = employee.uname;
            document.getElementById("date_of_joining").value = employee.date_of_joining;
            document.getElementById("department").value = employee.dname;
            document.getElementById("position").value = employee.pname;

            // var manager = JSON.parse(document.getElementById("manager").value);
            // document.getElementById("assign_emp_to_manager").href = "/assign_emp_to_manager/" + employee.eid + "/" + manager
            //     .eid;
        }

        function manager_change() {
            name = '';
            dept_id = '';
            pincode = '';
            date_of_joining = '';
            var content = "";
            if (document.getElementById("manager").value != 'none') {
                var manager = JSON.parse(document.getElementById("manager").value);
                content = '<tr><td>' + manager.uname + '</td><td>' + manager.email + '</td><td>' + manager.date_of_joining +
                    '</td><td>' + manager.pname + '</td><td>' + manager.dname + '</td></tr>';
                $("#managertable > tbody").append(content);
                document.getElementById("empAdd").href = "/admin/emp_mgnt/manager/add_emp/" + manager.eid;
                document.getElementById('empAdd').removeAttribute("disabled");
                fetch_employee_data(name, dept_id, pincode, date_of_joining, manager.eid)
            } else {
                document.getElementById('empAdd').setAttribute("disabled", "disabled");
                $("#managertable > tbody").empty();
            }
        }

        function remove_employee(id) {
            //console.log('remove');
            name = '';
            dept_id = '';
            pincode = '';
            date_of_joining = '';
            var manager = JSON.parse(document.getElementById("manager").value);
            //console.log("delete user "+id);
            if (confirm('Are you sure you want to REMOVE ?')) {
                $.ajax({
                    url: "/remove_manager_from_employee/" + id,
                    method: 'DELETE',
                    data: {
                        _token: token,
                        id: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        //location.reload();
                        // location.replace("/admin/user_mgnt");
                    }
                });
                //location.reload();
                fetch_employee_data(name, dept_id, pincode, date_of_joining, manager.eid)
                //location.replace("/admin/user_mgnt");
            }
        }

        function fetch_employee_data(name = '', dept_id = '', pincode = '', date_of_joining = '', manager_id = '') {
            $.ajax({
                url: "/employee_filter",
                method: 'GET',
                data: {
                    name: name,
                    dept_id: dept_id,
                    pincode: pincode,
                    date_of_joining: date_of_joining,
                    manager_id: manager_id,
                },
                dataType: 'json',
                success: function(data) {
                    //console.log(JSON.stringify(data.employees[0]));
                    $("#employeetable > tbody").empty();
                    $("#email").empty().append('<option selected value="">Open this select menu</option>');
                    document.getElementById("name").value = '';
                    document.getElementById("date_of_joining").value = '';
                    document.getElementById("department").value = '';
                    document.getElementById("position").value = '';
                    var i = 0;
                    for (i; i < data.employees.length; i++) {
                        if (data.employees[i].role == employee_role) {
                            var role = "Employee";
                        } else {
                            var role = "Manager"
                        }
                        var table_content = "";
                        if (data.employees[i].mid == manager_id) {
                            table_content = '<tr><td>' + data.employees[i].uname + '</td><td>' + data.employees[
                                    i]
                                .dob +
                                '</td><td>' + data.employees[i].address + '</td><td>' + data.employees[i]
                                .pincode +
                                '</td><td>' + data.employees[i].email + '</td><td>' + data.employees[i]
                                .date_of_joining + '</td><td>' + data.employees[i].pname + '</td><td>' + data
                                .employees[i].dname + '</td><td>' + role +
                                '</td><td><button class="btn btn-danger" onclick="remove_employee(' +
                                data.employees[i].eid + ')">Remove</button></td></tr>';
                        }
                        $("#employeetable > tbody").append(table_content);

                        var emp = JSON.stringify(data.employees[i]);
                        //console.log(emp);
                        var modal_content = "";
                        if (manager_id != data.employees[i].eid) {
                            modal_content = "<option value='" + emp + "'>" + data.employees[
                                i].email + "</option>";
                        }
                        $("#email").append(modal_content);
                    }
                }
            })
        }
    </script>
@endpush
