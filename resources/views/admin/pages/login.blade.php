<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css" type="text/css">

    {{-- <link rel="stylesheet" href={{ asset('assets/css/bootstrap.min.css') }} type="text/css"> --}}

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" type="text/css">

    <link rel="stylesheet" href="/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"
        type="text/css">

    {{-- <link rel="stylesheet" href={{ asset('assets/css/style.css') }} type="text/css"> --}}

    <link rel="stylesheet" href="/assets/css/style.css" type="text/css">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 banner-container d-none d-sm-block">

            </div>
            <div class="col-lg-6 col-md-6 login-container">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col align-self-center">

                            <h3>Sign In</h3>
                            <form action="" method="POST">
                                {!! csrf_field() !!}
                                @if (session()->has('notification-status'))
                                    <div class="alert alert-{{ in_array(session()->get('notification-status'), ['failed', 'error', 'danger']) ? 'danger' : session()->get('notification-status') }}"
                                        role="alert">
                                        {{ session()->get('notification-msg') }}
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>Email address</label>
                                    <input type="email" class="form-control" placeholder="Enter email"
                                        name="email" />
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Enter password"
                                        name="password" />
                                </div>

                                <button type="submit" class="btn btn-danger btn-block mt-5">Submit</button>
                                <p class="forgot-password text-right mt-3">
                                    Forgot <a href="#">password?</a>
                                </p>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script type="text/javascript" src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

</html>
