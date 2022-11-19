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
                        <li class="breadcrumb-item"><a href="#">Customer</a></li>
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
                    <a href="{{ route('admin.users.customer.index') }}" class="btn btn-default btn-sm">[Reset
                        Filter]</a>

                </span>
            </div>
            <form action="">
                <div class="card-body">
                    <div class="row row-xs mb-4">
                        <div class="col-md-3">
                            <label for="">Keyword <small>(Name)</small></label>
                            <input type="text" class="form-control" placeholder="Keyword" name="keyword"
                                value="{{ $keyword }}">
                        </div>
                        <div class="col-md-3">
                            <label for="">Account Status</label>
                            <select class="form-control" aria-label="Default select example" name="status"
                                value="{{ $status }}">
                                <option value="">Open this select menu</option>
                                <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact Number</th>
                                        <th>Account Status</th>
                                        <th>Card Status</th>
                                        <th>Account Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $index => $value)
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
                                                @if ($value->contact_number)
                                                    <div class="mb5">
                                                        {{ $value->contact_number }}
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
                                                @if ($value->rfid_number)
                                                    @if ($value->card_status)
                                                        @if ($value->card_status === 'active')
                                                            <div>
                                                                <span
                                                                    class="badge badge-success">{{ Str::title($value->card_status) }}</span>
                                                            </div>
                                                        @else
                                                            <div>
                                                                <span
                                                                    class="badge badge-danger">{{ Str::title($value->card_status) }}</span>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="mb5">{{ '-' }}</div>
                                                    @endif
                                                @else
                                                    <div><span class="badge badge-danger">{{ 'not registered' }}</span>
                                                    </div>
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
                                                    <a href="{{ route('admin.users.customer.update-status', [$value->id]) }}"
                                                        class="dropdown-item" style="cursor: pointer">
                                                        @if ($value->account_status == 'active')
                                                            Deactivate Account
                                                        @else
                                                            Activate Account
                                                        @endif
                                                    </a>
                                                    {{-- id="pay-card-button" --}}
                                                    {{-- user-id="{{ $value->id }}" --}}
                                                    @if ($value->rfid_number == '')
                                                        <a onclick="showModal({{ $value->id }})" class="dropdown-item"
                                                            style="cursor: pointer">
                                                            Register Card
                                                        </a>
                                                    @endif
                                                    @if ($value->rfid_number != '')
                                                        <a href="{{ route('admin.users.customer.update-card-status', [$value->id]) }}"
                                                            class="dropdown-item" style="cursor: pointer">
                                                            @if ($value->card_status == 'active')
                                                                Deactivate Card
                                                            @else
                                                                Activate Card
                                                            @endif
                                                        </a>
                                                    @endif
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

    <div id="confirm_reg_id" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header flex-column">
                    <h4 class="modal-title w-100">Add Balance</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Do you want to add balance to your card?</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="add_balance_button">Yes</button>
                </div>
            </div>
        </div>
    </div>


    <div id="confirm-reg-card" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm your action</h5>
                </div>

                <div class="modal-body">
                    <div class="alert alert-dismissible" role="alert" style="display:none;">
                        <strong>Warning!</strong>
                        <p>Better check yourself, you're not looking too good.</p>
                    </div>
                    <div id="tap_container" class="tap-container">
                        <h3 class="text-semibold">Please tap your rfid card</h3>
                        <input type="text" id="rfid_text" style="z-index: -1 !important;position: absolute;"
                            autocomplete="off">
                        <img src={{ asset('assets/imgs/tap.png') }} class="tap_img" alt="Tap Image" width="100%">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
