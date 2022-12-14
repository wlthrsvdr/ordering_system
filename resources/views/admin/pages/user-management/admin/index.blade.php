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
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 grid-margin stretch-card mt-3">
        <div class="card mb-5">
            <div class="card-header">
                <h3 class="w-50 float-left card-title m-0">Advance Filters </h3>
                <span class="float-right">
                    <a href="{{ route('admin.users.admin.index') }}" class="btn btn-default btn-sm">[Reset
                        Filter]</a>

                </span>
            </div>
            <form action="">
                <div class="card-body">
                    <div class="row row-xs mb-4">
                        <div class="col-md-3">
                            <label for="">Keyword <small>(Name, Email)</small></label>
                            <input type="text" class="form-control" placeholder="Keyword" name="keyword"
                                value="{{ $keyword }}">
                        </div>
                        <div class="col-md-3">
                            <label for="">Status</label>
                            <select class="form-control" aria-label="Default select example" name="status"
                                value="{{ $status }}">
                                <option value="">Open this select menu</option>
                                <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Account Type</label>
                            <select class="form-control" aria-label="Default select example" name="account_type"
                                value="{{ $status }}">
                                <option value="">Open this select menu</option>
                                <option value="personnel" {{ $status == 'personnel' ? 'selected' : '' }}>Cafeteria Staff
                                </option>
                                <option value="admin" {{ $status == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                            </select>
                        </div>
                        {{-- <div class="col-md-3">
                            <label for="">Date Range</label>
                            <input type="text" class="form-control datepicker" placeholder="Start Date" name="start_date"
                                value="{{ $start_date }}">
                        </div>
                        <div class="col-md-3 mt-3 mt-md-0">
                            <label for="">&nbsp;</label>
                            <input type="text" class="form-control datepicker" placeholder="End Date" name="end_date"
                                value="{{ $end_date }}">
                        </div> --}}
                    </div>
                    <div class="col-md-2 mt-3 mt-md-0">
                        <button type="submit" class="btn btn-primary btn-block">Apply Filters</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-header">
                <div><span class="float-right">
                        <a class="btn btn-sm btn-primary text-white" href="{{ route('admin.users.admin.create') }}">Add
                            Admin</a>
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-12">
                        @if (session()->has('notification-status'))
                            <div class="alert alert-{{ in_array(session()->get('notification-status'), ['failed', 'error', 'danger']) ? 'danger' : session()->get('notification-status') }}"
                                role="alert">
                                {{ session()->get('notification-msg') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Account Type</th>
                                        <th>Account Status</th>
                                        <th>Account Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($admins as $index => $value)
                                        <tr>
                                            <td>
                                                @if ($value->name)
                                                    <div class="mb5">
                                                        {{ $value->name }}
                                                    </div>
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->email)
                                                    <div class="mb5">
                                                        {{ $value->email }}
                                                    </div>
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->user_role)
                                                    @if ($value->user_role == 'personnel')
                                                        <div class="mb5">
                                                            {{ 'Cafeteria Staff' }}
                                                        </div>
                                                    @else
                                                        <div class="mb5">
                                                            {{ 'Admin' }}
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->account_status)
                                                    @if ($value->account_status == 'active')
                                                        <div><span
                                                                class="badge badge-success">{{ Str::title($value->account_status) }}</span>
                                                        </div>
                                                    @else
                                                        <div><span
                                                                class="badge badge-danger">{{ Str::title($value->account_status) }}</span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->created_at)
                                                    <div class="mb5">
                                                        {{ $value->created_at->format('m-d-Y') }}
                                                    </div>
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-sm btn-primary btn-raised dropdown-toggle"
                                                    data-toggle="dropdown">Actions <span class="caret"></span></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton2">
                                                    <a href="{{ route('admin.users.admin.update-status', [$value->id]) }}"
                                                        class="dropdown-item" style="cursor: pointer">
                                                        @if ($value->account_status == 'active')
                                                            Deactivate
                                                        @else
                                                            Activate
                                                        @endif
                                                    </a>
                                                    <a href="{{ route('admin.users.admin.edit', [$value->id]) }}"
                                                        class="dropdown-item" style="cursor: pointer">
                                                        Update Information
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">
                                                <p>No record found yet.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if ($admins->total() > 0)
                            <nav class="mt-2">
                                <p>Showing <strong>{{ $admins->firstItem() }}</strong> to
                                    <strong>{{ $admins->lastItem() }}</strong> of
                                    <strong>{{ $admins->total() }}</strong>
                                    entries
                                </p>
                                {!! $admins->appends(request()->query())->render() !!}
                                </ul>
                            </nav>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
