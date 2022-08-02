@extends('admin.components.mainlayout')


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Add Category</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 grid-margin stretch-card mt-3">
        <div class="card">
            <div class="card-body">
                <form action="" method="POST">
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
                                <label for="input_category_code"><b>Category Code</b></label>
                                <input type="text" class="form-control" id="input_category_code" placeholder=""
                                    value="{{ old('category_code') }}" name="category_code">
                                @if ($errors->first('category_code'))
                                    <p class="form-text text-danger">{{ $errors->first('category_code') }}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="input_category"><b>Category Name</b></label>
                                <input type="text" class="form-control" id="input_category" placeholder=""
                                    value="{{ old('category_name') }}" name="category_name">
                                @if ($errors->first('category_name'))
                                    <p class="form-text text-danger">{{ $errors->first('category_name') }}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Go back to
                                    Category
                                    List</a>
                                <button type="submit" class="btn  btn-primary">Submit</button>
                            </div>
                </form>
            </div>
        </div>
    </div>
@endsection
