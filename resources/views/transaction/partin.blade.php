@extends('index')


@section('konten')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $judul }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $judul }}</li>
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
                                        <th>Date In</th>
                                        <th>SJ</th>
                                        <th>Customer</th>
                                        <!-- <th>Part</th>
                                        <th>Qty</th> -->
                                        <th>Grand Total</th>
                                        <th>Data Create</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Date In</th>
                                        <th>SJ</th>
                                        <th>Customer</th>
                                        <!-- <th>Part</th>
                                        <th>Qty</th> -->
                                        <th>Grand Total</th>
                                        <th>Data Create</th>
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
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reset_form()">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Data</h4>
                </div>
                <div class="modal-body">
                    <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                        @csrf
                        <span id="peringatan"></span>
                        <input class="form-control" type="text" name="id" id="id" hidden>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label>Date</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="date_in" id="date_in" class="form-control datetimepicker-input" data-target="#reservationdate" />
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Customer</label>
                                    <div class="controls">
                                        <select name="cust_id" id="cust_id" class="form-control select2">
                                            <option selected="selected">Choose...</option>
                                            @foreach ($customer as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->code }}</option>
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
                                    <label class="control-label">No SJ Customer</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="no_sj_cust" id="no_sj_cust" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">Part Name</label>
                                <div class="card" style=" width: 15rem">
                                    <button type="button" name="add-tab" id="add-tab" class="btn btn-secondary">Add More
                                        Row</button>
                                </div>
                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <table class="table table-striped" id="dynamicAddRemove">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">#</th>
                                                    <th style="width: 40%">Part Name</th>
                                                    <th style="width: 15%;">Type</th>
                                                    <th style="width: 10%">Price</th>
                                                    <th style="width: 10%">Qty</th>
                                                    <th style="width: 20%">Total Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="tr1">
                                                    <td>1.</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id0" readonly hidden>
                                                        <select name="part_id[]" id="part_id0" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type0" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                            <option value="WIP">WIP</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="RETURN">RETURN</option>
                                                            <option value="SAMPLE">SAMPLE</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price0" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input autocomplete="off" class="form-control autonumeric-integer" type="text" name="qty[]" id="qty0" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price0" readonly class="span15">
                                                    </td>
                                                </tr>
                                                <tr id="tr2">
                                                    <td>2.</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id1" readonly hidden>
                                                        <select name="part_id[]" id="part_id1" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type1" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                            <option value="WIP">WIP</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="RETURN">RETURN</option>
                                                            <option value="SAMPLE">SAMPLE</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price1" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty1" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price1" readonly class="span15">
                                                    </td>
                                                </tr>
                                                <tr id="tr3">
                                                    <td>3.</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id2" readonly hidden>
                                                        <select name="part_id[]" id="part_id2" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type2" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                            <option value="WIP">WIP</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="RETURN">RETURN</option>
                                                            <option value="SAMPLE">SAMPLE</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price2" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty2" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price2" readonly class="span15">
                                                    </td>
                                                </tr>
                                                <tr id="tr4">
                                                    <td>4.</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id3" readonly hidden>
                                                        <select name="part_id[]" id="part_id3" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type3" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                            <option value="WIP">WIP</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="RETURN">RETURN</option>
                                                            <option value="SAMPLE">SAMPLE</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price3" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty3" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price3" readonly class="span15">
                                                    </td>
                                                </tr>
                                                <tr id="tr5">
                                                    <td>5.</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id4" readonly hidden>
                                                        <select name="part_id[]" id="part_id4" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type4" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                            <option value="WIP">WIP</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="RETURN">RETURN</option>
                                                            <option value="SAMPLE">SAMPLE</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price4" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty4" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price4" readonly class="span15">
                                                    </td>
                                                </tr>
                                                <tr id="tr6">
                                                    <td>6.</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id5" readonly hidden>
                                                        <select name="part_id[]" id="part_id5" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type5" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                            <option value="WIP">WIP</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="RETURN">RETURN</option>
                                                            <option value="SAMPLE">SAMPLE</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price5" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty5" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price5" readonly class="span15">
                                                    </td>
                                                </tr>
                                                <tr id="tr7">
                                                    <td>7.</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id6" readonly hidden>
                                                        <select name="part_id[]" id="part_id6" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type6" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                            <option value="WIP">WIP</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="RETURN">RETURN</option>
                                                            <option value="SAMPLE">SAMPLE</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price6" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty6" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price6" readonly class="span15">
                                                    </td>
                                                </tr>
                                                <tr id="tr8">
                                                    <td>8.</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id7" readonly hidden>
                                                        <select name="part_id[]" id="part_id7" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type7" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                            <option value="WIP">WIP</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="RETURN">RETURN</option>
                                                            <option value="SAMPLE">SAMPLE</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price7" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty7" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price7" readonly class="span15">
                                                    </td>
                                                </tr>
                                                <tr id="tr9">
                                                    <td>9.</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id8" readonly hidden>
                                                        <select name="part_id[]" id="part_id8" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type8" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                            <option value="WIP">WIP</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="RETURN">RETURN</option>
                                                            <option value="SAMPLE">SAMPLE</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price8" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty8" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price8" readonly class="span15">
                                                    </td>
                                                </tr>
                                                <tr id="tr10">
                                                    <td>10.</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id9" readonly hidden>
                                                        <select name="part_id[]" id="part_id9" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="type[]" id="type9" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                            <option value="WIP">WIP</option>
                                                            <option value="REPAINTING">REPAINTING</option>
                                                            <option value="RETURN">RETURN</option>
                                                            <option value="SAMPLE">SAMPLE</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price9" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty9" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price9" readonly class="span15">
                                                    </td>
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
                                    <label class="control-label">Received Condition</label>
                                    <div class="controls">
                                        <select name="check_result" id="check_result" class="form-control">
                                            <option selected="selected">Choose...</option>
                                            <option value="OK">OK</option>
                                            <option value="NG">NG</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Notes</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="notes" id="notes" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Plan Delivery</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="plan_delivery" id="plan_delivery" class="span15" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">User</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="user_id" id="user_id" value="{{ Auth::user()->name }}" readonly class="span15">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('form-add').reset();">Close</button>
                    <button id="in" type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div id="import" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none ;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-titlee" id="importLabel">Import Excel</h4>
                </div>
                <div class="modal-body">
                    <form method="post" role="form" id="form-import" enctype="multipart/form-data">
                        @csrf
                        <span id="peringatan"></span>
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="reset_form()">Close</button>
                    <button id="import" type="button" class="btn btn-primary">Save changes</button>
                </div>
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
            text: 'Add Part IN',
            action: function(e, dt, node, config) {
                var newDateOptions = {
                    year: "numeric",
                    month: "2-digit",
                    day: "2-digit"
                };
                $('.modal-title').text('Tambah Data');
                $("#in").show();
                $("#in").removeClass("btn btn-primary update");
                $("#in").addClass("btn btn-primary add");
                $('#in').text('Save');
                $("#tr2,#tr3,#tr4,#tr5,#tr6,#tr7,#tr8,#tr9,#tr10").hide();
                reset_form();
                var date = new Date();
                date.setDate(date.getDate() + 1);
                $("#plan_delivery").val(date.toLocaleString("id-ID", newDateOptions));
                $('#add-tab').show();
                rtab = 1;
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
            dom: 'Bfrtip',
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "columnDefs": [{
                    "className": "text-center",
                    "targets": [0, 1, 2, 3, 4, 5, 6], // table ke 1
                },
                {
                    targets: [1, 5],
                    render: function(oTable) {
                        return moment(oTable).format('DD-MM-YYYY');
                    }
                },
                {
                    "visible": false,
                    "targets": [5]
                },
                {
                    targets: [4],
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
                url: '{{ url("json_partin") }}',
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
                    data: 'date_in',
                    name: 'date_in'
                },
                {
                    data: 'no_sj_cust',
                    name: 'no_sj_cust'
                },
                {
                    data: 'customer.code',
                    name: 'customer.code'
                },
                // {
                //     data: 'parts.name_local',
                //     name: 'parts.name_local'
                // },
                // {
                //     data: 'qty',
                //     name: 'qty'
                // },
                {
                    data: 'count',
                    name: 'count'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
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
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
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
        var rtab = 1;
        $('#add-tab').click(function() {
            rtab++;
            $("#tr" + rtab).show();
        });
    });
    //import data
    $('.modal-footer').on('click', '#import', function() {
        var form = document.getElementById("form-import");
        var fd = new FormData(form);
        $.ajax({
            type: 'POST',
            url: '{{ url("import_partin") }}',
            data: fd,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data);
                if (data == "success!") {
                    $('#import').modal('hide');
                    document.getElementById("form-import").reset();
                    alert("Data Berhasil Diimport");
                    $('#example1').DataTable().ajax.reload();
                } else {
                    $('#import').modal('hide');
                    document.getElementById("form-import").reset();
                    alert("Data Gagal Diimport");
                }

            },
        });
    });
    //add data
    $('.modal-footer').on('click', '.add', function() {
        var form = document.getElementById("form-add");
        var fd = new FormData(form);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("store_partin") }}',
            data: fd,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data[1]) {
                    let text = "";
                    var dataa = Object.assign({}, data[0])
                    for (let x in dataa) {
                        text +=
                            "<div class='alert alert-dismissible hide fade in alert-danger show'><strong>Errorr!</strong> " +
                            dataa[x] +
                            "<a href='#' class='close float-close' data-dismiss='alert' aria-label='close'>×</a></div>";
                    }
                    $('#peringatan').append(text);
                } else {
                    $('#myModal').modal('hide');
                    reset_form();
                    //$('#example1').DataTable().ajax.reload();
                    location.reload();
                }

            },
        });
    });
    //end add data
    //edit data
    $(document).on('click', '#edit', function(e) {
        e.preventDefault();
        var uid = $(this).data('id');
        var newDateOptions = {
            year: "numeric",
            month: "2-digit",
            day: "2-digit"
        }

        $.ajax({
            type: 'POST',
            url: 'edit_partin',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': uid,
            },
            success: function(data) {
                //console.log(data.detail_part_in[0].part_id);

                //isi form
                reset_form();
                $('#id').val(data.id);
                $('#cust_id').val(data.cust_id).trigger('change');
                $('#order_id').val(data.order_id).trigger('change');
                setTimeout(function() {
                    for (let i = 0; i < data.detail_part_in.length; i++) {
                        $('#part_id' + i).val(data.detail_part_in[i].part_id).trigger(
                            'change');
                    }
                }, 2000);
                setTimeout(function() {
                    for (let m = 0; m < data.detail_part_in.length; m++) {
                        AutoNumeric.getAutoNumericElement('#total_price' + [m]).set(data
                            .detail_part_in[m].total_price);
                        AutoNumeric.getAutoNumericElement('#price' + [m]).set(data
                            .detail_part_in[m].total_price / data.detail_part_in[m].qty);
                        $('#detail_id' + m).val(data.detail_part_in[m].id);
                        $('#qty' + m).val(data.detail_part_in[m].qty).trigger('change');
                        $('#type' + m).val(data.detail_part_in[m].type).trigger('change');
                    }
                }, 2000);
                $('#add-tab').hide();
                $("#tr2,#tr3,#tr4,#tr5,#tr6,#tr7,#tr8,#tr9,#tr10").hide();
                for (let n = 1; n <= data.detail_part_in.length; n++) {
                    $("#tr" + n).show().attr("disabled", false);
                }
                $('#user_id').val(data.user.name);
                $('#no_part_in').val(data.no_part_in);
                $('#date_in').val(new Date(data.date_in).toLocaleString("id-ID", newDateOptions)
                    .split(' ')[0]);
                $('#no_sj_cust').val(data.no_sj_cust);
                $('#check_result').val(data.check_result);
                $('#plan_delivery').val(data.plan_delivery);
                $('#notes').val(data.notes);

                id = $('#id').val();

                $('.modal-title').text('Edit Data');
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
        var form = document.getElementById("form-add");
        var fd = new FormData(form);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: 'update_partin/' + id,
            data: fd,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data[1]) {
                    let text = "";
                    var dataa = Object.assign({}, data[0])
                    for (let x in dataa) {
                        text +=
                            "<div class='alert alert-dismissible hide fade in alert-danger show'><strong>Errorr!</strong> " +
                            dataa[x] +
                            "<a href='#' class='close float-close' data-dismiss='alert' aria-label='close'>×</a></div>";
                    }
                    $('#peringatan').append(text);
                } else {
                    $('#myModal').modal('hide');
                    reset_form();
                    //$('#example1').DataTable().ajax.reload();
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
                url: 'delete_partin/' + $(this).data('id'),
                data: {
                    '_token': "{{ csrf_token() }}",
                },
                success: function(data) {
                    alert("Data Berhasil Dihapus");
                    //$('#example1').DataTable().ajax.reload();
                    location.reload();
                }
            });

        } else {
            return false;
        }
    });
    $(document).ready(function() {
        // $('#in2,#in3,#in4').hide();
        // Set option selected onchange
        $('#cust_id').change(function() {
            var value = $(this).val();
            //console.log(value);
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
                        $('[name="part_id[]"]').append('<option value="' + data[i]
                            .id + '">' + data[i].name_local + '</option>');
                    })

                },
            });

        });
        $('#cust_id').change(function() {
            var value = $(this).val();
            //console.log(value);
            $.ajax({
                type: 'POST',
                url: 'search_order',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'cust_id': $(this).val(),

                },
                success: function(data) {
                    $('[name="order_id"]').empty();
                    $('[name="order_id"]').append('<option value="-">Choose...</option>');
                    $.each(data, function(i) {
                        $('[name="order_id"]').append('<option value="' + data[i]
                            .no_po + '">' + data[i].no_po + '</option>');
                    })

                },
            });

        });
        // Set option selected onchange
        $('#qty0,#qty1,#qty2,#qty3,#qty4,#qty5,#qty6,#qty7,#qty8,#qty9').change(function(event) {
            var matches = $(this).attr('id').match(/(\d+)/);
            var qty = $(this).val();
            var price = $("#price" + matches[0]).val();
            var total_price = $('#total_price' + matches[0]).val();
            // console.log(parseInt(qty));
            // console.log(price.replaceAll(",", ""));
            $.ajax({
                type: 'POST',
                url: 'search_price',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': $('#part_id' + matches[0]).val(),
                    'qty': qty,

                },
                success: function(data) {
                    if (total_price === "") {
                        AutoNumeric.getAutoNumericElement('#price' + matches[0]).set(data);
                        AutoNumeric.getAutoNumericElement('#total_price' + matches[0]).set(
                            qty.replaceAll(",", "") * data);
                    } else if (price.replaceAll(",", "") == data) {
                        AutoNumeric.getAutoNumericElement('#total_price' + matches[0]).set(
                            qty.replaceAll(",", "") * data);
                    }
                },
            });
        });
    });
</script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('[name="part_id[]"],[name="type[]"],#cust_id,#order_id').select2({
            placeholder: "Choose..",
            theme: 'bootstrap4'
        })
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'DD/MM/YYYY'

        });

        AutoNumeric.multiple('.autonumeric-integer', AutoNumeric.getPredefinedOptions().integerPos);
    })

    function reset_form() {
        $('#form-add select').val(null).trigger('change.select2').attr("disabled", false);
        $('#form-add input').removeAttr('value').attr("disabled", false);
        // $('#form-add input').val(null);
        $("#form-add").trigger('reset');
        $('.datetimepicker-input').val(null).prop('readonly', false);
        $('#user_id').val('{{ Auth::user()->name }}');
    };
</script>
@endsection