@extends('layouts.app')

@push('scripts')
    {{-- <script type="text/javascript" src="{{ asset('/js/admin/edit_employee.js') }}"></script> --}}
    <script>
        var login_id = {{ Auth::user()->id }};
        var token = "{{ csrf_token() }}";

        $(document).ready(function() {
            $('department').on('change', changePositions());
        });

        function changePositions() {
            //console.log(pid);
            var department = JSON.parse(document.getElementById("department").value);
            var name = '';
            fetch_position_data(name, department['id']);
        }

        function fetch_position_data(name = '', dept_id = '') {
            $.ajax({
                url: "/position_filter",
                method: 'GET',
                data: {
                    name: name,
                    dept_id: dept_id
                },
                dataType: 'json',
                success: function(data) {
                    var i = 0;
                    for (i; i < data.positions.length; i++) {
                        var content = "";
                        if ({{ $employee[0]->pid }} == data.positions[i].id) {
                            content = '<option selected value="' + data.positions[i].id + '">' + data.positions[
                                i].name + '</option>';
                        } else {
                            content = '<option value="' + data.positions[i].id + '">' +
                                data.positions[i].name + '</option>';
                        }
                        // content = '<option value="' + data.positions[i].id + '">' +
                        //         data.positions[i].name + '</option>';
                        $("#position").append(content);
                    }
                }
            })
        }
    </script>
@endpush

@section('content')
    <div class="container" style="margin-top: 0px; margin-left: 225px; width:83%">
        <h1 class="page-header">Edit Employee</h1>
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="/admin/emp_mgnt/employee/{{ $employee['0']->eid }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">Email</label>

                    <div class="col-md-6">

                        <select name="email" id="email" class="form-control" required autofocus readonly>
                            @foreach ($users as $user)
                                @if ($user->email == $employee[0]->email)
                                    <option selected value="{{ $user }}">{{ $user->email }}</option>
                                @endif
                            @endforeach
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
                        <input id="name" type="text" class="form-control" name="name"
                            value="{{ $employee['0']->uname }}" required autofocus disabled>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                    <label for="address" class="col-md-4 control-label">Address</label>

                    <div class="col-md-6">
                        <input id="address" type="text" class="form-control" name="address"
                            value="{{ $employee['0']->address }}" required autofocus>

                        @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('pincode') ? ' has-error' : '' }}">
                    <label for="pincode" class="col-md-4 control-label">Pincode</label>

                    <div class="col-md-6">
                        <input id="pincode" type="number" class="form-control" name="pincode"
                            value="{{ $employee['0']->pincode }}" required autofocus>

                        @if ($errors->has('pincode'))
                            <span class="help-block">
                                <strong>{{ $errors->first('pincode') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                    <label for="dob" class="col-md-4 control-label">Date of Birth</label>

                    <div class="col-md-6">
                        <input id="dob" type="text" class="form-control" name="dob" value="{{ $employee['0']->dob }}"
                            required autofocus>
                        {{-- <input type='text' class="form-control" id='date'/> --}}

                        @if ($errors->has('dob'))
                            <span class="help-block">
                                <strong>{{ $errors->first('dob') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('date_of_joining') ? ' has-error' : '' }}">
                    <label for="date_of_joining" class="col-md-4 control-label">Date of Joining</label>

                    <div class="col-md-6">
                        <input id="date_of_joining" type="text" class="form-control" name="date_of_joining"
                            value="{{ $employee['0']->date_of_joining }}" required autofocus>

                        @if ($errors->has('date_of_joining'))
                            <span class="help-block">
                                <strong>{{ $errors->first('date_of_joining') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                    <label for="role" class="col-md-4 control-label">Role</label>

                    <div class="col-md-6">
                        {{-- <input id="dept_id" type="text" class="form-control" name="dept_id" 
                            required autofocus> --}}
                        <select name="role" id="role" class="form-control" required autofocus>
                            <option value="">Open this select menu</option>
                            <option @if ($employee['0']->role == App\User::EMPLOYEE_ROLE)
                                selected
                                @endif value="{{ App\User::EMPLOYEE_ROLE }}">Employee</option>
                            <option @if ($employee['0']->role == App\User::MANAGER_ROLE)
                                selected
                                @endif value="{{ App\User::MANAGER_ROLE }}">Manager</option>
                            {{-- @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach --}}
                        </select>

                        @if ($errors->has('role'))
                            <span class="help-block">
                                <strong>{{ $errors->first('role') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('department') ? ' has-error' : '' }}">
                    <label for="department" class="col-md-4 control-label">Department</label>

                    <div class="col-md-6">
                        {{-- <input id="dept_id" type="text" class="form-control" name="dept_id" 
                            required autofocus> --}}
                        <select name="department" id="department" onchange="changePositions();" class="form-control"
                            required autofocus>
                            <option value="">Open this select menu</option>
                            @foreach ($departments as $department)
                                <option @if ($employee['0']->dname == $department->name)
                                    selected
                                    @endif value="{{ $department }}">{{ $department->name }}</option>
                            @endforeach
                        </select>

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
                        {{-- <input id="dept_id" type="text" class="form-control" name="dept_id" 
                            required autofocus> --}}
                        <select name="position" id="position" class="form-control" required autofocus>
                            <option selected value="">Open this select menu</option>

                            {{-- @foreach ($departments as $department)
                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                            @endforeach --}}
                        </select>

                        @if ($errors->has('position'))
                            <span class="help-block">
                                <strong>{{ $errors->first('position') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
