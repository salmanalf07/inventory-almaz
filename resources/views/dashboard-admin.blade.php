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
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($part as $parts)
                                    <tr>
                                        <td>{{ $parts->Parts->customer->code }}</td>
                                        <td>{{ $parts->Parts->name_local }}</td>
                                        <td>{{ number_format($parts->qty, 0, '.', ',') }}</td>
                                        <td>{{ $parts->type }}</td>
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