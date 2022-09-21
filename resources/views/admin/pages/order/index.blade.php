@extends('admin.components.mainlayout')


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Order Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Orders</a></li>
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
                    <a href="{{ route('admin.order.index') }}" class="btn btn-default btn-sm">[Reset
                        Filter]</a>
                </span>
            </div>
            <form action="">
                <div class="card-body">
                    <div class="row row-xs mb-4">
                        <div class="col-md-3">
                            <label for="">Keyword <small>(Transaction Number)</small></label>
                            <input type="text" class="form-control" placeholder="Keyword" name="keyword"
                                value="{{ $keyword }}">
                        </div>
                        <div class="col-md-3">
                            <label for="">Status</label>
                            <select class="form-control" aria-label="Default select example" name="status"
                                value="{{ $status }}">
                                <option value="">Open this select menu</option>
                                <option value="paid" {{ $status == 'paid' ? 'selected' : '' }}>Paid
                                </option>
                                <option value="unpaid" {{ $status == 'unpaid' ? 'selected' : '' }}>Unpaid
                                </option>
                                <option value="canceled" {{ $status == 'canceled' ? 'selected' : '' }}>Canceled
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Date Range</label>
                            <input type="date" class="form-control datepicker" placeholder="Start Date" name="start_date"
                                value="{{ $start_date }}">
                        </div>
                        <div class="col-md-3 mt-3 mt-md-0">
                            <label for="">&nbsp;</label>
                            <input type="date" class="form-control datepicker" placeholder="End Date" name="end_date"
                                value="{{ $end_date }}">
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
                                        <th>Transaction Number</th>
                                        <th>Orders</th>
                                        <th>Total Amount</th>
                                        <th>Order By</th>
                                        <th>Payment Status</th>
                                        <th>Order Status</th>
                                        <th>Order Date</th>
                                        {{-- <th>Paid By</th> --}}
                                        <th>Paid Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $index => $value)
                                        <tr>
                                            <td>
                                                @if ($value->transaction_number)
                                                    <div class="mb5">
                                                        {{ $value->transaction_number }}
                                                    </div>
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->order)
                                                    <ul>
                                                        @foreach ($value->order as $val)
                                                            <li>Product Name:
                                                                {{ $val['product_name'] }}({{ $val['quantity'] }}x)</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->total_amount)
                                                    <div class="mb5">
                                                        {{ $value->total_amount }}
                                                    </div>
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->orderBy)
                                                    <div class="mb5">
                                                        {{ $value->orderBy->name }}
                                                    </div>
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->payment_status)
                                                    @if ($value->payment_status == 'paid')
                                                        <div><span
                                                                class="badge badge-success">{{ Str::title($value->payment_status) }}</span>
                                                        </div>
                                                    @elseif($value->payment_status == 'pending')
                                                        <div><span
                                                                class="badge badge-warning">{{ Str::title($value->payment_status) }}</span>
                                                        </div>
                                                    @else
                                                        <div><span
                                                                class="badge badge-danger">{{ Str::title($value->payment_status) }}</span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->order_status)
                                                    <div class="mb5">
                                                        {{ $value->order_status }}
                                                    </div>
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->created_at)
                                                    <div class="mb5">
                                                        {{ $value->created_at->format('m-d-y') }}
                                                    </div>
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->paid_date)
                                                    <div class="mb5">
                                                        {{ $value->paid_date->format('m-d-y') }}
                                                    </div>
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-sm btn-primary btn-raised dropdown-toggle"
                                                    data-toggle="dropdown">Actions <span class="caret"></span></button>
                                                @if ($value->status != 'paid')
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton2">
                                                        <button class="dropdown-item" order-id="{{ $value->id }}"
                                                            id="pay-card-button">Pay via
                                                            card</button>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9">
                                                <p>No record found yet.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if ($orders->total() > 0)
                            <nav class="mt-2">
                                <p>Showing <strong>{{ $orders->firstItem() }}</strong> to
                                    <strong>{{ $orders->lastItem() }}</strong> of
                                    <strong>{{ $orders->total() }}</strong>
                                    entries
                                </p>
                                {!! $orders->appends(request()->query())->render() !!}
                                </ul>
                            </nav>
                        @endif


                    </div>
                </div>
            </div>
        </div>


        <div id="confirm-pay-via-card" class="modal fade">
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
                            <input type="text" id="rfid_text">
                            <img src={{ asset('assets/imgs/tap.png') }} class="tap_img" alt="Tap Image" width="100%">
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        {{-- <button type="submit" class="btn  btn-primary">Pay</button> --}}
                        {{-- <a href="#" class="btn btn-sm btn-danger" id="btn-confirm-pay-via-card">Pay</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
