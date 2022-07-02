@extends('index')


@section('konten')
<style>
    .modal-xl {
        max-width: 1500px;
    }
</style>
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
                                        <th>Date Transaction</th>
                                        <th>Time Start</th>
                                        <th>Customer</th>
                                        <th>Part Name</th>
                                        <th>Qty In</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Date Transaction</th>
                                        <th>Time Start</th>
                                        <th>Customer</th>
                                        <th>Part Name</th>
                                        <th>Qty In</th>
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
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reset_form();location.reload()">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Data</h4>
                </div>
                <div class="modal-body">
                    <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                        @csrf
                        <span id="peringatan"></span>
                        <input class="form-control" type="text" name="id" id="id" hidden>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label>Date</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="date_transaction" id="date_transaction" class="form-control datetimepicker-input" data-target="#reservationdate" />
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">No Transaction</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="no_transaction" id="no_transaction" class="span15" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">No Rak</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="no_rak" id="no_rak" placeholder="Type something here..." class="span15">
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
                                                    <th style="width: 10%">Customer</th>
                                                    <th style="width: 30%">Part Name</th>
                                                    <th style="width: 10%">Type</th>
                                                    <th style="width: 10%">Qty In</th>
                                                    <th style="width: 10%">Price</th>
                                                    <th style="width: 8%">SA</th>
                                                    <th style="width: 17%">Total Price</th>
                                                </tr>
                                            </thead>
                                            <tbody id="roww">
                                                <tr id="tr1">
                                                    <td>1.</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id0" readonly hidden>
                                                        <select name="cust_id[]" id="cust_id0" class="form-control select2">
                                                            <option value="">Choose...</option>
                                                            @foreach ($customer as $customer0)
                                                            <option value="{{ $customer0->id }}">{{ $customer0->code }}</option>
                                                            @endforeach
                                                        </select>

                                                    </td>
                                                    <td>
                                                        <select name="part_id[]" id="part_id0" class="form-control select2" style="width: 100%;">
                                                            <option value="">Choose...</option>
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
                                                        <input class="form-control autonumeric-integer" type="text" name="qty_in[]" id="qty_in0" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price0" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="sa[]" id="sa0" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price0" readonly class="span15">
                                                    </td>
                                                </tr>
                                                <tr id="tr2">
                                                    <td>2.</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id1" readonly hidden>
                                                        <select name="cust_id[]" id="cust_id1" class="form-control select2">
                                                            <option value="">Choose...</option>
                                                            @foreach ($customer as $customer1)
                                                            <option value="{{ $customer1->id }}">{{ $customer1->code }}</option>
                                                            @endforeach
                                                        </select>

                                                    </td>
                                                    <td>
                                                        <select name="part_id[]" id="part_id1" class="form-control select2" style="width: 100%;">
                                                            <option value="">Choose...</option>
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
                                                        <input class="form-control autonumeric-integer" type="text" name="qty_in[]" id="qty_in1" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price1" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="sa[]" id="sa1" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price1" readonly class="span15">
                                                    </td>
                                                </tr>
                                                <tr id="tr3">
                                                    <td>3.</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id2" readonly hidden>
                                                        <select name="cust_id[]" id="cust_id2" class="form-control select2">
                                                            <option value="">Choose...</option>
                                                            @foreach ($customer as $customer2)
                                                            <option value="{{ $customer2->id }}">{{ $customer2->code }}</option>
                                                            @endforeach
                                                        </select>

                                                    </td>
                                                    <td>
                                                        <select name="part_id[]" id="part_id2" class="form-control select2" style="width: 100%;">
                                                            <option value="">Choose...</option>
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
                                                        <input class="form-control autonumeric-integer" type="text" name="qty_in[]" id="qty_in2" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price2" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="sa[]" id="sa2" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price2" readonly class="span15">
                                                    </td>
                                                </tr>
                                                <tr id="tr4">
                                                    <td>4.</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id3" readonly hidden>
                                                        <select name="cust_id[]" id="cust_id3" class="form-control select2">
                                                            <option value="">Choose...</option>
                                                            @foreach ($customer as $customer3)
                                                            <option value="{{ $customer3->id }}">{{ $customer3->code }}</option>
                                                            @endforeach
                                                        </select>

                                                    </td>
                                                    <td>
                                                        <select name="part_id[]" id="part_id3" class="form-control select2" style="width: 100%;">
                                                            <option value="">Choose...</option>
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
                                                        <input class="form-control autonumeric-integer" type="text" name="qty_in[]" id="qty_in3" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price3" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="sa[]" id="sa3" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price3" readonly class="span15">
                                                    </td>
                                                </tr>
                                                <tr id="tr5">
                                                    <td>5.</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id[]" id="detail_id4" readonly hidden>
                                                        <select name="cust_id[]" id="cust_id4" class="form-control select2">
                                                            <option value="">Choose...</option>
                                                            @foreach ($customer as $customer4)
                                                            <option value="{{ $customer4->id }}">{{ $customer4->code }}</option>
                                                            @endforeach
                                                        </select>

                                                    </td>
                                                    <td>
                                                        <select name="part_id[]" id="part_id4" class="form-control select2" style="width: 100%;">
                                                            <option value="">Choose...</option>
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
                                                        <input class="form-control autonumeric-integer" type="text" name="qty_in[]" id="qty_in4" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="price[]" id="price4" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="sa[]" id="sa4" readonly class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_price[]" id="total_price4" readonly class="span15">
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot id="addfoot">
                                                <tr>
                                                    <td colspan="6">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="total_sa" id="total_sa" type="text" readonly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="grand_total" id="grand_total" type="text" readonly>
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
                                    <label class="control-label">Time Start</label>
                                    <div class="input-group date" id="reservationtime" data-target-input="nearest">
                                        <input type="text" name="time_start" id="time_start" class="form-control datetimepicker-input" data-target="#reservationtime" />
                                        <div class="input-group-append" data-target="#reservationtime" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">Operator</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="operator" id="operator" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">Status</label>
                                    <div class="controls">
                                        <select name="status" id="status" class="form-control select2">
                                            <option value="" selected="selected">Choose...</option>
                                            <option value="OPEN">OPEN</option>
                                            <option value="CLOSE">CLOSE</option>
                                        </select>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="reset_form();location.reload()">Close</button>
                    <button id="in" type="button" class="btn btn-primary">Save changes</button>
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
            text: 'Add Prosess',
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
                $("#tr2,#tr3,#tr4,#tr5").hide();
                reset_form();
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
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7], // table ke 1
                },
                {
                    targets: [1],
                    render: function(oTable) {
                        return moment(oTable).format('DD-MM-YYYY');
                    }
                },
                {
                    targets: [2],
                    render: function(oTable) {
                        return moment(oTable).format('DD-MM-YYYY HH:mm');
                    }
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
                url: '{{ url("json_transaction") }}',
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
                    data: 'transaction.date_transaction',
                    name: 'transaction.date_transaction'
                },
                {
                    data: 'transaction.time_start',
                    name: 'transaction.time_start'
                },
                {
                    data: 'part.customer.code',
                    name: 'part.customer.code'
                },
                {
                    data: 'part.name_local',
                    name: 'part.name_local'
                },
                {
                    data: 'qty_in',
                    name: 'qty_in'
                },
                {
                    data: 'transaction.status',
                    name: 'transaction.status'
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
        $("#tr2,#tr3,#tr4,#tr5").hide();
        $('#add-tab').show();
        var rtab = 1;
        $('#add-tab').click(function() {
            rtab++;
            $("#tr" + rtab).show();
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
            url: '{{ url("store_transaction") }}',
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
            url: 'edit_transaction',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': uid,
            },
            success: function(data) {
                //console.log(data.detail_part_in[0].part_id);

                //isi form
                reset_form();
                $('#id').val(data.id);
                $('#date_transaction').val(new Date(data.date_transaction).toLocaleString("id-ID", newDateOptions)
                    .split(' ')[0]);
                $('#no_rak').val(data.no_rak);
                $('#no_transaction').val(data.no_transaction);
                setTimeout(function() {
                    for (let i = 0; i < data.detail_transaction.length; i++) {
                        $('#cust_id' + i).val(data.detail_transaction[i].cust_id).trigger(
                            'change');
                    }
                }, 1000);
                setTimeout(function() {
                    for (let m = 0; m < data.detail_transaction.length; m++) {
                        AutoNumeric.getAutoNumericElement('#total_price' + [m]).set(data
                            .detail_transaction[m].price);
                        AutoNumeric.getAutoNumericElement('#price' + [m]).set(data
                            .detail_transaction[m].price / data.detail_transaction[m].qty_in);
                        $('#part_id' + m).val(data.detail_transaction[m].part_id).trigger(
                            'change');
                        $('#type' + m).val(data.detail_transaction[m].type).trigger(
                            'change');
                        $('#detail_id' + m).val(data.detail_transaction[m].id);
                        $('#qty_in' + m).val(data.detail_transaction[m].qty_in).trigger('change');
                        $('#sa' + m).val(data.detail_transaction[m].sa).trigger('change');
                    }
                }, 2000);
                $("#tr2,#tr3,#tr4,#tr5").hide();
                for (let n = 1; n <= data.detail_transaction.length; n++) {
                    $("#tr" + n).show().attr("disabled", false);
                }
                $('#user_id').val(data.user.name);
                $('#no_part_in').val(data.no_part_in);
                $('#date_in').val(new Date(data.date_in).toLocaleString("id-ID", newDateOptions)
                    .split(' ')[0]);
                $('#time_start').val(data.time_start);
                $('#operator').val(data.operator);
                $('#status').val(data.status).trigger('change');

                id = $('#id').val();

                $('.modal-title').text('Edit Data');
                $("#in").removeClass("btn btn-primary add");
                $("#in").addClass("btn btn-primary update");
                $('#in').text('Update');
                $('#add-tab').hide();
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
            url: 'update_transaction/' + id,
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
                url: 'delete_transaction/' + $(this).data('id'),
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
        //part
        $('#cust_id0,#cust_id1,#cust_id2,#cust_id3,#cust_id4,#cust_id5').change(function(event) {
            var matches = $(this).attr('id').match(/(\d+)/);
            var cust = $(this).val();

            $.ajax({
                type: 'POST',
                url: 'search_part',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'cust_id': cust,

                },
                success: function(data) {
                    $('#part_id' + matches[0]).empty();
                    $('#part_id' + matches[0]).append('<option value="">Choose...</option>');
                    $.each(data, function(i) {
                        $('#part_id' + matches[0]).append('<option value="' + data[i]
                            .id + '">' + data[i].name_local + '</option>');
                    })

                },
            });
        });

        $('#qty_in0,#qty_in1,#qty_in2,#qty_in3,#qty_in4,#qty_in5').change(function(event) {
            var matches = $(this).attr('id').match(/(\d+)/);
            var qty = $(this).val();
            var price = $("#price" + matches[0]).val();
            var total_price = $('#total_price' + matches[0]).val();
            // console.log(parseInt(qty));
            // console.log(price.replaceAll(",", ""));
            $.ajax({
                type: 'POST',
                url: 'search_prices',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': $('#part_id' + matches[0]).val(),
                    'qty': qty,

                },
                success: function(data) {
                    AutoNumeric.getAutoNumericElement('#sa' + matches[0]).set(
                        qty.replaceAll(",", "") * data.sa_dm);
                    if (total_price === "" || total_price == 0 || price != data.price) {
                        AutoNumeric.getAutoNumericElement('#price' + matches[0]).set(data.price);
                        AutoNumeric.getAutoNumericElement('#total_price' + matches[0]).set(
                            qty.replaceAll(",", "") * data.price);
                    } else if (price.replaceAll(",", "") == data.price) {
                        AutoNumeric.getAutoNumericElement('#total_price' + matches[0]).set(
                            qty.replaceAll(",", "") * data.price);
                    }
                    findTotal();
                },
            });
        });
    });
</script>
<script>
    function findTotal() {
        //var arr = document.getElementsByName('total_price[]');
        var table = document.getElementById('roww');
        var rowCount = table.rows.length;
        //console.log(rowCount);
        var tot = 0;
        var sa = 0;
        for (var i = 0; i < rowCount; i++) {
            if (parseInt($('#total_price' + i).val())) {
                var total_p = $('#total_price' + i).val().replaceAll(",", "");
                var total_sa = $('#sa' + i).val().replaceAll(",", "")
                sa += parseInt(total_sa);
                tot += parseInt(total_p);
            };
        }
        //AutoNumeric.getAutoNumericElement('#grand_total').set(tot);
        //console.log(tot);
        $('#grand_total').val(tot);
        $('#total_sa').val(sa);
        new AutoNumeric('#grand_total', {
            decimalPlaces: "0",
        });
    }
    $(function() {
        //Initialize Select2 Elements
        $('[name="part_id[]"],[name="type[]"],[name="cust_id[]"],#order_id').select2({
            placeholder: "Choose..",
            theme: 'bootstrap4'
        })
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'DD/MM/YYYY',
        });
        //time picker
        $('#reservationtime').datetimepicker({
            pickDate: false,
            minuteStepping: 30,
            format: 'DD/MM/YYYY HH:mm',
            pickTime: true,
            locale: 'id',
            use24hours: true
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