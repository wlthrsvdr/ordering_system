@extends('admin.components.mainlayout')


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Product Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Update Product Information</a></li>
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
                                <label for="">Product Category</label>
                                <select class="custom-select mw-100" aria-label="Default select example"
                                    name="product_category" value={{ old('product_category') }}>
                                    <option value="">--Product Categories--</option>
                                    @foreach ($categories as $index => $values)
                                        <option value={{ $values->id }}
                                            {{ $product->id == $values->id ? 'selected' : '' }}>
                                            {{ $values->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="input_product_name"><b>Product Name</b></label>
                                <input type="text" class="form-control" id="input_product_name" placeholder=""
                                    value="{{ old('product_name', $product->product_name) }}" name="product_name">
                                @if ($errors->first('product_name'))
                                    <p class="form-text text-danger">{{ $errors->first('product_name') }}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="input_price"><b>Price</b></label>
                                <input type="text" class="form-control" id="input_price" placeholder=""
                                    value="{{ old('price', $product->price) }}" name="price">
                                @if ($errors->first('price'))
                                    <p class="form-text text-danger">{{ $errors->first('price') }}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="input_description"><b>Description</b></label>
                                <textarea class="form-control" id="input_description" rows="3" name="description"
                                    value="{{ $product->description }}">{{ $product->description }}</textarea>
                                @if ($errors->first('description'))
                                    <p class="form-text text-danger">{{ $errors->first('description') }}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="input_file">Product Image</label>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="input_img"
                                        value="{{ old('image') }}">
                                    <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                                </div>
                                <div class="img-fluid px-3 gallery mt-2">
                                    {{-- <a href="{{ $product->image_path }}" title="Uploaded Image Product"> --}}
                                    <img src={{ asset('uploads/product-images/' . $product->image_filename) }}
                                        class="img-rounded" alt="attachment" width="335" height="267" id="output">
                                    {{-- </a> --}}
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Go back to
                                    Product
                                    List</a>
                                <button type="submit" class="btn  btn-primary">Submit</button>
                            </div>
                </form>
            </div>
        </div>
    </div>
@endsection
