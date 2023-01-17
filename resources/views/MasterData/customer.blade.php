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
                                        <th>Name Customer</th>
                                        <th>Code</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Send Address</th>
                                        <th>Distance</th>
                                        <th>Name PIC</th>
                                        <th>Phone PIC</th>
                                        <th>NPWP</th>
                                        <th>Type Invoice</th>
                                        <th>Invoice Schedule</th>
                                        <th>Information</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Name Customer</th>
                                        <th>Code</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Send Address</th>
                                        <th>Distance</th>
                                        <th>Name PIC</th>
                                        <th>Phone PIC</th>
                                        <th>NPWP</th>
                                        <th>Type Invoice</th>
                                        <th>Invoice Schedule</th>
                                        <th>Information</th>
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
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none ;">
        <div class="modal-dialog">
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
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Name Customer</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Code Customer</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="code" id="code" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="control-group">
                                    <label class="control-label">Adress</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="address" id="address" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="control-group">
                                    <label class="control-label">Adress Send</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="send_address" id="send_address" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Distance</label>
                                    <div class="controls">
                                        <input class="form-control" type="number" step="0.01" name="distance" id="distance" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Phone</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="phone" id="phone" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Name PIC</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="name_pic" id="name_pic" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Phone PIC</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="phone_pic" id="phone_pic" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Type Invoice</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="type_invoice" id="type_invoice" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">NPWP</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="npwp" id="npwp" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Invoice Schedule</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="invoice_schedule" id="invoice_schedule" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Information</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="information" id="information" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="ppn" id="ppn" value="Y">
                                    <label class="form-check-label" style="font-weight: bold;" for="ppn">PPN</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="pph" id="pph" value="Y">
                                    <label class="form-check-label" style="font-weight: bold;" for="pph">PPH 23</label>
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
                    <h4 class="modal-title" id="importLabel">Import Excel</h4>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('form-import').reset();">Close</button>
                    <button id="import" type="button" class="btn btn-primary">Save changes</button>
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
            text: 'Add Customer',
            action: function(e, dt, node, config) {
                $('.modal-title').text('Tambah Data');
                $("#in").removeClass("btn btn-primary update");
                $("#in").addClass("btn btn-primary add");
                $('#in').text('Save');
                $('#update_pass').hide();
                $('#password').show();
                document.getElementById("form-add").reset();
                $('#myModal').modal('show');
            }
        };

        var oTable = $('#example1').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "columnDefs": [{
                    "className": "text-center",
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10], // table ke 1
                },
                {
                    "visible": false,
                    "targets": [3, 5, 6, 9, 10, 11]
                },
            ],
            "buttons": ["add",
                {
                    extend: "colvis",
                    text: '<i class="fas fa-border-all"></i>'
                }
            ],
            ajax: {
                url: '{{ url("json_customer") }}'
            },
            "fnCreatedRow": function(row, data, index) {
                $('td', row).eq(0).html(index + 1);
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'send_address',
                    name: 'send_address'
                },
                {
                    data: 'distance',
                    name: 'distance'
                },
                {
                    data: 'name_pic',
                    name: 'name_pic'
                },
                {
                    data: 'phone_pic',
                    name: 'phone_pic'
                },
                {
                    data: 'npwp',
                    name: 'npwp'
                },
                {
                    data: 'type_invoice',
                    name: 'type_invoice'
                },
                {
                    data: 'invoice_schedule',
                    name: 'invoice_schedule'
                },
                {
                    data: 'information',
                    name: 'information'
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                }
            ],
        });
    });
    //import data
    $('.modal-footer').on('click', '#import', function() {
        var form = document.getElementById("form-import");
        var fd = new FormData(form);
        $.ajax({
            type: 'POST',
            url: '{{ url("import_customer") }}',
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
            type: 'POST',
            url: '{{ url("store_customer") }}',
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
                    document.getElementById("form-add").reset();
                    $('#example1').DataTable().ajax.reload();
                }

            },
        });
    });
    //end add data
    //update password
    $(document).on('click', '#update_pass', function() {
        $('#update_pass').hide();
        $('#password').show();
    });
    //edit data
    $(document).on('click', '#edit', function(e) {
        e.preventDefault();
        var uid = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: 'edit_customer',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': uid,
            },
            success: function(data) {
                //console.log(data);

                //isi form
                $('#id').val(data.id);
                $('#code').val(data.code);
                $('#name').val(data.name);
                $('#address').val(data.address);
                $('#send_address').val(data.send_address);
                $('#phone').val(data.phone);
                $('#name_pic').val(data.name_pic);
                $('#phone_pic').val(data.phone_pic);
                $('#distance').val(data.distance);
                $('#npwp').val(data.npwp);
                $('#type_invoice').val(data.type_invoice);
                $('#invoice_schedule').val(data.invoice_schedule);
                $('#information').val(data.information);
                if (data.ppn === "Y") {
                    $("#ppn").prop('checked', true);
                }
                if (data.pph === "Y") {
                    $("#pph").prop('checked', true);
                }

                id = $('#id').val();

                $('#update_pass').show();
                $('#password').hide();
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
            url: 'update_customer/' + id,
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
                    document.getElementById("form-add").reset();
                    $('#example1').DataTable().ajax.reload();
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
                url: 'delete_customer/' + $(this).data('id'),
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
</script>

@endsection