@extends('index')


@section('konten')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">

    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <h4 class="font-weight-bold mb-0" style="text-align: center;">PART IN</h4>
                    <div class="small-box bg-info">
                        <div class="inner">
                            <p class="font-weight-bold d-inline mb-0">Today</p>
                            <p class="font-weight-bold d-inline"> -- Rp. {{ number_format($valuetoday, 0, '.', ',') }}
                            </p>
                        </div>
                        <div class="inner pt-1">
                            <p class="font-weight-bold d-inline mb-0">This Month</p>
                            <p class="font-weight-bold d-inline"> -- Rp. {{ number_format($valuemonth, 0, '.', ',') }}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="partin" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <h4 class="font-weight-bold mb-0" style="text-align: center;">PART OUT</h4>
                    <div class="small-box bg-success">
                        <div class="inner">
                            <p class="font-weight-bold d-inline mb-0">Today</p>
                            <p class="font-weight-bold d-inline"> -- Rp. {{ number_format($todayout, 0, '.', ',') }}
                            </p>
                        </div>
                        <div class="inner pt-1">
                            <p class="font-weight-bold d-inline mb-0">This Month</p>
                            <p class="font-weight-bold d-inline"> -- Rp. {{ number_format($monthout, 0, '.', ',') }}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="sj" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <h4 class="font-weight-bold mb-0" style="text-align: center;">PRODUCTION</h4>
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <p class="font-weight-bold d-inline mb-0">Today</p>
                            <p class="font-weight-bold d-inline"> -- {{$prodtoday}} Rak</p>
                        </div>
                        <div class="inner pt-1">
                            <p class="font-weight-bold d-inline mb-0">Month</p>
                            <p class="font-weight-bold d-inline"> -- {{$prodmonth}} Rak</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="process" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <h4 class="font-weight-bold mb-0" style="text-align: center;">ORDER BOOKING</h4>
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <p class="font-weight-bold d-inline mb-0">This Month</p>
                            <p class="font-weight-bold d-inline"> -- Rp. {{ number_format($ordermonth, 0, '.', ',') }}
                            </p>
                        </div>
                        <div class="inner pt-1">
                            <p class="font-weight-bold d-inline mb-0">This Year</p>
                            <p class="font-weight-bold d-inline"> -- Rp. {{ number_format($orderyear, 0, '.', ',') }}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="orders" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-6 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">PART IN TODAY</h3>
                            <!-- <div class="card-tools">
                                                        <a href="#" class="btn btn-tool btn-sm">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-tool btn-sm">
                                                            <i class="fas fa-bars"></i>
                                                        </a>
                                                    </div> -->
                        </div>
                        <div class="card-body">
                            <table id="part-in" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Part</th>
                                        <th>Qty</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($part as $parts)
                                    <tr>
                                        <td>{{ $parts->Parts->customer->code }}</td>
                                        <td>{{ $parts->Parts->name_local }}</td>
                                        <td>{{ number_format($parts->qty, 0, '.', ',') }}</td>
                                        <td>{{ $parts->type }}</td>
                                        <td>{{ number_format($parts->total_price, 0, '.', ',') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.Left col -->
                <section class="col-lg-6 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">PRODUCTION TODAY</h3>
                            <!-- <div class="card-tools">
                                                        <a href="#" class="btn btn-tool btn-sm">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-tool btn-sm">
                                                            <i class="fas fa-bars"></i>
                                                        </a>
                                                    </div> -->
                        </div>
                        <div class="card-body">
                            <table id="prod-day" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Part</th>
                                        <th>Qty In</th>
                                        <th>Qty Out</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($production as $production)
                                    <tr>
                                        <td>{{$production->part->customer['code']}}</td>
                                        <td>{{$production->part->name_local}}</td>
                                        <td>{{$production->qty_in}}</td>
                                        <td>{{$production->packing->qty_out}}</td>
                                        <td>{{ $production->transaction->status}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection