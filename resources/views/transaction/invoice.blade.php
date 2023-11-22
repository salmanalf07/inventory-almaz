@extends('index')


@section('konten')
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #007bff;
        border-color: #007bff;
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
                                        <th>Customer</th>
                                        <th>Customer Name</th>
                                        <th>Date Invoice</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>No PO</th>
                                        <th>No Invoice</th>
                                        <th>Faktur Pajak</th>
                                        <th>Date Faktur</th>
                                        <th>Harga Jual</th>
                                        <th>PPN</th>
                                        <th>PPH 23</th>
                                        <th>TOP</th>
                                        <th>Total Price</th>
                                        <th>Due Date</th>
                                        <th>Payment Date</th>
                                        <th>status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Customer</th>
                                        <th>Customer Name</th>
                                        <th>Date Invoice</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>No PO</th>
                                        <th>No Invoice</th>
                                        <th>Faktur Pajak</th>
                                        <th>Date Faktur</th>
                                        <th>Harga Jual</th>
                                        <th>PPN</th>
                                        <th>PPH 23</th>
                                        <th>TOP</th>
                                        <th>Total Price</th>
                                        <th>Due Date</th>
                                        <th>Payment Date</th>
                                        <th>status</th>
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
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reset_form('reload')">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Data</h4>
                </div>
                <div class="modal-body">
                    <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                        <span id="peringatan"></span>
                        <input class="form-control" type="text" name="id" id="id" hidden>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label>Date Invoice</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="date_inv" id="date_inv" class="form-control datetimepicker-input" data-target="#reservationdate" />
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">No Invoice</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="no_invoice" id="no_invoice" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">No Faktur</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="no_faktur" id="no_faktur" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
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
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">No PO</label>
                                    <div class="controls">
                                        <select name="order_id" id="order_id" class="form-control select2">
                                            <option value="" selected="selected">Choose...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="control-group">
                                    <label class="control-label">Delivery Month</label>
                                    <div class="controls">
                                        <select name="book_month" id="book_month" class="form-control select2" style="width: 100%;">
                                            <option value="" selected="selected">Choose...</option>
                                            <option value="1">JANUARI</option>
                                            <option value="2">FABRUARI</option>
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
                            <div class="col-md-3">
                                <div class="control-group">
                                    <label class="control-label">Delivery Year</label>
                                    <div class="controls">
                                        <select name="book_year" id="book_year" class="form-control select2" style="width: 100%;">
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
                            <div class="col-md-12" id="SJJ">
                                <label class="control-label">SJ</label>
                                <div class="controls">
                                    <select class="form-control multi-sjj" name="updSJJ[]" multiple="multiple">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">Part Name</label>
                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <table class="table table-striped" id="dynamicAddRemove">
                                            <thead>
                                                <tr>
                                                    <th style="width: 40%">Part Name</th>
                                                    <th style="width: 15%">Qty</th>
                                                    <th style="width: 20%">Price</th>
                                                    <th style="width: 25%">Total Price</th>
                                                </tr>
                                            </thead>
                                            <tbody id="roww">
                                                <tr>
                                                    <td id="col0">
                                                        <select name="part_id[]" id="part_id0" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td id="col1">
                                                        <input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty0" onchange="search_price(this)" class="span15">
                                                    </td>
                                                    <td id="col2">
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price0" readonly class="span15">
                                                    </td>
                                                    <td id="col3">
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price0" readonly class="span15">
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>
                                                        <button type="button" name="add-tab" onclick="addRows()" class="btn btn-secondary">Add Row</button>
                                                        <button type="button" name="add-tab" onclick="deleteRows()" class="btn btn-secondary">Delete Row</button>
                                                    </td>
                                                    <td colspan="2">
                                                        <p style="text-align: right;">Grand Total</p>
                                                    </td>
                                                    <td colspan="1">
                                                        <input class="form-control autonumeric-integer" name="grand_total" id="grand_total" type="text" readonly>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label" id="ppn_id">PPN {{$pajak->ppn}}%</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="ppn" id="ppn" placeholder="Type something here..." class="span15" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label" id="pph_id">PPH 23 ({{$pajak->pph}}%)</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="pph" id="pph" placeholder="Type something here..." class="span15" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">Total Harga</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="total_harga" id="total_harga" placeholder="Type something here..." class="span15" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label>Date Tukar Faktur</label>
                                    <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                                        <input type="text" name="tukar_faktur" id="tukar_faktur" class="form-control datetimepicker-input" data-target="#reservationdate1" />
                                        <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">TOP</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="top" id="top" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label>Date Jatuh Tempo</label>
                                    <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                                        <input type="text" name="jatuh_tempo" id="jatuh_tempo" class="form-control datetimepicker-input" data-target="#reservationdate2" />
                                        <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label>Date Bayar</label>
                                    <div class="input-group date" id="reservationdate3" data-target-input="nearest">
                                        <input type="text" name="tanggal_bayar" id="tanggal_bayar" class="form-control datetimepicker-input" data-target=",ut" data-target="" />
                                        <div class="input-group-append" data-target="#reservationdate3" data-toggle="datetimepicker">
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
                                            <option value="CLOSE">CLOSE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="reset_form('reload');">Close</button>
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
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal print -->
    <div id="printmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none ;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-titlee" id="printLabel">Print</h4>
                </div>
                <div class="modal-body" id="modal_print">
                    <span id="peringatan"></span>
                    <div class="row" style="margin-bottom: 5px;">
                        <div class="col-md-12">
                            <div class="control-group">
                                <label>Date Cetak</label>
                                <div class="input-group date" id="dateCetak" data-target-input="nearest">
                                    <input type="text" name="date_cetak" id="date_cetak" class=" form-control datetimepicker-input" data-target="#dateCetak" />
                                    <div class="input-group-append" data-target="#dateCetak" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="control-group text-center">
                                <form method="post" role="form" id="form-print" action="tt_invoice" enctype="multipart/form-data" formtarget="_blank" target="_blank">
                                    @csrf
                                    <input class="form-control" type="text" name="id_print" id="id_print" hidden>
                                    <input class="form-control" type="text" name="cetak_date" id="cetak_date" hidden>
                                    <input id="subpr" class="btn btn-primary btn-block" type="submit" value="Tanda Terima">
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="control-group text-center">
                                <form method="post" role="form" id="form-print" action="tax_invoice" enctype="multipart/form-data" formtarget="_blank" target="_blank">
                                    @csrf
                                    <input class="form-control" type="text" name="id_print" id="id_print1" hidden>
                                    <input class="form-control" type="text" name="cetak_date" id="cetak_date1" hidden>
                                    <input id="subpr" class="btn btn-primary btn-block" type="submit" value="Invoice">
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="control-group text-center">
                                <form method="post" role="form" id="form-print" action="rekap_sj" enctype="multipart/form-data" formtarget="_blank" target="_blank">
                                    @csrf
                                    <input class="form-control" type="text" name="id_print" id="id_print2" hidden>
                                    <input class="form-control" type="text" name="cetak_date" id="cetak_date2" hidden>
                                    <input id="subpr" class="btn btn-primary btn-block" type="submit" value="Rekap Invoice">
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-body" id="modal_sj">
                    <form method="post" role="form" id="form-sj" enctype="multipart/form-data">
                        <input class="form-control" type="text" name="id_print" id="id_print3" hidden>
                        <div class="row">
                            <div class="col-md-12" id="SJ">
                                <label class="control-label">Choose SJ</label>
                                <div class="controls">
                                    <select class="form-control multi-sj" name="updSJ[]" multiple="multiple">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <buton type="button" class="btn btn-secondary" data-dismiss="modal">Close</buton>
                    <button id="upsj" type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- jQuery -->
<script src="assets/css/jquery/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/autonumeric/autoNumeric.min.js"></script>
<script>
    new AutoNumeric('[name="qty[]"]', {
        decimalPlaces: "0",
    });
</script>
<!-- <script src="/js/jquery-3.5.1.js"></script> -->
<script>
    var ppn_st, pph_st;
    $(function() {
        //open-user
        $.fn.dataTable.ext.buttons.add = {
            text: 'Add Invoice',
            action: function(e, dt, node, config) {
                $('.modal-title').text('Tambah Data');
                $('#grand_total').val(0);
                $("#in").show();
                $("#in").removeClass("btn btn-primary update");
                $("#in").addClass("btn btn-primary add");
                $('#in').text('Save');
                // reset_form();
                $('#SJJ').hide();
                //AutoNumeric.multiple('.autonumeric-integer', AutoNumeric.getPredefinedOptions().integerPos);
                $('[name="add-tab"]').show();
                $("#status").val('OPEN').trigger('change');
                $('#myModal').modal('show');
            }
        };

        var oTable = $('#example1').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Show all']
            ],
            "responsive": true,
            "autoWidth": false,
            "columnDefs": [{
                    "className": "text-center",
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14], // table ke 1
                },
                {
                    targets: [3, 9, 15, 16],
                    render: function(oTable) {
                        return moment(oTable).format('DD-MM-YYYY');
                    }
                },
                {
                    targets: [10, 11, 12, 14],
                    render: $.fn.dataTable.render.number(',', '.', 2)
                },
                {
                    orderable: false,
                    targets: 0
                },
                {
                    "visible": false,
                    "targets": [2, 6, 8, 9, 10, 11, 12, 13, 16]
                },
            ],
            order: [
                [7, 'desc']
            ],
            "buttons": ["add", "pageLength",
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]
                    }
                },
                {
                    extend: "colvis",
                    text: '<i class="fas fa-border-all"></i>'
                }

            ],
            ajax: {
                url: '{{ url("json_invoice") }}'
            },
            "fnCreatedRow": function(row, data, index) {
                $('td', row).eq(0).html(index + 1);
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'customer.code',
                    name: 'customer.code'
                },
                {
                    data: 'customer.name',
                    name: 'customer.name'
                },
                {
                    data: 'date_inv',
                    name: 'date_inv'
                },
                {
                    data: 'book_month',
                    name: 'book_month'
                },
                {
                    data: 'book_year',
                    name: 'book_year'
                },
                {
                    data: function(row) {
                        if (row.order && row.order.no_po) {
                            return row.order.no_po; // Mengembalikan nilai properti name jika ada
                        } else {
                            return ""; // Mengembalikan string kosong jika tidak ada nilai yang valid
                        }
                    },
                    name: 'order.no_po'
                },
                {
                    data: 'no_invoice',
                    name: 'no_invoice'
                },
                {
                    data: 'no_faktur',
                    name: 'no_faktur'
                },
                {
                    data: 'tukar_faktur',
                    name: 'tukar_faktur'
                },
                {
                    data: 'harga_jual',
                    name: 'harga_jual'
                },
                {
                    data: 'ppn',
                    name: 'ppn'
                },
                {
                    data: 'pph',
                    name: 'pph'
                },
                {
                    data: 'top',
                    name: 'top'
                },
                {
                    data: 'total_harga',
                    name: 'total_harga'
                },
                {
                    data: 'jatuh_tempo',
                    name: 'jatuh_tempo'
                },
                {
                    data: 'tanggal_bayar',
                    name: 'tanggal_bayar'
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
            url: '{{ url("store_invoice") }}',
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
                    // document.getElementById("form-add").reset();
                    $('#example1').DataTable().ajax.reload();
                    reset_form();
                    //location.reload();
                }

            },
        });
    });
    //end add data
    //edit data
    $(document).on('click', '#edit', function(e) {
        autonumeric("edit");
        e.preventDefault();
        var uid = $(this).data('id');
        var newDateOptions = {
            year: "numeric",
            month: "2-digit",
            day: "2-digit"
        }

        $.ajax({
            type: 'POST',
            url: 'edit_invoice',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': uid,
            },
            success: function(data) {
                //console.log(data.detail_part_in[0].part_id);

                //isi form
                let text = "";
                for (let i = 1; i < data[0].detail_invoice.length; i++) {
                    text += '<tr><td>' +
                        '<select name="part_id[]" id="part_id' + i + '" class="form-control select2" style="width: 100%;">' +
                        '<option selected="selected">Choose...</option>' +
                        '</select></td><td>' +
                        '<input class="form-control autonumeric-integer" type="text" name="qty[]" id="qty' + i + '" onchange="search_price(this)" class="span15">' +
                        '</td><td>' +
                        '<input class="form-control autonumeric-integer" type="text" name="price[]" id="price' + i + '" readonly class="span15">' +
                        '</td><td>' +
                        '<input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price' + i + '" readonly class="span15">' +
                        '</td></tr>';
                }
                $('#roww').append(text);
                $('#id').val(data[0].id);
                if (data[0].application[0]) {
                    tax = data[0].customer.ppn + ";" + data[0].customer.pph;
                    ppn_st = data[0].application[0].ppn;
                    pph_st = data[0].application[0].pph;
                    $('#ppn_id').text("PPN " + data[0].application[0].ppn + "%");
                    $('#pph_id').text("PPH 23(" + data[0].application[0].pph + "%)");
                } else {
                    tax = data[0].customer.ppn + ";" + data[0].customer.pph;
                    ppn_st = 0;
                    pph_st = 0;
                }
                $('#cust_id').val(data[0].cust_id).trigger('change');
                setTimeout(function() {
                    if (data[0].order_id) {
                        $('#order_id').val(data[0].order_id).trigger('change');
                    }
                }, 2000);
                $('#no_invoice').val(data[0].no_invoice);
                $('#no_faktur').val(data[0].no_faktur);
                $('#book_month').val(data[0].book_month).trigger('change');
                $('#book_year').val(data[0].book_year).trigger('change');
                $('#status').val(data[0].status).trigger('change');
                $('#date_inv').val(new Date(data[0].date_inv).toLocaleString("id-ID", newDateOptions).split(' ')[0]);
                if (data[0].jatuh_tempo != null) {
                    $('#jatuh_tempo').val(new Date(data[0].jatuh_tempo).toLocaleString("id-ID", newDateOptions).split(' ')[0]).prop('readonly', true);
                };
                if (data[0].top != null) {
                    $('#top').val(data[0].top);
                }
                if (data[0].tukar_faktur != null) {
                    $('#tukar_faktur').val(new Date(data[0].tukar_faktur).toLocaleString("id-ID", newDateOptions).split(' ')[0]);
                }
                if (data[0].tanggal_bayar != null) {
                    $('#tanggal_bayar').val(new Date(data[0].tanggal_bayar).toLocaleString("id-ID", newDateOptions).split(' ')[0]).prop('readonly', true);
                }
                //AutoNumeric.multiple('.autonumeric-integer', AutoNumeric.getPredefinedOptions().integerPos);
                setTimeout(function() {
                    for (let j = 0; j < data[0].detail_invoice.length; j++) {
                        $('#part_id' + j).val(data[0].detail_invoice[j].part_id).trigger('change').attr("disabled", true);
                        $('#qty' + j).val(data[0].detail_invoice[j].qty).attr("disabled", true);
                        $('#price' + [j]).val(data[0].detail_invoice[j].total_price / data[0].detail_invoice[j].qty);
                        $('#total_price' + [j]).val(data[0].detail_invoice[j].total_price);
                        autonumeric(j);
                        //$('#qty' + j).val(myArray[j].qty).trigger('change').attr("disabled", true);
                        //console.log(myArray[j]);
                    }
                    findTotal(data[0].detail_invoice.length);
                }, 2500);
                $('#SJJ').show();
                $(".multi-sjj").select2({
                    tags: true
                });
                $('[name="updSJJ[]"]').empty();
                $.each(data[1], function(i) {
                    $('[name="updSJJ[]"]').append('<option value="' + data[1][i].id + '">' + data[1][i].nosj + '</option>');
                });
                var array = Object.keys(data[2])
                    .map(function(key) {
                        return data[2][key].id;
                    });
                $('.multi-sjj').select2().val(array).trigger('change').attr("disabled", true);

                id = $('#id').val();

                $('.modal-title').text('Detail Data');
                $("#in").removeClass("btn btn-primary add");
                $("#in").addClass("btn btn-primary update");
                $('[name="add-tab"]').hide();
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
            url: 'update_invoice/' + id,
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
                url: 'delete_invoice/' + $(this).data('id'),
                data: {
                    '_token': "{{ csrf_token() }}",
                },
                success: function(data) {
                    alert("Data Berhasil Dihapus");
                    $('#example1').DataTable().ajax.reload();
                }
            });

        } else {
            return false;
        }
    });
    //print
    $(document).on('click', '#print,#updSJ', function(e) {
        reset_form();
        e.preventDefault();
        var uid = $(this).data('id');
        var updSJ = $(this).data('sj');
        if (updSJ == "updSJ") {
            $('#modal_print').hide();
            $('#modal_sj').show();
            $('#upsj').show();
            $('.modal-titlee').text('Update SJ');
            $('#id_print3').val(uid);
            $(".multi-sj").select2({
                tags: true
            });

            $.ajax({
                type: 'POST',
                url: 'edit_invoice',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': uid,
                },
                success: function(data) {
                    //no_sj
                    $('[name="updSJ[]"]').empty();
                    $.each(data[1], function(i) {
                        $('[name="updSJ[]"]').append('<option value="' + data[1][i].id + '">' + data[1][i].nosj + '-' + data[1][i].customer.code + '</option>');
                    });
                    var array = Object.keys(data[2])
                        .map(function(key) {
                            return data[2][key].id;
                        });
                    $('.multi-sj').select2().val(array).trigger('change');
                },
            });
        } else {
            //console.log(uid)
            $('#modal_print').show();
            $('#upsj').hide();
            $('#modal_sj').hide();
            $('#id_print').val(uid);
            $('#id_print1').val(uid);
            $('#id_print2').val(uid);
            $('.modal-titlee').text('Print');
        }
        $('#printmodal').modal('show');

    });
    //update SJ
    $(document).on('click', '#upsj', function() {
        var form = document.getElementById("form-sj");
        var fd = new FormData(form);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: 'update_invoice/' + $('#id_print3').val(),
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
                    $('#printmodal').modal('hide');
                    reset_form();
                    $('#example1').DataTable().ajax.reload();
                }
            }
        });
    });

    $(document).ready(function() {
        // search part
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
                    $('[name="order_id"]').append('<option value="">Choose...</option>');
                    $.each(data, function(i) {
                        $('[name="order_id"]').append('<option value="' + data[i].id + '">' + data[i].no_po + '</option>');
                    })

                },
            });

        });
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
    });


    // search detail price order
    function search_price(i) {
        //console.log(i.id);
        var matches = i.id.match(/\d+/);
        var qty = $('#qty' + matches[0]).val();
        var price = $("#price" + matches[0]).val();
        var total_price = $('#total_price' + matches[0]).val();
        //console.log($('#part_id' + matches[0]).val());
        if ($('#part_id' + matches[0]).val() !== "") {
            $.ajax({
                type: 'POST',
                url: 'search_price',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': $('#part_id' + matches[0]).val(),

                },
                success: function(data) {
                    if (total_price === "") {
                        $('#price' + matches[0]).val(data);
                        // $('#total_price' + matches[0]).val(qty.replaceAll(",", "") * data);
                        // autonumeric(matches[0]);
                        AutoNumeric.getAutoNumericElement('#total_price' + matches[0]).set(qty.replaceAll(",", "") * data);
                    } else if (price.replaceAll(",", "") == data) {
                        // $('#total_price' + matches[0]).val(qty.replaceAll(",", "") * data);
                        // autonumeric(matches[0]);
                        AutoNumeric.getAutoNumericElement('#total_price' + matches[0]).set(qty.replaceAll(",", "") * data);
                    }
                    //findTotal(matches[0]);
                },
            });
        }
    };
    $(function() {
        //Initialize Select2 Elements
        $('#cust_id,#order_id,#book_month,#book_year').select2({
            dropdownParent: $('#myModal'),
            theme: 'bootstrap4'
        })
        //Date picker
        $('#reservationdate,#reservationdate1,#reservationdate2,#reservationdate3,#dateCetak').datetimepicker({
            format: 'DD/MM/YYYY'

        });
        //AutoNumeric.multiple('.autonumeric-integer', AutoNumeric.getPredefinedOptions().integerPos);

        $('#reservationdate1').on('change.datetimepicker', function() {
            var newDateOptions = {
                year: "numeric",
                month: "2-digit",
                day: "2-digit"
            };
            if ($('#top').val() != "") {
                var datee = $('#tukar_faktur').val();
                var convert = datee.split("/").reverse().join("-");
                var date = new Date(convert);
                date.setDate(date.getDate() + parseInt($('#top').val()));
                //console.log(date);
                $("#jatuh_tempo").val(date.toLocaleString("id-ID", newDateOptions));
            }
        });

        $('#top').change(function() {
            var newDateOptions = {
                year: "numeric",
                month: "2-digit",
                day: "2-digit"
            };
            if ($('#tukar_faktur').val() != "") {
                var datee = $('#tukar_faktur').val();
                var convert = datee.split("/").reverse().join("-");
                var date = new Date(convert);
                date.setDate(date.getDate() + parseInt($('#top').val()));
                //console.log(date);
                $("#jatuh_tempo").val(date.toLocaleString("id-ID", newDateOptions));
            }
        })

        $('#dateCetak').on('change.datetimepicker', function() {
            //console.log($('#date_cetak').val());
            $('#cetak_date').val($('#date_cetak').val());
            $('#cetak_date1').val($('#date_cetak').val());
            $('#cetak_date2').val($('#date_cetak').val());
        });

    });


    function findTotal(id) {
        //var arr = document.getElementsByName('total_price[]');
        var tow = $('#grand_total').val();
        var tot = 0;
        for (var i = 0; i < id; i++) {
            if (parseFloat($('#total_price' + i).val())) {
                var total_p = $('#total_price' + i).val().replaceAll(",", "");
                tot += parseFloat(total_p);
            }

        }
        // console.log(ppn_st);
        // console.log(pph_st);
        pajak = tax.split(";");
        if (pajak[0] === "Y") {
            var ppn_val = Math.round(tot * (ppn_st / 100));
        } else {
            var ppn_val = 0;
        }

        if (pajak[1] === "Y") {
            var pph_val = Math.round(tot * (pph_st / 100));
        } else {
            var pph_val = 0;
        }

        AutoNumeric.getAutoNumericElement('#grand_total').set(tot);
        AutoNumeric.getAutoNumericElement('#ppn').set(ppn_val);
        AutoNumeric.getAutoNumericElement('#pph').set(pph_val);
        AutoNumeric.getAutoNumericElement('#total_harga').set(tot + ppn_val - pph_val);
    }

    function deleteRows() {
        var table = document.getElementById('roww');
        var rowCount = table.rows.length;
        if (rowCount >= '2') {
            var row = table.deleteRow(rowCount - 1);
            rowCount--;
        }
        // else {
        //     alert('There should be atleast one row');
        // }
    }

    function reset_form(reload) {
        $('#form-add select').val(null).trigger('change.select2').attr("disabled", false);
        $('#form-add input').removeAttr('value').attr("disabled", false);
        document.getElementById("form-add").reset();
        $('.datetimepicker-input').val(null).prop('readonly', false);
        var table = document.getElementById('roww');
        var rowCount = table.rows.length;
        for (o = 0; o <= rowCount; o++) {
            deleteRows();
        }
        if (reload) {
            location.reload();
        }
        //$('#user_id').val('{{ Auth::user()->name }}');
    };

    function autonumeric(i) {
        // inisialisasi AutoNumeric
        const mixedOptions = {
            ...AutoNumeric.getPredefinedOptions().all,
            unformatOnSubmit: true,
        };

        // tambahkan event listener untuk mengatur opsi decimalPlaces secara dinamis
        const mixedInput = document.querySelector('.autonumeric-integer');
        mixedInput.addEventListener('input', () => {
            const value = mixedInput.value;
            const decimalIndex = value.indexOf('.');

            // set opsi decimalPlaces ke null jika tidak ada angka desimal atau set opsi decimalPlaces ke 2 jika ada angka desimal
            mixedOptions.decimalPlaces = decimalIndex === -1 ? null : 2;
        });

        // terapkan AutoNumeric pada input field
        // AutoNumeric.multiple('.autonumeric-integer', mixedOptions);
        if (i == "edit") {
            new AutoNumeric('#grand_total', mixedOptions);
            new AutoNumeric('#ppn', mixedOptions);
            new AutoNumeric('#pph', mixedOptions);
            new AutoNumeric('#total_harga', mixedOptions);
        } else {
            new AutoNumeric('#price' + i, mixedOptions);
            new AutoNumeric('#total_price' + i, mixedOptions);
        }
    }
</script>

@endsection