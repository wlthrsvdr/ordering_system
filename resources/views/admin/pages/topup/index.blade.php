@extends('admin.components.mainlayout')


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Wallet Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Topup</a></li>
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
                    <a href="{{ route('admin.users.student.index') }}" class="btn btn-default btn-sm">[Reset
                        Filter]</a>

                </span>
            </div>
            <form action="">
                <div class="card-body">
                    <div class="row row-xs mb-4">
                        <div class="col-md-3">
                            <label for="">Keyword <small>(Student Number, Name)</small></label>
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
                                        <th>Student Number</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Balance</th>
                                        <th>Account Status</th>
                                        <th>Account Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $index => $value)
                                        <tr>
                                            <td>
                                                @if ($value->student_number)
                                                    <div class="mb5">
                                                        {{ $value->student_number }}
                                                    </div>
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
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
                                                @if ($value->e_money)
                                                    <div class="mb5">
                                                        ₱ {{ $value->e_money }}
                                                    </div>
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
                                                        {{ $value->created_at->format('d F Y') }}
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
                                                    <a href="{{ route('admin.users.student.update-status', [$value->id]) }}"
                                                        class="dropdown-item" style="cursor: pointer">
                                                        @if ($value->account_status == 'active')
                                                            Deactivate
                                                        @else
                                                            Activate
                                                        @endif
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
                        @if ($students->total() > 0)
                            <nav class="mt-2">
                                <p>Showing <strong>{{ $students->firstItem() }}</strong> to
                                    <strong>{{ $students->lastItem() }}</strong> of
                                    <strong>{{ $students->total() }}</strong>
                                    entries
                                </p>
                                {!! $students->appends(request()->query())->render() !!}
                                </ul>
                            </nav>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
