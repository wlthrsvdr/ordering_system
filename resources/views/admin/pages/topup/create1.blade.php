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
                        <li class="breadcrumb-item"><a href="#">Add Wallet</a></li>
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

                        <div id="back_tap_container" class="tap-container">
                            <h3>Please tap your rfid card</h3>
                            <input type="text" id="back_rfid_text">
                            <img src={{ asset('assets/imgs/tap.png') }} class="tap_img" alt="Tap Image" width="80%">
                        </div>

                        <div class="info-container" id="back_info_contianer" style="display: none">
                            <form action="" method="POST" enctype=multipart/form-data>
                                {!! csrf_field() !!}
                                <input type="hidden" id="back_rfid_info_text" name="rfid_text">
                                <input type="hidden" id="back_userId" name="userId">
                                <div class="form-group">
                                    {{-- <div class="form-group">
                                        <label for="input_student_num"><b>Student Number/Visitor Number</b></label>
                                        <input type="text" class="form-control" id="back_input_student_num"
                                            placeholder="" value="{{ old('student_number') }}" name="student_number"
                                            readonly>
                                        @if ($errors->first('student_number'))
                                            <p class="form-text text-danger">{{ $errors->first('student_number') }}</p>
                                        @endif
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="input_firstname"><b>Firstname</b></label>
                                        <input type="text" class="form-control" id="back_input_firstname" placeholder=""
                                            value="{{ old('firstname') }}" name="firstname" readonly>
                                        @if ($errors->first('firstname'))
                                            <p class="form-text text-danger">{{ $errors->first('firstname') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="input_middlename"><b>Middlename</b></label>
                                        <input type="text" class="form-control" id="back_input_middlename" placeholder=""
                                            value="{{ old('middlename') }}" name="middlename" readonly>
                                        @if ($errors->first('middlename'))
                                            <p class="form-text text-danger">{{ $errors->first('middlename') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="input_lastname"><b>Lastname</b></label>
                                        <input type="text" class="form-control" id="back_input_lastname" placeholder=""
                                            value="{{ old('lastname') }}" name="lastname" readonly>
                                        @if ($errors->first('lastname'))
                                            <p class="form-text text-danger">{{ $errors->first('lastname') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="input_lastname"><b>Contact Number</b></label>
                                        <input type="text" class="form-control" id="back_input_contact_number"
                                            placeholder="" value="{{ old('contact_number') }}" name="contact_number"
                                            readonly>
                                        @if ($errors->first('contact_number'))
                                            <p class="form-text text-danger">{{ $errors->first('contact_number') }}</p>
                                        @endif
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="input_account_tpe"><b>Account Type</b></label>
                                        <input type="text" class="form-control" id="input_account_tpe" placeholder=""
                                            value="{{ old('account_type') }}" name="account_type" readonly>
                                        @if ($errors->first('account_type'))
                                            <p class="form-text text-danger">{{ $errors->first('account_type') }}</p>
                                        @endif
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="input_balance"><b>Current Balance</b></label>
                                        <input type="text" class="form-control" id="back_input_balance" placeholder=""
                                            value="{{ old('balance') }}" name="balance" readonly>
                                        @if ($errors->first('balance'))
                                            <p class="form-text text-danger">{{ $errors->first('balance') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="input_amount"><b>Amount</b></label>
                                        <input type="text" class="form-control" id="back_input_amount" placeholder=""
                                            value="{{ old('amount') }}" name="amount">
                                        @if ($errors->first('amount'))
                                            <p class="form-text text-danger">{{ $errors->first('amount') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <a href="{{ route('admin.wallet.topup') }}" class="btn btn-secondary">Go
                                            back</a>
                                        <button type="submit" class="btn  btn-primary">Topup</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
