@extends('admin.components.mainlayout')


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Category Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Category</a></li>
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
                    <a href="{{ route('admin.products.index') }}" class="btn btn-default btn-sm">[Reset
                        Filter]</a>

                </span>
            </div>
            <form action="">
                <div class="card-body">
                    <div class="row row-xs mb-4">
                        <div class="col-md-3">
                            <label for="">Keyword <small>(Product Name)</small></label>
                            <input type="text" class="form-control" placeholder="Keyword" name="keyword"
                                value="{{ $keyword }}">
                        </div>
                        <div class="col-md-3">
                            <label for="">Product Availability</label>
                            <select class="form-control" aria-label="Default select example" name="status"
                                value="{{ old('status', $status) }}">
                                <option value="">Open this select menu</option>
                                <option value="available" {{ $status == 'available' ? 'selected' : '' }}>Availbale
                                </option>
                                <option value="not available" {{ $status == 'not available' ? 'selected' : '' }}>Not
                                    Available
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
            <div class="card-header">
                <div><span class="float-right">
                        <a class="btn btn-sm btn-primary text-white" href="{{ route('admin.products.create') }}">Add
                            Product</a>
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
                                        <th>Product Category</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Added By</th>
                                        <th>Updated By</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $index => $value)
                                        <tr>
                                            <td>
                                                @if ($value->category->category_name)
                                                    <div class="mb5">
                                                        {{ $value->category->category_name }}
                                                    </div>
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->product_name)
                                                    <div class="mb5">
                                                        {{ $value->product_name }}
                                                    </div>
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->price)
                                                    <div class="mb5">
                                                        ₱ {{ $value->price }}
                                                    </div>
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->description)
                                                    <div class="mb5">
                                                        {{ $value->description }}
                                                    </div>
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->status)
                                                    @if ($value->status == 'available')
                                                        <div><span
                                                                class="badge badge-success">{{ Str::title($value->status) }}</span>
                                                        </div>
                                                    @else
                                                        <div><span
                                                                class="badge badge-danger">{{ Str::title($value->status) }}</span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->addedBy)
                                                    <div class="mb5">
                                                        {{ $value->addedBy->name }}
                                                    </div>
                                                @else
                                                    <div class="mb5">{{ '-' }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->updatedBy)
                                                    <div class="mb5">
                                                        {{ $value->updatedBy->name }}
                                                    </div>
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
                                                    <a href="{{ route('admin.products.update-status', [$value->id]) }}"
                                                        class="dropdown-item" style="cursor: pointer">
                                                        @if ($value->status == 'available')
                                                            Not Available
                                                        @else
                                                            Available
                                                        @endif
                                                    </a>
                                                    <a href="{{ route('admin.products.edit', [$value->id]) }}"
                                                        class="dropdown-item" style="cursor: pointer">
                                                        Update Information
                                                    </a>
                                                </div>
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
                        @if ($products->total() > 0)
                            <nav class="mt-2">
                                <p>Showing <strong>{{ $products->firstItem() }}</strong> to
                                    <strong>{{ $products->lastItem() }}</strong> of
                                    <strong>{{ $products->total() }}</strong>
                                    entries
                                </p>
                                {!! $products->appends(request()->query())->render() !!}
                                </ul>
                            </nav>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
