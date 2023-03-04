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
                                        <th>Work Hour</th>
                                        <th>Normal Capacity</th>
                                        <th>Target</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Work Hour</th>
                                        <th>Normal Capacity</th>
                                        <th>Target</th>
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
                                    <label class="control-label">Jam Kerja</label>
                                    <div class="controls">
                                        <input class="form-control" type="number" name="work_hours" id="work_hours" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Kapasitas Normal</label>
                                    <div class="controls">
                                        <input class="form-control" type="number" name="normal_capacity" id="normal_capacity" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Target</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="target" id="target" placeholder="Type something here... %" class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Status</label>
                                    <div class="controls">
                                        <select name="status" id="status" class="form-control" style="width: 100%;">
                                            <option value="#" selected="selected">Choose...</option>
                                            <option value="Active">Active</option>
                                            <option value="Nonactive">Nonactive</option>
                                        </select>
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
                "targets": [0, 1, 2, 3, 4, 5], // table ke 1
            }],
            ajax: {
                url: '{{ url("json_productStd") }}'
            },
            "fnCreatedRow": function(row, data, index) {
                $('td', row).eq(0).html(index + 1);
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'work_hours',
                    name: 'work_hours'
                },
                {
                    data: 'normal_capacity',
                    name: 'normal_capacity'
                },
                {
                    data: 'target',
                    name: 'target'
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
            type: 'POST',
            url: '{{ url("store_productStd") }}',
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

        $.ajax({
            type: 'POST',
            url: 'edit_productStd',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': uid,
            },
            success: function(data) {
                //console.log(data);

                //isi form
                $('#id').val(data.id);
                $('#work_hours').val(data.work_hours).attr("disabled", true);
                $('#normal_capacity').val(data.normal_capacity).attr("disabled", true);
                $('#target').val(data.target).attr("disabled", true);
                $('#status').val(data.status);

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
            url: 'update_productStd/' + id,
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
</script>

@endsection