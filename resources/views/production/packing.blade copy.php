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
                                        <th>Date Transaction</th>
                                        <th>Time End</th>
                                        <th>Customer</th>
                                        <th>Part Name</th>
                                        <th>Qty In</th>
                                        <th>Qty Out</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Date Transaction</th>
                                        <th>Time End</th>
                                        <th>Customer</th>
                                        <th>Part Name</th>
                                        <th>Qty In</th>
                                        <th>Qty Out</th>
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
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reset_form()">&times;</button>
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
                                                    <th style="width: 12%">Customer</th>
                                                    <th style="width: 35%;">Part Name</th>
                                                    <th style="width: 10%">Qty In</th>
                                                    <th style="width: 10%">Qty Out</th>
                                                    <th style="width: 10%">Total NG</th>
                                                    <th style="width: 18%">Type NG</th>
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
                                                        <input class="form-control autonumeric-integer" type="text" name="qty_in[]" id="qty_in0" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty_out[]" id="qty_out0" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_ng[]" id="total_ng0" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="type_ng[]" id="type_ng0" class="span15">
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
                                                        <input class="form-control autonumeric-integer" type="text" name="qty_in[]" id="qty_in1" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty_out[]" id="qty_out1" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_ng[]" id="total_ng1" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="type_ng[]" id="type_ng1" class="span15">
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
                                                        <input class="form-control autonumeric-integer" type="text" name="qty_in[]" id="qty_in2" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty_out[]" id="qty_out2" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_ng[]" id="total_ng2" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="type_ng[]" id="type_ng2" class="span15">
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
                                                        <input class="form-control autonumeric-integer" type="text" name="qty_in[]" id="qty_in3" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty_out[]" id="qty_out3" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_ng[]" id="total_ng3" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="type_ng[]" id="type_ng3" class="span15">
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
                                                        <input class="form-control autonumeric-integer" type="text" name="qty_in[]" id="qty_in4" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="qty_out[]" id="qty_out4" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_ng[]" id="total_ng4" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="type_ng[]" id="type_ng4" class="span15">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <div class="col-md-3">
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
                            <div class="col-md-3">
                                <div class="control-group">
                                    <label class="control-label">Time End</label>
                                    <div class="input-group date" id="reservationtimeend" data-target-input="nearest">
                                        <input type="text" name="time_end" id="time_end" class="form-control datetimepicker-input" data-target="#reservationtimeend" />
                                        <div class="input-group-append" data-target="#reservationtimeend" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="control-group">
                                    <label class="control-label">Operator Raking</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" id="operator" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="control-group">
                                    <label class="control-label">Operator Packing</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="operator" id="operator_packing" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="reset_form()">Close</button>
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
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8], // table ke 1
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
            "buttons": [{
                    extend: "colvis",
                    text: '<i class="fas fa-border-all"></i>'
                },
                "filter"

            ],
            ajax: {
                url: '{{ url("json_packing") }}',
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
                    data: 'detail_transaction.transaction.date_transaction',
                    name: 'detail_transaction.transaction.date_transaction'
                },
                {
                    data: 'detail_transaction.transaction.time_end',
                    name: 'detail_transaction.transaction.time_end'
                },
                {
                    data: 'detail_transaction.part.customer.code',
                    name: 'detail_transaction.part.customer.code'
                },
                {
                    data: 'detail_transaction.part.name_local',
                    name: 'detail_transaction.part.name_local'
                },
                {
                    data: 'detail_transaction.qty_in',
                    name: 'detail_transaction.qty_in'
                },
                {
                    data: 'qty_out',
                    name: 'qty_out'
                },
                {
                    data: 'detail_transaction.transaction.status',
                    name: 'detail_transaction.transaction.status'
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
    //edit data
    $(document).on('click', '#edit', function(e) {
        e.preventDefault();
        var uid = $(this).data('id');
        var newDateOptions = {
            year: "numeric",
            month: "2-digit",
            day: "2-digit"
        }
        var newDateOptionall = {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
            hour: "numeric",
            minute: "numeric",
            second: "numeric"
        }

        $.ajax({
            type: 'POST',
            url: 'edit_packing',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': uid,
            },
            success: function(data) {
                //console.log(data.detail_part_in[0].part_id);

                //isi form
                //reset_form();
                $('#id').val(data.id);
                $('#date_transaction').val(new Date(data.date_transaction).toLocaleString("id-ID", newDateOptions)
                    .split(' ')[0]).attr("disabled", true);
                $('#no_rak').val(data.no_rak).attr("disabled", true);
                $('#no_transaction').val(data.no_transaction);
                setTimeout(function() {
                    for (let i = 0; i < data.detail_transaction.length; i++) {
                        $('#cust_id' + i).val(data.detail_transaction[i].cust_id).trigger(
                            'change').attr("disabled", true);
                    }
                }, 1000);
                setTimeout(function() {
                    for (let m = 0; m < data.detail_transaction.length; m++) {
                        $('#part_id' + m).val(data.detail_transaction[m].part_id).trigger(
                            'change').attr("disabled", true);
                        $('#detail_id' + m).val(data.detail_transaction[m].id);
                        $('#qty_in' + m).val(data.detail_transaction[m].qty_in).attr("disabled", true);
                        $('#qty_out' + m).val(data.detail_transaction[m].packing['qty_out']);
                        $('#total_ng' + m).val(data.detail_transaction[m].packing['total_ng']);
                        $('#type_ng' + m).val(data.detail_transaction[m].packing['type_ng']);
                    }
                }, 2000);
                $("#tr2,#tr3,#tr4,#tr5").hide();
                for (let n = 1; n <= data.detail_transaction.length; n++) {
                    $("#tr" + n).show().attr("disabled", false);
                }
                $('#user_id').val(data.user.name);
                $('#time_start').val(new Date(data.time_start).toLocaleString("id-ID", newDateOptionall)).attr("disabled", true);
                if (data.time_end !== null) {
                    $('#time_end').val(new Date(data.time_end).toLocaleString("id-ID", newDateOptionall));
                }
                $('#operator').val(data.operator).attr("disabled", true);
                $('#operator_packing').val(data.detail_transaction[0].packing['operator']);
                $('#status').val(data.status).trigger('change');

                id = data.detail_transaction[0].transaction_id;

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
            url: 'update_packing/' + id,
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
        $('#reservationtime,#reservationtimeend').datetimepicker({
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
        location.reload();
    };
</script>
@endsection