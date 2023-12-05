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
                        <div class="card-body">
                            <form id="form-search" method="post" role="form" enctype="multipart/form-data">
                                <span id="peringatan"></span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="control-group">
                                            <label class="control-label">Month</label>
                                            <div class="controls">
                                                <select name="month_search" id="month_search" class="form-control select2" style="width: 100%;">
                                                    <option value="#" selected="selected">Choose...</option>
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
                                            <label class="control-label">Year</label>
                                            <div class="controls">
                                                <select name="year_search" id="year_search" class="form-control select2" style="width: 100%;">
                                                    <option value="#" selected="selected">Choose...</option>
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
                                    <div class="col-md-12">
                                        <div class="control-group">
                                            <div class="controls pt-2">
                                                <button id="in" type="button" class="form-control btn btn-secondary">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 id="saldoAkhir">Saldo Akhir : </h5>
                        </div>
                    </div>
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                        <th>Akun</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                        <th>Akun</th>
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
    <div id="myModal" class="modal fade bd-example-modal-xl" tabindex="-1" data-focus="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none ;">
        <div class="modal-dialog modal-xl modal-dialog-centered">
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
                        <input class="form-control" type="text" name="typeInput" id="typeInput" value="UMakan" hidden>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">Month</label>
                                    <div class="controls">
                                        <input type="hidden" name="month" id="hiddenMonth" value="">
                                        <select name="month_select" id="month" class="form-control select2" style="width: 100%;" disabled="disabled" onchange="updateHiddenField()">
                                            <option value="#" selected="selected">Choose...</option>
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
                            <div class="col-md-3">
                                <div class="control-group">
                                    <label>Date</label>
                                    <div class="input-group date" id="reservationsj" data-target-input="nearest">
                                        <input type="text" name="date" id="date" class="form-control datetimepicker-input" data-target="#reservationsj" />
                                        <div class="input-group-append" data-target="#reservationsj" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="control-group">
                                    <label class="control-label">Akun</label>
                                    <div class="controls">
                                        <select name="pengeluaran_id" id="pengeluaran_id" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" value="#">--SELECT--</option>
                                            @foreach($jenisPengeluaran as $pengeluaran)
                                            @if ($pengeluaran->id != 1)
                                            <option value="{{$pengeluaran->id}}">{{$pengeluaran->keterangan}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="control-group">
                                    <label class="control-label">Debit</label>
                                    <div class="controls">
                                        <input class="form-control number-input" name="debit" id="debit" value="0" placeholder="Type something here..." type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="control-group">
                                    <label class="control-label">Credit</label>
                                    <div class="controls">
                                        <input class="form-control number-input" name="kredit" id="kredit" value="0" placeholder="Type something here..." type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="control-group">
                                    <label class="control-label">Keterangan</label>
                                    <div class="controls">
                                        <input class="form-control" type="Text" name="uraian" id="uraian" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="control-group">
                                    <label class="control-label">Status</label>
                                    <div class="controls">
                                        <select name="status" id="status" class="form-control">
                                            <option value="#" selected="selected">Choose...</option>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('form-add').reset();location.reload()">Close</button>
                    <button id="in" type="button" class="btn btn-primary update">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="assets/css/jquery/jquery.min.js"></script>
<script>
    $(function() {
        $(document).ready(function() {

            // Log data on input change
            $('#date').on('input', function() {
                var dateValue = $(this).val();
                var monthOnly = moment(dateValue, 'DD/MM/YYYY').format('M');
                $('#month').val(monthOnly).trigger('change');
            });
        })
        $('.select2').select2({
            placeholder: "Choose..",
            theme: 'bootstrap4'
        })
        $('.date').datetimepicker({
            format: 'DD/MM/YYYY'

        });
        $(".number-input").on("input", function() {
            formatNumber(this);
        });

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
            ],
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
                {
                    targets: [3, 4],
                    render: $.fn.dataTable.render.number('.', '.', 0)
                },
            ],
            ajax: {
                url: '{{ url("json_uMakan") }}',
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
                    data: 'date',
                    name: 'date'
                },
                {
                    "data": "uraian",
                    "render": function(data, type, row) {
                        // Example: Change text color to red if status is "OPEN"
                        if (row.status === "OPEN") {
                            return '<span style="color: red;">' + data + '</span>';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'debit',
                    name: 'debit'
                },
                {
                    data: 'kredit',
                    name: 'kredit'
                },
                {
                    data: 'jenis_pengeluaran.keterangan',
                    name: 'jenis_pengeluaran.keterangan'
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                }
            ],
            order: [
                [0, 'desc'],
            ],
            drawCallback: function(settings) {
                var json = settings.json;
                if (json.hasOwnProperty('saldoAkhir')) {
                    var saldoAkhir = json.saldoAkhir;
                    // Lakukan sesuatu dengan data tambahan
                    // console.log(saldoAkhir);
                    $('#saldoAkhir').text('Saldo Akhir : Rp. ' + (saldoAkhir).toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                }
            }
        });
        $('.col-md-12').on('click', '#in', function() {
            $('#example1').data('dt_params', {
                'month': $('#month_search').val(),
                'year': $('#year_search').val(),
                'query': 'UMakan',
            });
            $('#example1').DataTable().draw();
        });
    });
    //add data
    $('.modal-footer').on('click', '.add', function() {
        var form = document.getElementById("form-add");
        var fd = new FormData(form);
        $.ajax({
            type: 'POST',
            url: '{{ url("store_uMakan") }}',
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
            url: 'edit_uMakan',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': uid,
            },
            success: function(data) {
                //console.log(data);

                //isi form
                $('#id').val(data.id);
                $('#date').val(new Date(data.date).toLocaleString("id-ID", newDateOptions).split(' ')[0]);
                $('#pengeluaran_id').val(data.pengeluaran_id).trigger('change');
                $('#uraian').val(data.uraian);
                $('#debit').val(formatNumberr(data.debit));
                $('#kredit').val(formatNumberr(data.kredit));
                $('#month').val(data.month).trigger('change');
                $('#status').val(data.status).trigger('change');

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
            url: 'update_uMakan/' + id,
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
    //delete

    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        if (confirm('Yakin akan menghapus data ini?')) {
            // alert("Thank you for subscribing!" + $(this).data('id') );
            $.ajax({
                type: 'DELETE',
                url: 'delete_uMakan/' + $(this).data('id'),
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

    function reset_form() {
        $('#form-add select').val(null).trigger('change.select2').attr("disabled", false);
        $('#form-add input').removeAttr('value').attr("disabled", false);
        // $('#form-add input').val(null);
        $("#form-add").trigger('reset');
        location.reload();
    };
</script>

@endsection