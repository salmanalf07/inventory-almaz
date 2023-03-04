@extends('index')


@section('konten')

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
                                        <th>Shift</th>
                                        <th>Time Start</th>
                                        <th>TIme End</th>
                                        <th>Output Hanger</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>Shift</th>
                                        <th>Time Start</th>
                                        <th>TIme End</th>
                                        <th>Output Hanger</th>
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
    <div id="myModal" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none ;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
                                        <input type="text" name="date_production" id="date_production" class="form-control datetimepicker-input" data-target="#reservationdate" />
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">Shift</label>
                                    <div class="controls">
                                        <select name="shift" id="shift" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">Output Actual Hanger</label>
                                    <div class="controls">
                                        <input class="form-control" type="number" name="output_act" id="output_act" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Time Start Production</label>
                                    <div class="input-group date" id="reservationtime" data-target-input="nearest">
                                        <input type="text" name="hour_actual_st" id="hour_actual_st" class="form-control datetimepicker-input" data-target="#reservationtime" />
                                        <div class="input-group-append" data-target="#reservationtime" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Time End Production</label>
                                    <div class="input-group date" id="reservationtime1" data-target-input="nearest">
                                        <input type="text" name="hour_actual_en" id="hour_actual_en" class="form-control datetimepicker-input" data-target="#reservationtime1" />
                                        <div class="input-group-append" data-target="#reservationtime1" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding-top: 10px;">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <style>
                                            .tabtab tr td {
                                                border: 1px solid #dee2e6;
                                                text-align: center;
                                                width: 6% !important;
                                            }

                                            .nopad {
                                                padding: 0px !important;
                                                width: 100%;
                                            }

                                            .nopad input {
                                                padding: 0px !important;
                                                width: 100%;
                                                text-align: center;
                                            }

                                            .bold {
                                                font-weight: bold;
                                            }
                                        </style>
                                        <table class="table table-striped tabtab">
                                            <thead>

                                                <tr>
                                                    <td colspan="16" class="bold"> Jenis NG</td>
                                                </tr>
                                                <tr>
                                                    <td>Hanger rusak</td>
                                                    <td>Tidak racking</td>
                                                    <td>Keteter</td>
                                                    <td>Tidak ada barang</td>
                                                    <td>Trouble mesin</td>
                                                    <td>Trouble chemical</td>
                                                    <td>Trouble utility</td>
                                                    <td>Trouble NG</td>
                                                    <td>Mati Lampu</td>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="hanger_rusak" id="hanger_rusak">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="tidak_racking" id="tidak_racking">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="keteter" id="keteter">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="tidak_ada_barang" id="tidak_ada_barang">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="trouble_mesin" id="trouble_mesin">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="trouble_chemical" id="trouble_chemical">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="trouble_utility" id="trouble_utility">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="trouble_ng" id="trouble_ng">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="mati_lampu" id="mati_lampu">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('form-add').reset();location.reload()">Close</button>
                    <button id="in" type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="assets/css/jquery/jquery.min.js"></script>
<script>
    $(function() {
        //open-user
        $.fn.dataTable.ext.buttons.add = {
            text: 'Add Data',
            action: function(e, dt, node, config) {
                $('.modal-title').text('Tambah Data');
                $("#in").removeClass("btn btn-primary update");
                $("#in").addClass("btn btn-primary add");
                $('#in').text('Save');
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
            "buttons": ["add",
                {
                    extend: 'colvis',
                    text: '<i class="fas fa-border-all"></i>'
                },
                "filter"
            ],
            "columnDefs": [{
                    "className": "text-center",
                    "targets": [0, 1, 2, 3, 4, 5], // table ke 1
                },
                {
                    targets: [1],
                    render: function(oTable) {
                        return moment(oTable).format('DD-MM-YYYY');
                    }
                },
            ],
            ajax: {
                url: '{{ url("json_production") }}',
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
                    data: 'date_production',
                    name: 'date_production'
                },
                {
                    data: 'shift',
                    name: 'shift'
                },
                {
                    data: 'hour_actual_st',
                    name: 'hour_actual_st'
                },
                {
                    data: 'hour_actual_en',
                    name: 'hour_actual_en'
                },
                {
                    data: 'output_act',
                    name: 'output_act'
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
    });
    //add data
    $('.modal-footer').on('click', '.add', function() {
        var form = document.getElementById("form-add");
        var fd = new FormData(form);
        $.ajax({
            type: 'POST',
            url: '{{ url("store_production") }}',
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
                    reset_form()
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
            url: 'edit_production',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': uid,
            },
            success: function(data) {
                //console.log(data);

                //isi form
                $('#id').val(data.id);
                $('#date_production').val(new Date(data.date_production).toLocaleString("id-ID", newDateOptions));
                $('#shift').val(data.shift).trigger('change');
                $('#hour_actual_st').val(data.hour_actual_st);
                $('#hour_actual_en').val(data.hour_actual_en);
                $('#output_act').val(data.output_act);
                $('#hanger_rusak').val(data.hanger_rusak);
                $('#tidak_racking').val(data.tidak_racking);
                $('#keteter').val(data.keteter);
                $('#tidak_ada_barang').val(data.tidak_ada_barang);
                $('#trouble_mesin').val(data.trouble_mesin);
                $('#trouble_chemical').val(data.trouble_chemical);
                $('#trouble_utility').val(data.trouble_utility);
                $('#trouble_ng').val(data.trouble_ng);
                $('#mati_lampu').val(data.mati_lampu);

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
            type: 'POST',
            url: 'update_production/' + id,
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
                    reset_form()
                }
            }
        });
    });
    //end update

    function reset_form() {
        $('#form-add select').val(null).trigger('change.select2').attr("disabled", false);
        $('#form-add input').removeAttr('value').attr("disabled", false);
        // $('#form-add input').val(null);
        $("#form-add").trigger('reset');
        location.reload();
    };

    $(function() {
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        //time picker
        $('#reservationtime,#reservationtime1').datetimepicker({
            pickDate: false,
            minuteStepping: 30,
            format: 'HH:mm',
            pickTime: true,
            locale: 'id',
            use24hours: true
        });
    })
</script>

@endsection