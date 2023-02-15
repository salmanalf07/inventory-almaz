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
                                        <th>Date Packing</th>
                                        <th>Customer</th>
                                        <th>Part Name</th>
                                        <th>OK</th>
                                        <th>NG</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Date Packing</th>
                                        <th>Customer</th>
                                        <th>Part Name</th>
                                        <th>OK</th>
                                        <th>NG</th>
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
                                        <input type="text" name="date_packing" id="date_packing" class="form-control datetimepicker-input" data-target="#reservationdate" />
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">Operator Packing</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="operator" id="operator" placeholder="Type something here..." class="span15">
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
                            <div class="col-md-12">
                                <label class="control-label">Part Name</label>
                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <table class="table table-striped" id="dynamicAddRemove">
                                            <thead>
                                                <tr>
                                                    <th style="width: 15%">Customer</th>
                                                    <th style="width: 45%;">Part Name</th>
                                                    <th style="width: 20%">Qty Out</th>
                                                    <th style="width: 20%">Total NG</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input class="form-control" type="text" name="detail_id" id="detail_id" readonly hidden>
                                                        <select name="cust_id" id="cust_id" class="form-control select2">
                                                            <option value="">Choose...</option>
                                                            @foreach ($customer as $customer)
                                                            <option value="{{ $customer->id }}">{{ $customer->code }}</option>
                                                            @endforeach
                                                        </select>

                                                    </td>
                                                    <td>
                                                        <select name="part_id" id="part_id" class="form-control select2" style="width: 100%;">
                                                            <option value="">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_fg" id="total_fg" class="span15">
                                                    </td>
                                                    <td>
                                                        <input class="form-control autonumeric-integer" type="text" name="total_ng" id="total_ng" class="span15">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->

                                </div>
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
                                                    <td title="OVER PAINT">1</td>
                                                    <td title="BINTIK / PIN HOLE">2</td>
                                                    <td title="MINYAK / MAP">3</td>
                                                    <td title="COTTON">4</td>
                                                    <td title="NO PAINT / TIPIS">5</td>
                                                    <td title="SCRATCH">6</td>
                                                    <td title="AIR POCKET">7</td>
                                                    <td title="KULIT JERUK">8</td>
                                                    <td title="KASAR">9</td>
                                                    <td title="KARAT">10</td>
                                                    <td title="WATER OVER">11</td>
                                                    <td title="MINYAK KERING">12</td>
                                                    <td title="DENTED">13</td>
                                                    <td title="KEROPOS">14</td>
                                                    <td title="NEMPEL JIG">15</td>
                                                    <td title="LAIN-LAIN">16</td>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="over_paint" id="over_paint">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="bintik_or_pin_hole" id="bintik_or_pin_hole">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="minyak_or_map" id="minyak_or_map">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="cotton" id="cotton">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="no_paint_or_tipis" id="no_paint_or_tipis">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="scratch" id="scratch">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="air_pocket" id="air_pocket">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="kulit_jeruk" id="kulit_jeruk">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="kasar" id="kasar">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="karat" id="karat">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="water_over" id="water_over">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="minyak_kering" id="minyak_kering">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="dented" id="dented">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="keropos" id="keropos">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="nempel_jig" id="nempel_jig">
                                                    </td>
                                                    <td class="nopad">
                                                        <input type="number" class="form-control" name="lainnya" id="lainnya">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.card -->
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
        $.fn.dataTable.ext.buttons.add = {
            text: 'Add Packing',
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
                    targets: [1],
                    render: function(oTable) {
                        return moment(oTable).format('DD-MM-YYYY');
                    }
                },
            ],
            "buttons": ["add", {
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
                    data: 'date_packing',
                    name: 'date_packing'
                },
                {
                    data: 'customer.code',
                    name: 'customer.code'
                },
                {
                    data: 'part.name_local',
                    name: 'part.name_local'
                },
                {
                    data: 'total_fg',
                    name: 'total_fg'
                },
                {
                    data: 'total_ng',
                    name: 'total_ng'
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
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("store_packing") }}',
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
                }

            },
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
                $('#date_packing').val(new Date(data.date_packing).toLocaleString("id-ID", newDateOptions)
                    .split(' ')[0]).attr("disabled", true);
                setTimeout(function() {
                    $('#cust_id').val(data.cust_id).trigger(
                        'change').attr("disabled", true);
                }, 1000);
                setTimeout(function() {
                    $('#part_id').val(data.part_id).trigger(
                        'change').attr("disabled", true);
                    $('#detail_id').val(data.id);
                    $('#total_ng').val(data.total_ng);
                    $('#total_fg').val(data.total_fg);
                    if (data.ng) {
                        $('#over_paint').val(data.ng.over_paint);
                        $('#bintik_or_pin_hole').val(data.ng.bintik_or_pin_hole);
                        $('#minyak_or_map').val(data.ng.minyak_or_map);
                        $('#cotton').val(data.ng.cotton);
                        $('#no_paint_or_tipis').val(data.ng.no_paint_or_tipis);
                        $('#scratch').val(data.ng.scratch);
                        $('#air_pocket').val(data.ng.air_pocket);
                        $('#kulit_jeruk').val(data.ng.kulit_jeruk);
                        $('#kasar').val(data.ng.kasar);
                        $('#karat').val(data.ng.karat);
                        $('#water_over').val(data.ng.water_over);
                        $('#minyak_kering').val(data.ng.minyak_kering);
                        $('#dented').val(data.ng.dented);
                        $('#keropos').val(data.ng.keropos);
                        $('#nempel_jig').val(data.ng.nempel_jig);
                        $('#lainnya').val(data.ng.lainnya);
                    }


                }, 1500);
                setTimeout(function() {
                    AutoNumeric.multiple('.autonumeric-integer', AutoNumeric.getPredefinedOptions().integerPos);
                }, 1500);
                $('#user_id').val(data.user.name);
                $('#operator').val(data.operator).attr("disabled", true);
                $('#status').val(data.status).trigger('change');
                if (data.status == "CLOSE") {
                    $("#form-add input").prop("disabled", true);
                }

                id = data.id;

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
    //delete

    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        if (confirm('Yakin akan menghapus data ini?')) {
            // alert("Thank you for subscribing!" + $(this).data('id') );

            $.ajax({
                type: 'DELETE',
                url: 'delete_packing/' + $(this).data('id'),
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
        $('#cust_id').change(function(event) {
            var cust = $(this).val();

            $.ajax({
                type: 'POST',
                url: 'search_part',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'cust_id': cust,

                },
                success: function(data) {
                    $('#part_id').empty();
                    $('#part_id').append('<option value="">Choose...</option>');
                    $.each(data, function(i) {
                        $('#part_id').append('<option value="' + data[i]
                            .id + '">' + data[i].name_local + '</option>');
                    })

                },
            });
        });
    });
</script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('#part_id,#cust_id').select2({
            placeholder: "Choose..",
            theme: 'bootstrap4'
        })
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'DD/MM/YYYY',
        });
        // AutoNumeric.multiple('.autonumeric-integer', AutoNumeric.getPredefinedOptions().integerPos);
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