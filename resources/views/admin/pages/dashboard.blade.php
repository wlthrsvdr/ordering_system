@extends('admin.components.mainlayout')


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>



    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-4 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><i class="fa fa-clock-o"></i>&nbsp; {{ '0' }}</h3>
                            <p>Total Pending Orders</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><i class="fa fa-pie-chart"></i> &nbsp; {{ '0' }}</h3>

                            <p>Total Paid Order Orders</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-pie-chart"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><i class="fa fa-line-chart"></i>&nbsp; {{ '0' }}</h3>

                            <p>Total Orders</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-line-chart"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            
            {{-- <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><i class="fa fa-school"></i>&nbsp; {{ '0' }}</h3>

                            <p>Total School Youth Users</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-school"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><i class="fa fa-user-tie"></i>&nbsp; {{ '0' }}</h3>

                            <p>Total Senior Citizen Users</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user-tie"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><i class="fas fa-wheelchair"></i>&nbsp; {{ '0' }}</h3>
                            <p>Total PWD Users</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-wheelchair"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div> --}}


        </div>
    </section>
@endsection
