@extends('admin.components.mainlayout')


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">User Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Add Admin</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 grid-margin stretch-card mt-3">
        <div class="card">
            <div class="card-body">
                <form action="">
                    {!! csrf_field() !!}
                    <div class="row mt-2">
                        <div class="col-12">
                            @if (session()->has('notification-status'))
                                <div class="alert alert-{{ in_array(session()->get('notification-status'), ['failed', 'error', 'danger']) ? 'danger' : session()->get('notification-status') }}"
                                    role="alert">
                                    {{ session()->get('notification-msg') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="input_firstname"><b>Firstname</b></label>
                                <input type="text" class="form-control" id="input_firstname" placeholder=""
                                    value="{{ old('firstname') }}" name="firstname">
                                @if ($errors->first('firstname'))
                                    <p class="form-text text-danger">{{ $errors->first('firstname') }}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="input_middlename"><b>Middlename</b></label>
                                <input type="text" class="form-control" id="input_middlename" placeholder=""
                                    value="{{ old('middlename') }}" name="middlename">
                                @if ($errors->first('middlename'))
                                    <p class="form-text text-danger">{{ $errors->first('middlename') }}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="input_lastname"><b>Lastname</b></label>
                                <input type="text" class="form-control" id="input_lastname" placeholder=""
                                    value="{{ old('lastname') }}" name="lastname">
                                @if ($errors->first('lastname'))
                                    <p class="form-text text-danger">{{ $errors->first('lastname') }}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="input_suffix"><b>Suffix</b></label>
                                <input type="text" class="form-control" id="input_suffix" placeholder=""
                                    value="{{ old('suffix') }}" name="suffix">
                                @if ($errors->first('suffix'))
                                    <p class="form-text text-danger">{{ $errors->first('suffix') }}</p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="input_email"><b>Email</b></label>
                                <input type="text" class="form-control" id="input_email" placeholder=""
                                    value="{{ old('email') }}" name="email">
                                @if ($errors->first('email'))
                                    <p class="form-text text-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="input_password"><b>Password</b></label>
                                <input type="password" class="form-control" id="input_password" placeholder=""
                                    value="{{ old('password') }}" name="password">
                                @if ($errors->first('password'))
                                    <p class="form-text text-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="input_confirm_password"><b>Cofirm Password</b></label>
                                <input type="password" class="form-control" id="input_confirm_password" placeholder=""
                                    value="{{ old('confirm_password') }}" name="confirm_password">
                                @if ($errors->first('confirm_password'))
                                    <p class="form-text text-danger">{{ $errors->first('confirm_password') }}</p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Account Type</label>
                                <select class="form-control" aria-label="Default select example" name="user_role"
                                    value="{{ old('user_role') }}">
                                    <option value="">Open this select menu</option>
                                    <option value="personnel">Personnel
                                    </option>
                                    <option value="admin">Admin
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <a href="{{ route('admin.users.admin.index') }}" class="btn btn-secondary">Go back to
                                    Admin
                                    List</a>
                                <button type="submit" class="btn  btn-primary">Submit</button>
                            </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
