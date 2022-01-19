@extends('layouts.app')

@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/admin/position.js') }}"></script>
    <script>
        var login_id = {{ Auth::user()->id }};
        var token = "{{ csrf_token() }}";
    </script>
@endpush

@section('content')
    <div class="container" style="margin-top: 0px; margin-left: 225px; width:83%">
        <h1 class="page-header">Edit Position</h1>
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="/admin/sys_mgnt/position/{{ $position->id }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Position Name</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{ $position->name }}"
                            required autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('dept_id') ? ' has-error' : '' }}">
                    <label for="dept_id" class="col-md-4 control-label">Department</label>

                    <div class="col-md-6">
                        {{-- <input id="dept_id" type="text" class="form-control" name="dept_id" 
                            required autofocus> --}}
                        <select name="dept_id" id="dept_id" class="form-control" required autofocus>
                            {{-- <option selected>Open this select menu</option> --}}
                            @foreach ($departments as $department)
                                @if ($position->dept_id == $department->id)
                                    <option selected value="{{ $department->id }}">{{ $department->name }}</option>
                                @else
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endif
                            @endforeach
                        </select>

                        @if ($errors->has('dept_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('dept_id') }}</strong>
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
