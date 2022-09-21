@extends('admin.components.mainlayout')


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">RFID Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Register Card</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-sm-12 grid-margin stretch-card mt-3">

        <div class="card">
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-12 col-sm-12">
                        <div class="alert alert-dismissible" role="alert" style="display:none;">
                            <strong>Warning!</strong>
                            <p>Better check yourself, you're not looking too good.</p>
                        </div>
                        @if (session()->has('notification-status'))
                            <div class="alert alert-{{ in_array(session()->get('notification-status'), ['failed', 'error', 'danger']) ? 'danger' : session()->get('notification-status') }}"
                                role="alert">
                                {{ session()->get('notification-msg') }}
                            </div>
                        @endif

                        <div id="tap_container" class="tap-container">
                            <h3>Please tap your rfid card</h3>
                            <input type="text" id="rfid_text">
                            <img src={{ asset('assets/imgs/tap.png') }} class="tap_img" alt="Tap Image" width="80%">
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
    @endsection
