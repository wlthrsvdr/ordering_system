@extends('admin.components.mainlayout')


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Application</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Add Application</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 grid-margin stretch-card mt-3">
        <div class="card">
            <div class="card-body">
                <form action="" method="POST" enctype=multipart/form-data>
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
                                <label for="input_file">Apk</label>
                                <div class="custom-file">
                                    <input type="file" name="apk" class="custom-file-input" id="input_apk"
                                        value="{{ old('apk') }}" accept=".apk">
                                    <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                                </div>
                                <img id="output" class="responsive" />
                            </div>
                            <div class="form-group">
                                <a href="{{ route('admin.application.index') }}" class="btn btn-secondary mt-2">Go back</a>
                                <button type="submit" class="btn  btn-primary mt-2">Submit</button>
                            </div>
                </form>
            </div>
        </div>
    </div>
@endsection
