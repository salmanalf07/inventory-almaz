@extends('index')


@section('konten')
<style>
    .modal-ku {
        max-width: 1500px;
        font-size: 0.8rem !important;
    }

    .modal-ku .form-control {
        font-size: 0.8rem !important;
        height: fit-content;
    }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$judul}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{$judul}}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>No Invoice</th>
                                        <th>No SJ</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>No Invoice</th>
                                        <th>No SJ</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- Modal user -->
    <div id="myModal" class="modal fade bd-example-modal-xl" tabindex="-1" data-focus="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-ku" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button onclick="reset_form()" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Data</h4>
                </div>
                <div class="modal-body">
                    <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                        <span id="peringatan"></span>
                        <input class="form-control" type="text" name="id" id="id" hidden>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label>Date</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="date_sj" id="date_sj" class="form-control datetimepicker-input" data-target="#reservationdate" />
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">No SJ</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="nosj" id="nosj" value="{{ Auth::user()->name }}" readonly class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">Customer</label>
                                    <div class="controls">
                                        <select name="cust_id" id="cust_id" class="form-control select2">
                                            <option value="" selected="selected">Choose...</option>
                                            @foreach($customer as $customer)
                                            <option value="{{$customer->id}}">{{$customer->code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Number PO</label>
                                    <div class="controls">
                                        <select name="order_id" id="order_id" class="form-control select2" style="width: 100%;">
                                            <option value="" selected="selected">Choose...</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Invoice</label>
                                    <div class="controls">
                                        <select name="invoice_id" id="invoice_id" class="form-control select2" style="width: 100%;">
                                            <option value="" selected="selected">Choose...</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Booking Month</label>
                                    <div class="controls">
                                        <select name="booking_month" id="booking_month" class="form-control select2" style="width: 100%;">
                                            <option value="" selected="selected">Choose...</option>
                                            <option value="1">JANUARI</option>
                                            <option value="2">FEBRUARI</option>
                                            <option value="3">MARET</option>
                                            <option value="4">APRIL</option>
                                            <option value="5">MEI</option>
                                            <option value="6">JUNI</option>
                                            <option value="7">JULI</option>
                                            <option value="8">AGUSTUS</option>
                                            <option value="9">SEPTEMBER</option>
                                            <option value="10">OKTOBER</option>
                                            <option value="11">NOVEMBER</option>
                                            <option value="12">DESEMBER</option>


                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Booking Year</label>
                                    <div class="controls">
                                        <select name="booking_year" id="booking_year" class="form-control select2" style="width: 100%;">
                                            <option value="" selected="selected">Choose...</option>
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                            <option value="2028">2028</option>
                                            <option value="2029">2029</option>
                                            <option value="2030">2030</option>
                                            <option value="2031">2031</option>
                                            <option value="2032">2032</option>
                                            <option value="2033">2033</option>
                                            <option value="2034">2034</option>
                                            <option value="2035">2035</option>
                                            <option value="2036">2036</option>
                                            <option value="2037">2037</option>
                                            <option value="2038">2038</option>
                                            <option value="2039">2039</option>
                                            <option value="2040">2040</option>
                                            <option value="2041">2041</option>
                                            <option value="2042">2042</option>
                                            <option value="2043">2043</option>
                                            <option value="2044">2044</option>
                                            <option value="2045">2045</option>
                                            <option value="2046">2046</option>
                                            <option value="2047">2047</option>
                                            <option value="2048">2048</option>
                                            <option value="2049">2049</option>
                                            <option value="2050">2050</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">User</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="user_id" id="user_id" value="{{ Auth::user()->name }}" readonly class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">Car</label>
                                    <div class="controls">
                                        <select name="car_id" id="car_id" class="form-control select2">
                                            <option value="" selected="selected">Choose...</option>
                                            @foreach($car as $car)
                                            <option value="{{$car->id}}">{{$car->nopol}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">Driver</label>
                                    <div class="controls">
                                        <select name="driver_id" id="driver_id" class="form-control select2">
                                            <option value="" selected="selected">Choose...</option>
                                            @foreach($driver as $driver)
                                            <option value="{{$driver->id}}">{{$driver->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">Part Name</label>
                                <div class="card" style=" width: 15rem">
                                    <button type="button" name="add-tab" id="add-tab" class="btn btn-secondary">Add More Row</button>
                                    <button type="button" name="revisi-tab" id="revisi-tab" class="btn btn-secondary">Revisi</button>
                                </div>
                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <table class="table table-striped" id="dynamicAddRemove">
                                            <thead>
                                                <tr>
                                                    <th style="width: 28%">Part Name</th>
                                                    <th style="width: 10%">Type</th>
                                                    <th style="width: 8%">Qty</th>
                                                    <th style="width: 9%">Qty Pack</th>
                                                    <th style="width: 10%">Type Pack</th>
                                                    <th style="width: 10%">Price</th>
                                                    <th style="width: 15%">Total Price</th>
                                                    <th style="width: 18%">Keterangan</th>
                                                    <th style="width: 3%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="roww">
                                                <tr id="tr1">
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id0" readonly hidden>
                                                        <select name="part_id[]" id="part_id0" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type0" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="REGULER">REGULER</option>
                                                            <option value="BAYAR_RETUR">BAYAR RETUR</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="SAMPEL">SAMPEL</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty0" placeholder="Qty">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="qty_pack[]" id="qty_pack0" placeholder="Pack">
                                                    </td>
                                                    <td>
                                                        <select name="type_pack[]" id="type_pack0" class="form-control select2">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="-">-</option>
                                                            <option value="BOX">BOX</option>
                                                            <option value="PALLET">PALLET</option>
                                                            <option value="KERETA">KERETA</option>
                                                            <option value="KARDUS">KARDUS</option>
                                                            <option value="KANTONG">KANTONG</option>
                                                            <option value="BOX-PALLET">BOX-PALLET</option>
                                                            <option value="KRETA-PALLET">KRETA-PALLET</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price0" readonly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price0" readonly>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="keterangan[]" id="keterangan0" placeholder="Keterangan" cols="10" rows="1">-</textarea>
                                                    </td>
                                                    <td>
                                                        <button id="del_part0" class="close mt-1" type="button" aria-hidden="true"><i class="fas fa-times-circle" style="color:red"></i></button>
                                                    </td>
                                                </tr>
                                                <tr id="tr2">
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id1" readonly hidden>
                                                        <select name="part_id[]" id="part_id1" class="form-control select1" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type1" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="REGULER">REGULER</option>
                                                            <option value="BAYAR_RETUR">BAYAR RETUR</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="SAMPEL">SAMPEL</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty1" placeholder="Qty">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="qty_pack[]" id="qty_pack1" placeholder="Pack">
                                                    </td>
                                                    <td>
                                                        <select name="type_pack[]" id="type_pack1" class="form-control">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="-">-</option>
                                                            <option value="BOX">BOX</option>
                                                            <option value="PALLET">PALLET</option>
                                                            <option value="KERETA">KERETA</option>
                                                            <option value="KARDUS">KARDUS</option>
                                                            <option value="KANTONG">KANTONG</option>
                                                            <option value="BOX-PALLET">BOX-PALLET</option>
                                                            <option value="KRETA-PALLET">KRETA-PALLET</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price1" readonly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price1" readonly>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="keterangan[]" id="keterangan1" placeholder="Keterangan" cols="10" rows="1">-</textarea>
                                                    </td>
                                                    <td>
                                                        <button id="del_part1" class="close mt-1" type="button" aria-hidden="true"><i class="fas fa-times-circle" style="color:red"></i></button>
                                                    </td>
                                                </tr>
                                                <tr id="tr3">
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id2" readonly hidden>
                                                        <select name="part_id[]" id="part_id2" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type2" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="REGULER">REGULER</option>
                                                            <option value="BAYAR_RETUR">BAYAR RETUR</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="SAMPEL">SAMPEL</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty2" placeholder="Qty">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="qty_pack[]" id="qty_pack2" placeholder="Pack">
                                                    </td>
                                                    <td>
                                                        <select name="type_pack[]" id="type_pack2" class="form-control">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="-">-</option>
                                                            <option value="BOX">BOX</option>
                                                            <option value="PALLET">PALLET</option>
                                                            <option value="KERETA">KERETA</option>
                                                            <option value="KARDUS">KARDUS</option>
                                                            <option value="KANTONG">KANTONG</option>
                                                            <option value="BOX-PALLET">BOX-PALLET</option>
                                                            <option value="KRETA-PALLET">KRETA-PALLET</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price2" readonly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price2" readonly>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="keterangan[]" id="keterangan2" placeholder="Keterangan" cols="10" rows="1">-</textarea>
                                                    </td>
                                                    <td>
                                                        <button id="del_part2" class="close mt-1" type="button" aria-hidden="true"><i class="fas fa-times-circle" style="color:red"></i></button>
                                                    </td>
                                                </tr>
                                                <tr id="tr4">
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id3" readonly hidden>
                                                        <select name="part_id[]" id="part_id3" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type3" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="REGULER">REGULER</option>
                                                            <option value="BAYAR_RETUR">BAYAR RETUR</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="SAMPEL">SAMPEL</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty3" placeholder="Qty">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="qty_pack[]" id="qty_pack3" placeholder="Pack">
                                                    </td>
                                                    <td>
                                                        <select name="type_pack[]" id="type_pack3" class="form-control">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="-">-</option>
                                                            <option value="BOX">BOX</option>
                                                            <option value="PALLET">PALLET</option>
                                                            <option value="KERETA">KERETA</option>
                                                            <option value="KARDUS">KARDUS</option>
                                                            <option value="KANTONG">KANTONG</option>
                                                            <option value="BOX-PALLET">BOX-PALLET</option>
                                                            <option value="KRETA-PALLET">KRETA-PALLET</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price3" readonly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price3" readonly>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="keterangan[]" id="keterangan3" placeholder="Keterangan" cols="10" rows="1">-</textarea>
                                                    </td>
                                                    <td>
                                                        <button id="del_part3" class="close mt-1" type="button" aria-hidden="true"><i class="fas fa-times-circle" style="color:red"></i></button>
                                                    </td>
                                                </tr>
                                                <tr id="tr5">
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id4" readonly hidden>
                                                        <select name="part_id[]" id="part_id4" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type4" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="REGULER">REGULER</option>
                                                            <option value="BAYAR_RETUR">BAYAR RETUR</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="SAMPEL">SAMPEL</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty4" placeholder="Qty">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="qty_pack[]" id="qty_pack4" placeholder="Pack">
                                                    </td>
                                                    <td>
                                                        <select name="type_pack[]" id="type_pack4" class="form-control">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="-">-</option>
                                                            <option value="BOX">BOX</option>
                                                            <option value="PALLET">PALLET</option>
                                                            <option value="KERETA">KERETA</option>
                                                            <option value="KARDUS">KARDUS</option>
                                                            <option value="KANTONG">KANTONG</option>
                                                            <option value="BOX-PALLET">BOX-PALLET</option>
                                                            <option value="KRETA-PALLET">KRETA-PALLET</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price4" readonly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price4" readonly>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="keterangan[]" id="keterangan4" placeholder="Keterangan" cols="10" rows="1">-</textarea>
                                                    </td>
                                                    <td>
                                                        <button id="del_part4" class="close mt-1" type="button" aria-hidden="true"><i class="fas fa-times-circle" style="color:red"></i></button>
                                                    </td>
                                                </tr>
                                                <tr id="tr6">
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id5" readonly hidden>
                                                        <select name="part_id[]" id="part_id5" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type5" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="REGULER">REGULER</option>
                                                            <option value="BAYAR_RETUR">BAYAR RETUR</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="SAMPEL">SAMPEL</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty5" placeholder="Qty">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="qty_pack[]" id="qty_pack5" placeholder="Pack">
                                                    </td>
                                                    <td>
                                                        <select name="type_pack[]" id="type_pack5" class="form-control">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="-">-</option>
                                                            <option value="BOX">BOX</option>
                                                            <option value="PALLET">PALLET</option>
                                                            <option value="KERETA">KERETA</option>
                                                            <option value="KARDUS">KARDUS</option>
                                                            <option value="KANTONG">KANTONG</option>
                                                            <option value="BOX-PALLET">BOX-PALLET</option>
                                                            <option value="KRETA-PALLET">KRETA-PALLET</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price5" readonly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price5" readonly>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="keterangan[]" id="keterangan5" placeholder="Keterangan" cols="10" rows="1">-</textarea>
                                                    </td>
                                                    <td>
                                                        <button id="del_part5" class="close mt-1" type="button" aria-hidden="true"><i class="fas fa-times-circle" style="color:red"></i></button>
                                                    </td>
                                                </tr>
                                                <tr id="tr7">
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id6" readonly hidden>
                                                        <select name="part_id[]" id="part_id6" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type6" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="REGULER">REGULER</option>
                                                            <option value="BAYAR_RETUR">BAYAR RETUR</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="SAMPEL">SAMPEL</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty6" placeholder="Qty">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="qty_pack[]" id="qty_pack6" placeholder="Pack">
                                                    </td>
                                                    <td>
                                                        <select name="type_pack[]" id="type_pack6" class="form-control">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="-">-</option>
                                                            <option value="BOX">BOX</option>
                                                            <option value="PALLET">PALLET</option>
                                                            <option value="KERETA">KERETA</option>
                                                            <option value="KARDUS">KARDUS</option>
                                                            <option value="KANTONG">KANTONG</option>
                                                            <option value="BOX-PALLET">BOX-PALLET</option>
                                                            <option value="KRETA-PALLET">KRETA-PALLET</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price6" readonly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price6" readonly>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="keterangan[]" id="keterangan6" placeholder="Keterangan" cols="10" rows="1">-</textarea>
                                                    </td>
                                                    <td>
                                                        <button id="del_part6" class="close mt-1" type="button" aria-hidden="true"><i class="fas fa-times-circle" style="color:red"></i></button>
                                                    </td>
                                                </tr>
                                                <tr id="tr8">
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id7" readonly hidden>
                                                        <select name="part_id[]" id="part_id7" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type7" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="REGULER">REGULER</option>
                                                            <option value="BAYAR_RETUR">BAYAR RETUR</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="SAMPEL">SAMPEL</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price7" readonly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty7" placeholder="Qty">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="qty_pack[]" id="qty_pack7" placeholder="Pack">
                                                    </td>
                                                    <td>
                                                        <select name="type_pack[]" id="type_pack7" class="form-control">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="-">-</option>
                                                            <option value="BOX">BOX</option>
                                                            <option value="PALLET">PALLET</option>
                                                            <option value="KERETA">KERETA</option>
                                                            <option value="KARDUS">KARDUS</option>
                                                            <option value="KANTONG">KANTONG</option>
                                                            <option value="BOX-PALLET">BOX-PALLET</option>
                                                            <option value="KRETA-PALLET">KRETA-PALLET</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price7" readonly>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="keterangan[]" id="keterangan7" placeholder="Keterangan" cols="10" rows="1">-</textarea>
                                                    </td>
                                                    <td>
                                                        <button id="del_part7" class="close mt-1" type="button" aria-hidden="true"><i class="fas fa-times-circle" style="color:red"></i></button>
                                                    </td>
                                                </tr>
                                                <tr id="tr9">
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id8" readonly hidden>
                                                        <select name="part_id[]" id="part_id8" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type8" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="REGULER">REGULER</option>
                                                            <option value="BAYAR_RETUR">BAYAR RETUR</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="SAMPEL">SAMPEL</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty8" placeholder="Qty">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="qty_pack[]" id="qty_pack8" placeholder="Pack">
                                                    </td>
                                                    <td>
                                                        <select name="type_pack[]" id="type_pack8" class="form-control">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="-">-</option>
                                                            <option value="BOX">BOX</option>
                                                            <option value="PALLET">PALLET</option>
                                                            <option value="KERETA">KERETA</option>
                                                            <option value="KARDUS">KARDUS</option>
                                                            <option value="KANTONG">KANTONG</option>
                                                            <option value="BOX-PALLET">BOX-PALLET</option>
                                                            <option value="KRETA-PALLET">KRETA-PALLET</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price8" readonly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price8" readonly>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="keterangan[]" id="keterangan8" placeholder="Keterangan" cols="10" rows="1">-</textarea>
                                                    </td>
                                                    <td>
                                                        <button id="del_part8" class="close mt-1" type="button" aria-hidden="true"><i class="fas fa-times-circle" style="color:red"></i></button>
                                                    </td>
                                                </tr>
                                                <tr id="tr10">
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id9" readonly hidden>
                                                        <select name="part_id[]" id="part_id9" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type9" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="REGULER">REGULER</option>
                                                            <option value="BAYAR_RETUR">BAYAR RETUR</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="SAMPEL">SAMPEL</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty9" placeholder="Qty">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="qty_pack[]" id="qty_pack9" placeholder="Pack">
                                                    </td>
                                                    <td>
                                                        <select name="type_pack[]" id="type_pack9" class="form-control">
                                                            <option value="" selected="selected">Choose...</option>
                                                            <option value="-">-</option>
                                                            <option value="BOX">BOX</option>
                                                            <option value="PALLET">PALLET</option>
                                                            <option value="KERETA">KERETA</option>
                                                            <option value="KARDUS">KARDUS</option>
                                                            <option value="KANTONG">KANTONG</option>
                                                            <option value="BOX-PALLET">BOX-PALLET</option>
                                                            <option value="KRETA-PALLET">KRETA-PALLET</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price9" readonly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price9" readonly>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="keterangan[]" id="keterangan9" placeholder="Keterangan" cols="10" rows="1">-</textarea>
                                                    </td>
                                                    <td>
                                                        <button id="del_part9" class="close mt-1" type="button" aria-hidden="true"><i class="fas fa-times-circle" style="color:red"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="form-control" name="part_po" id="part_po" type="text" readonly>
                                                    </td>
                                                    <td>
                                                        <p style="text-align: right;">Progress PO</p>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" name="qty_po" id="qty_po" type="text" readonly>
                                                    </td>
                                                    <td colspan="3">
                                                        <p style="text-align: right;">Grand Total</p>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" name="grand_total" id="grand_total" type="text" readonly>
                                                    </td>
                                                    <td colspan="2"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label>Return Date SJ</label>
                                    <div class="input-group date" id="reservationsj" data-target-input="nearest">
                                        <input type="text" name="kembali_sj" id="kembali_sj" class="form-control datetimepicker-input" data-target="#reservationsj" />
                                        <div class="input-group-append" data-target="#reservationsj" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label>Return Date SJ Rev.</label>
                                    <div class="input-group date" id="reservationrev" data-target-input="nearest">
                                        <input type="text" name="kembali_rev" id="kembali_rev" class="form-control datetimepicker-input" data-target="#reservationrev" />
                                        <div class="input-group-append" data-target="#reservationrev" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">Status</label>
                                    <div class="controls">
                                        <select name="status" id="status" class="form-control">
                                            <option value="" selected="selected">Choose...</option>
                                            <option value="OPEN">OPEN</option>
                                            <option value="INVOICE">INVOICE</option>
                                            <option value="BAYAR_RETUR">BAYAR RETUR</option>
                                            <option value="CLOSE">CLOSE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="control-group">
                                    <label class="control-label">Detail Rev</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="revisi" id="revisi" placeholder="Type something here..." class="span15" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="reset_form()">Close</button>
                    <button id="in" type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal tracking -->
    <div id="trackingmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none ;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button onclick="reset_form();" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-titlee" id="trackingLabel">Tracking</h4>
                </div>
                <div class="modal-body">
                    <table class="table track_tbl">
                        <thead>
                        </thead>
                        <tbody id="tracking-data">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button onclick="reset_form();" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal print -->
    <div id="printmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none ;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button onclick="reset_form();" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-titlee" id="printLabel">Print</h4>
                </div>
                <form method="post" role="form" id="form-print" action="print_sj" enctype="multipart/form-data" formtarget="_blank" target="_blank">
                    <div class="modal-body">
                        @csrf
                        <span id="peringatan"></span>
                        <input class="form-control" type="text" name="id_print" id="id_print" hidden>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="control-group">
                                    <label>Date</label>
                                    <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                                        <input type="text" name="datee" id="datee" class="form-control datetimepicker-input" data-target="#reservationdate1" />
                                        <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button onclick="reset_form();" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input id="subpr" class="btn btn-primary" type="submit" value="Process">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="assets/css/jquery/jquery.min.js"></script>
<!-- <script src="/js/jquery-3.5.1.js"></script> -->
<script>
    $(document).ready(function() {
        //open-user
        $.fn.dataTable.ext.buttons.add = {
            text: 'Add Part Out',
            action: function(e, dt, node, config) {
                $('#grand_total').val(0);
                $('.modal-title').text('Tambah Data');
                $("#in").show();
                $("#in").removeClass("btn btn-primary update");
                $("#in").addClass("btn btn-primary add");
                $('#in').text('Save');
                $('#update_pass').hide();
                $('#password').show();
                //reset_form();
                $("#tr2,#tr3,#tr4,#tr5,#tr6,#tr7,#tr8,#tr9,#tr10").hide();
                $("#del_part0,#del_part1,#del_part2,#del_part3,#del_part4,#del_part5,#del_part6,#del_part7,#del_part8,#del_part9").hide();
                $('#add-tab').show();
                $('#revisi-tab').hide();
                var date = new Date();
                $("#date_sj").val(date.getDate() + "/" + ("0" + (date.getMonth() + 1)).slice(-2) + "/" + date.getFullYear());
                $("#nosj").val(parseInt("{{$sj->nosj}}") + 1);
                rtab = 1;
                $('[name="part_id[]"],[name="type_pack[]"],[name="qty[]"],[name="qty_pack[]"]').attr("disabled", false);
                AutoNumeric.multiple('.autonumeric-integer', AutoNumeric.getPredefinedOptions().integerPos);
                $('#myModal').modal('show');
            }
        };
        $.fn.dataTable.ext.buttons.filter = {
            text: '<div class="input-group">' +
                '<button type="button" class="btn btn-default float-right" id="daterange-btn">' +
                '<i class="far fa-calendar-alt"></i>&nbsp;<span></span>&nbsp;' +
                '<i class="fas fa-caret-down"></i>' +
                '</button>' +
                '</div>',
        };
        var datein, dateen;
        var oTable = $('#example1').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [1, "desc"]
            ],
            dom: 'Bfrtip',
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "columnDefs": [{
                    "className": "text-center",
                    "targets": [0, 1, 2, 3, 4, 5, 6], // table ke 1
                },
                {
                    "visible": false,
                    "targets": [2]
                },
                {
                    targets: 1,
                    render: function(oTable) {
                        return moment(oTable).format('DD-MM-YYYY');
                    },
                },
                {
                    targets: 5,
                    render: $.fn.dataTable.render.number('.')
                },

            ],
            "buttons": ["add",
                {
                    extend: "colvis",
                    text: '<i class="fas fa-border-all"></i>'
                },
                "filter"

            ],
            ajax: {
                url: '{{ url("json_sj") }}',
                data: function(d) {
                    // Retrieve dynamic parameters
                    var dt_params = $('#example1').data('dt_params');
                    // Add dynamic parameters to the data object sent to the server
                    if (dt_params) {
                        $.extend(d, dt_params);
                    }
                }
            },
            "fnCreatedRow": function(row, data, index) {
                $('td', row).eq(0).html(index + 1);
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'date_sj',
                    name: 'date_sj'
                },
                {
                    data: 'invoice_id',
                    name: 'invoice_id'
                },
                {
                    data: 'nosj',
                    name: 'nosj'
                },
                {
                    data: 'customer.code',
                    name: 'customer.code'
                },
                {
                    data: 'grand_total',
                    name: 'grand_total'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                }
            ],
        });
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment(),
                endDate: moment()
            },
            function(start, end) {
                $('#daterange-btn span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'))
                datein = start.format('YYYY-MM-DD');
                dateen = end.format('YYYY-MM-DD');
                $('#example1').data('dt_params', {
                    'datein': datein,
                    'dateen': dateen,
                });
                $('#example1').DataTable().draw();
            }
        );
        $("#tr2,#tr3,#tr4,#tr5,#tr6,#tr7,#tr8,#tr9,#tr10").hide();
        $('#add-tab').show();
        $('#revisi-tab').hide();
        var rtab = 1;
        $('#add-tab').click(function() {
            rtab++;
            $("#tr" + rtab).show();
        });
        $('#revisi-tab').click(function() {
            $('[name="part_id[]"],[name="type_pack[]"],[name="qty[]"],[name="qty_pack[]"],[name="keterangan[]"]').attr("disabled", false);
        });
    });
    //add data
    $('.modal-footer').on('click', '.add', function() {
        $("#pageloader").fadeIn();
        var form = document.getElementById("form-add");
        var fd = new FormData(form);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("store_sj") }}',
            data: fd,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data[1]) {
                    let text = "";
                    var dataa = Object.assign({}, data[0])
                    for (let x in dataa) {
                        text += "<div class='alert alert-dismissible hide fade in alert-danger show'><strong>Errorr!</strong> " + dataa[x] + "<a href='#' class='close float-close' data-dismiss='alert' aria-label='close'>×</a></div>";
                    }
                    $('#peringatan').append(text);
                } else {
                    $('#myModal').modal('hide');
                    reset_form();
                    // $('#example1').DataTable().ajax.reload();
                    location.reload();
                }

            },
        });
    });
    //end add data
    //edit data
    $(document).on('click', '#edit', function(e) {
        //reset_form();
        e.preventDefault();
        var uid = $(this).data('id');
        var newDateOptions = {
            year: "numeric",
            month: "2-digit",
            day: "2-digit"
        }

        $.ajax({
            type: 'POST',
            url: 'edit_sj',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': uid,
            },
            success: function(data) {
                //console.log(data.detail_s_j.length);

                //isi form
                $('#id').val(data.id);
                $('#cust_id').val(data.cust_id).trigger('change').attr("disabled", true);
                if (data.order_id != null) {
                    setTimeout(function() {
                        $('#order_id').val(data.order_id).trigger('change').attr("disabled", true);
                    }, 2000);
                }
                if (data.invoice_id != null) {
                    setTimeout(function() {
                        $('#invoice_id').val(data.invoice_id).trigger('change').attr("disabled", true);
                    }, 2000);
                }
                setTimeout(function() {
                    for (let j = 0; j < data.detail_s_j.length; j++) {
                        $('#part_id' + j).val(data.detail_s_j[j].part_id).trigger('change').attr("disabled", true);
                    }
                }, 2000);
                setTimeout(function() {
                    for (let i = 0; i < data.detail_s_j.length; i++) {
                        $('#detail_id' + i).val(data.detail_s_j[i].id);
                        $('#type' + i).val(data.detail_s_j[i].type).trigger('change').attr("disabled", true);
                        $('#qty_pack' + i).val(data.detail_s_j[i].qty_pack).attr("disabled", true);
                        $('#type_pack' + i).val(data.detail_s_j[i].type_pack).trigger('change').attr("disabled", true);
                        if (data.detail_s_j[i].keterangan === null) {
                            $('#keterangan' + i).val("-").attr("disabled", true);
                        } else {
                            $('#keterangan' + i).val(data.detail_s_j[i].keterangan).attr("disabled", true);
                        }
                    }
                }, 2000);
                let grand_total = 0;
                setTimeout(function() {
                    for (let k = 0; k < data.detail_s_j.length; k++) {
                        $('#qty' + k).val(data.detail_s_j[k].qty).attr("disabled", true);
                        $('#price' + k).val(data.detail_s_j[k].total_price / data.detail_s_j[k].qty);
                        $('#total_price' + k).val(data.detail_s_j[k].total_price);
                        grand_total += parseInt(data.detail_s_j[k].total_price);
                        $('#grand_total').val(grand_total);
                    }
                }, 2000);
                setTimeout(function() {
                    AutoNumeric.multiple('.autonumeric-integer', AutoNumeric.getPredefinedOptions().integerPos);
                }, 2100);
                $('#add-tab').hide();
                $('#revisi-tab').show();
                $("#del_part0,#del_part1,#del_part2,#del_part3,#del_part4,#del_part5,#del_part6,#del_part7,#del_part8,#del_part9").show()
                $("#tr2,#tr3,#tr4,#tr5,#tr6,#tr7,#tr8,#tr9,#tr10").hide();
                for (let i = 1; i <= data.detail_s_j.length; i++) {
                    $("#tr" + i).show().attr("disabled", false);
                }
                $('#user_id').val(data.user.name);
                $('#nosj').val(data.nosj);
                $('#date_sj').val(new Date(data.date_sj).toLocaleString("id-ID", newDateOptions).split(' ')[0]);
                if (data.kembali_sj != null) {
                    $('#kembali_sj').val(new Date(data.kembali_sj).toLocaleString("id-ID", newDateOptions).split(' ')[0]).prop('readonly', true)
                }
                if (data.kembali_rev != null) {
                    $('#kembali_rev').val(new Date(data.kembali_rev).toLocaleString("id-ID", newDateOptions).split(' ')[0]).prop('readonly', true)
                }
                $('#car_id').val(data.car_id).trigger('change').attr("disabled", true);
                $('#type').val(data.type).trigger('change').attr("disabled", true);
                $('#booking_month').val(data.booking_month).trigger('change').attr("disabled", true);
                $('#booking_year').val(data.booking_year).trigger('change').attr("disabled", true);
                $('#driver_id').val(data.driver_id).trigger('change').attr("disabled", true);
                $('#revisi').val(data.revisi);
                $('#plan_delivery').val(data.plan_delivery);
                $('#status').val(data.status).trigger('change');


                id = $('#id').val();
                $('.modal-title').text('Update Data');
                $("#in").removeClass("btn btn-primary add");
                $("#in").addClass("btn btn-primary update");
                $('#in').text('Update');
                $('#myModal').modal('show');

            },
        });

    });
    //end edit
    //update
    $('.modal-footer').on('click', '.update', function() {
        $("#pageloader").fadeIn();
        var form = document.getElementById("form-add");
        var fd = new FormData(form);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: 'update_sj/' + id,
            data: fd,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data[1]) {
                    let text = "";
                    var dataa = Object.assign({}, data[0])
                    for (let x in dataa) {
                        text += "<div class='alert alert-dismissible hide fade in alert-danger show'><strong>Errorr!</strong> " + dataa[x] + "<a href='#' class='close float-close' data-dismiss='alert' aria-label='close'>×</a></div>";
                    }
                    $('#peringatan').append(text);
                } else {
                    $('#myModal').modal('hide');
                    reset_form();
                    // $('#example1').DataTable().ajax.reload();
                    location.reload();
                }
            }
        });
    });
    //end update
    //delete
    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        if (confirm('Yakin akan menghapus data ini?')) {
            // alert("Thank you for subscribing!" + $(this).data('id') );

            $.ajax({
                type: 'DELETE',
                url: 'delete_sj/' + $(this).data('id'),
                data: {
                    '_token': "{{ csrf_token() }}",
                },
                success: function(data) {
                    alert("Data Berhasil Dihapus");
                    // $('#example1').DataTable().ajax.reload();
                    location.reload();
                }
            });

        } else {
            return false;
        }
    });
    //tracking
    $(document).on('click', '#tracking', function(e) {
        e.preventDefault();
        var uid = $(this).data('id');
        var newDateOptions = {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
        }
        $.ajax({
            type: 'POST',
            url: 'tracking',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': uid,
            },
            success: function(data) {
                //console.log(data.detail_s_j.length);
                $("#tracking-data").empty();
                $.each(data, function(i) {
                    $('#tracking-data').append(
                        '<tr class="active">' +
                        '<td class="track_dot">' +
                        '<span class="track_line"></span></td>' +
                        '<td>' + data[i].tracking + '</td>' +
                        '<td>' + data[i].user.name + '</td>>' +
                        '<td>' +
                        new Date(data[i].created_at).toLocaleString("id-ID", newDateOptions) +
                        '</td></tr>'
                    );
                })
                $('#trackingmodal').modal('show');

            },
        });

    });
    //print
    $(document).on('click', '#print', function(e) {
        e.preventDefault();
        var uid = $(this).data('id');
        $('#id_print').val(uid);
        $('#printmodal').modal('show');
    });
    $(document).on('click', '#subpr', function() {
        $('#printmodal').modal('hide');
    });
    //printmodal
    //search part
    $(document).ready(function() {
        // $('#in2,#in3,#in4').hide();
        // Set option selected onchange
        $('#cust_id').change(function() {
            var value = $(this).val();
            // console.log(value);
            $.ajax({
                type: 'POST',
                url: 'search_part',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'cust_id': $(this).val(),

                },
                success: function(data) {
                    $('[name="part_id[]"]').empty();
                    $('[name="part_id[]"]').append('<option value="">Choose...</option>');
                    $.each(data, function(i) {
                        $('[name="part_id[]"]').append('<option value="' + data[i].id + '">' + data[i].name_local + '</option>');
                    })

                },
            });

        });
        $('#cust_id').change(function() {
            var value = $(this).val();
            // console.log(value);
            $.ajax({
                type: 'POST',
                url: 'search_order',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'cust_id': $(this).val(),
                    'status': "CLOSE",

                },
                success: function(data) {
                    $('[name="order_id"]').empty();
                    $('[name="order_id"]').append('<option value="-">Choose...</option>');
                    $.each(data, function(i) {
                        $('[name="order_id"]').append('<option value="' + data[i].id + '">' + data[i].no_po + '</option>');
                    })

                },
            });

            $.ajax({
                type: 'POST',
                url: 'search_invoice',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'cust_id': $(this).val(),

                },
                success: function(data) {
                    $('[name="invoice_id"]').empty();
                    $('[name="invoice_id"]').append('<option value="-">Choose...</option>');
                    $.each(data, function(i) {
                        $('[name="invoice_id"]').append('<option value="' + data[i].id + '">' + data[i].no_invoice + '</option>');
                    })

                },
            });

        });

        // Set option selected onchange
        $('#qty0,#qty1,#qty2,#qty3,#qty4,#qty5,#qty6,#qty7,#qty8,#qty9').change(function(event) {
            var matches = $(this).attr('id').match(/(\d+)/);
            var qty = $(this).val();
            //console.log(matches[0]);
            $.ajax({
                type: 'POST',
                url: 'search_price',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': $('#part_id' + matches[0]).val(),

                },
                success: function(data) {
                    // $('#total_price' + matches[0]).val(data);
                    AutoNumeric.getAutoNumericElement('#price' + matches[0]).set(data);
                    AutoNumeric.getAutoNumericElement('#total_price' + matches[0]).set(data * qty.replace(",", ""));
                    findTotal(matches[0]);
                },
            });
        });
        //delete part
        $('#del_part0,#del_part1,#del_part2,#del_part3,#del_part4,#del_part5,#del_part6,#del_part7,#del_part8,#del_part9').click(function(event) {
            var matches = $(this).attr('id').match(/(\d+)/);
            //console.log(matches[0]);
            $.ajax({
                type: 'DELETE',
                url: 'del_part/' + $('#detail_id' + matches[0]).val(),
                data: {
                    '_token': "{{ csrf_token() }}",
                },
                success: function(data) {
                    $('#myModal').modal('hide');
                    reset_form();
                    $('#example1').DataTable().ajax.reload()
                    alert("Data Berhasil Dihapus");
                    // $("#tr" + (--matches[0])).hide();
                    // $('#part_id' + matches[0]).val(null).trigger('change.select2');
                    // $('#type_pack' + matches[0]).val(null).trigger('change.select2');
                    // $('#qty' + matches[0]).val("");
                    // $('#qty_pack' + matches[0]).val("");
                    // $('#total_price' + matches[0]).val("");
                    //AutoNumeric.getAutoNumericElement('#total_price' + matches[0]).set(data);
                },
            });
        });

        $('#part_id0,#part_id1,#part_id2,#part_id3,#part_id4,#part_id5,#part_id6,#part_id7,#part_id8,#part_id9').change(function(event) {
            var matches = $(this).attr('id').match(/(\d+)/);
            var part = $(this).val();
            var po = $('#order_id').val();

            //console.log(matches[0]);
            $.ajax({
                type: 'POST',
                url: 'search_progress_po',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'po_id': po,
                    'part_id': part

                },
                success: function(data) {
                    if (data != "false") {
                        $('#part_po').val(data.part);
                        $('#qty_po').val(data.total - data.qty);
                        new AutoNumeric('#qty_po', {
                            decimalPlaces: "0",
                        });
                    } else {
                        $('#part_po').val();
                        $('#qty_po').val();
                    }
                },
            });
        });
    });
</script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('[name = "invoice_id"],[name="part_id[]"],[name="type[]"],[name="type_pack[]"],#cust_id,#order_id,#driver_id,#car_id,#booking_month,#booking_year').select2({
            theme: 'bootstrap4'
        })
        //Date picker
        $('#reservationdate,#reservationrev,#reservationsj,#reservationdate1').datetimepicker({
            format: 'DD/MM/YYYY'

        });

        //AutoNumeric.multiple('.autonumeric-integer', AutoNumeric.getPredefinedOptions().integerPos);
    })

    function findTotal(id) {
        //var arr = document.getElementsByName('total_price[]');
        var table = document.getElementById('roww');
        var rowCount = table.rows.length;
        //console.log(rowCount);
        var tot = 0;
        for (var i = 0; i < rowCount; i++) {
            if (parseInt($('#total_price' + i).val())) {
                var total_p = $('#total_price' + i).val().replaceAll(",", "");
                //console.log(total_p);
                tot += parseInt(total_p);
            }
        }
        //document.getElementById('grand_total').value = tot;
        $('#grand_total').val(tot);
        new AutoNumeric('#grand_total', {
            decimalPlaces: "0",
        });
    }

    function reset_form() {
        $('#form-add select').val(null).trigger('change.select2').attr("disabled", false);
        $('#form-add input').removeAttr('value');
        document.getElementById("form-add").reset();
        $('.datetimepicker-input').val(null).prop('readonly', false);
        $('#user_id').val('{{ Auth::user()->name }}');
        location.reload();
    };
</script>

@endsection