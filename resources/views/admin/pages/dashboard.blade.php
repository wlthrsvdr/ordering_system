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
                <div class="col-sm-12">
                    <h3>Users</h3>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-4 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><i class="fa fa-credit-card"></i>&nbsp; {{ $student_count }}</h3>
                            <p>Total Customers</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-credit-card"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><i class="fa fa-user"></i> &nbsp; {{ $personnel_count }}</h3>

                            <p>Total University Cafeteria Staff</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><i class="fa fa-shield"></i>&nbsp; {{ $admin_count }}</h3>

                            <p>Total Registered Admin</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-shield"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <h3>Orders</h3>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><i class="fa fa-cart-arrow-down"></i>&nbsp; {{ $unpaid_order }}</h3>

                            <p>Total Unpaid Order</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-cart-arrow-down"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><i class="fa fa-cart-plus"></i>&nbsp; {{ $paid_order }}</h3>

                            <p>Total Paid Order</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-cart-plus"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><i class="fa fa-shopping-cart"></i>&nbsp; {{ $total_order }}</h3>

                            <p>Total Orders</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-12">
                    <h3>Sales</h3>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-6 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><i class="fa fa-money"></i>&nbsp; ₱
                                {{ $daily_sales ? $daily_sales : 0 }}</h3>

                            <p>Today Sales</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money"></i>
                        </div>
                        <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><i class="fa fa-money"></i>&nbsp;
                                ₱
                                {{ $montly_sales ? $montly_sales : 0 }}</h3>

                            <p>Monthly Sales</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money"></i>
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
