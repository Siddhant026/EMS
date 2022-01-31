@extends('layouts.app')

@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/admin/create_employee.js') }}"></script>
    <script>
        var login_id = {{ Auth::user()->id }};
        var token = "{{ csrf_token() }}";
    </script>
@endpush



@section('content')
    <div class="container" style="margin-top: 0px; margin-left: 225px; width:83%">
        <h1 class="page-header">Add Employee</h1>
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="/admin/emp_mgnt/employee">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">Email</label>

                    <div class="col-md-6">
                        {{-- <input id="dept_id" type="text" class="form-control" name="dept_id" 
                            required autofocus> --}}
                        <select name="email" id="email" onchange="changeName();" class="form-control" required autofocus>
                            <option selected value="">Open this select menu</option>
                            @foreach ($users as $user)
                                @if ($user->id != Auth::user()->id)
                                    <option value="{{ $user }}">{{ $user->email }}</option>
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
                        <input id="name" type="text" class="form-control" name="name" required autofocus disabled>

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
                            value="{{ old('address') }}" required autofocus>

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
                            value="{{ old('pincode') }}" required autofocus>

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
                        <input id="dob" type="text" class="form-control" name="dob" value="{{ old('dob') }}" required
                            autofocus>
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
                            value="{{ old('date_of_joining') }}" required autofocus>

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
                            <option selected value="">Open this select menu</option>
                            <option value="{{ App\User::EMPLOYEE_ROLE }}">Employee</option>
                            <option value="{{ App\User::MANAGER_ROLE }}">Manager</option>
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
                            <option selected value="">Open this select menu</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department }}">{{ $department->name }}</option>
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
