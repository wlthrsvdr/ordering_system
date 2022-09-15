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
                        <div class="col-lg-12 col-sm-6">
                            <span class="btn-group mb-1" style="float: right;">
                                <a href="{{ route('admin.report.export') }}" class="btn btn-md btn-primary mr-2">Export
                                    Data</a>
                            </span>
                        </div>
                        <div class="table-responsive">
                            @include('admin.pages.report.table', $orders)
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


    </div>
@endsection
