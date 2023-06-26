@extends('index')


@section('konten')
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
                                        <th>Code Part</th>
                                        <th>Part No</th>
                                        <th>Part Name</th>
                                        <th>Price</th>
                                        <th>Sa Dm</th>
                                        <th>Qty Hanger</th>
                                        <th>Type Pack</th>
                                        <th>Information</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Customer</th>
                                        <th>Code Part</th>
                                        <th>Part No</th>
                                        <th>Part Name</th>
                                        <th>Price</th>
                                        <th>Sa Dm</th>
                                        <th>Qty Hanger</th>
                                        <th>Type Pack</th>
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
                            <div class="col-md-12">
                                <div class="control-group">
                                    <label class="control-label">Part Name Local</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="name_local" id="name_local" placeholder="Type something here..." class="span15" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="control-group">
                                    <label class="control-label">Part Number</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="part_no" id="part_no" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="control-group">
                                    <label class="control-label">Part Name</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="part_name" id="part_name" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Price</label>
                                    <div class="controls">
                                        <input class="form-control autonumeric-integer" type="text" name="price" id="price" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Customer</label>
                                    <div class="controls">
                                        <select name="cust_id" id="cust_id" class="form-control select2" style="width: 100%;">
                                            <option selected="selected">Choose...</option>
                                            @foreach($customer as $customer)
                                            <option value="{{$customer->id}}">{{$customer->code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">Sa Dm</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" step="0.01" name="sa_dm" id="sa_dm" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">Qty Hanger</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="qty_hanger" id="qty_hanger" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">Qty Pack</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="qty_pack" id="qty_pack" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Type Pack</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="type_pack" id="type_pack" placeholder="Type something here..." class="span15">
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
    <div id="mass" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="massLabel" aria-hidden="true" style="display: none ;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-titlee" id="massLabel">Update Price Mass</h4>
                </div>
                <div class="modal-body" id="mass_price">
                    <form method="post" role="form" id="form-mass" enctype="multipart/form-data">
                        @csrf
                        <span id="peringatan"></span>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="control-group">
                                        <label class="control-label">Number PO</label>
                                        <div class="controls">
                                            <select name="order_id" id="order_id" class="form-control select2" style="width: 100%;">
                                                <option value="#" selected="selected">Choose...</option>
                                                <option value="blank">BLANK (NO PO)</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="control-group">
                                        <label class="control-label">Number INV</label>
                                        <div class="controls">
                                            <select name="invoice_id" id="invoice_id" class="form-control select2" style="width: 100%;">
                                                <option value="#" selected="selected">Choose...</option>
                                                <option value="blank">BLANK (NO INV)</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="control-group">
                                        <label>Date Update Range</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right" id="reservation">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-body" id="modal_sj">
                    <form method="post" role="form" id="form-sj" enctype="multipart/form-data">
                        <input class="form-control" type="text" name="id_part" id="id_part" hidden>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('form-mass').reset();">Close</button>
                    <button id="update-price" type="button" class="btn btn-primary">Save changes</button>
                    <button id="update_price" type="button" class="btn btn-primary">Save changes</button>
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
            text: 'Add Part',
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
            lengthMenu: [
                [10, 25, 100, -1],
                [10, 25, 100, "All"]
            ],
            pageLength: 10,
            "autoWidth": false,
            "columnDefs": [{
                    "className": "text-center",
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10], // table ke 1
                },
                {
                    "visible": false,
                    "targets": [4, 9]
                },
            ],
            "buttons": ["add",
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                },
                'pageLength',
                {
                    extend: "colvis",
                    text: '<i class="fas fa-border-all"></i>'
                }
            ],
            ajax: {
                url: '{{ url("json_parts") }}'
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
                    data: 'name_local',
                    name: 'name_local'
                },
                {
                    data: 'part_no',
                    name: 'part_no'
                },
                {
                    data: 'part_name',
                    name: 'part_name'
                },
                {
                    data: 'price',
                    render: $.fn.dataTable.render.number(',', 0),
                    name: 'price'
                },
                {
                    data: 'sa_dm',
                    render: $.fn.dataTable.render.number(',', '.', 2, ''),
                    name: 'sa_dm'
                },
                {
                    data: 'qty_hanger',
                    name: 'qty_hanger'
                },
                {
                    data: 'type_pack',
                    name: 'type_pack'
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
            url: '{{ url("import_parts") }}',
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
            url: '{{ url("store_parts") }}',
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
    //edit data
    $(document).on('click', '#edit', function(e) {
        e.preventDefault();
        var uid = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: 'edit_parts',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': uid,
            },
            success: function(data) {
                //console.log(data);

                //isi form
                document.getElementById("form-add").reset();
                $('#id').val(data[0].id);
                $('#cust_id').val(data[0].cust_id).trigger('change');
                $('#name_local').val(data[0].name_local);
                $('#part_no').val(data[0].part_no);
                $('#part_name').val(data[0].part_name);
                AutoNumeric.getAutoNumericElement('#price').set(data[0].price);
                $('#sa_dm').val(data[0].sa_dm);
                $('#qty_hanger').val(data[0].qty_hanger);
                $('#qty_pack').val(data[0].qty_pack);
                $('#type_pack').val(data[0].type_pack);
                $('#information').val(data[0].information);

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
            url: 'update_parts/' + id,
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
                url: 'delete_parts/' + $(this).data('id'),
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

    //update price mass
    $(document).on('click', '#mass-price,#updSJ', function(e) {
        document.getElementById("form-mass").reset();
        e.preventDefault();
        idPart = $(this).data('id');
        idCust = $(this).data('cust');
        var updSJ = $(this).data('sj');

        if (updSJ == "updSJ") {
            $('#mass_price').hide();
            $('#modal_sj').show();
            $('#update-price').hide();
            $('#update_price').show();
            $(".multi-sj").select2({
                tags: true
            });
            $('#mass').modal('show');

            $.ajax({
                type: 'POST',
                url: 'edit_parts',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': idPart,
                },
                success: function(data) {
                    $('#id_part').val(data[0].id);
                    //no_sj
                    $('[name="updSJ[]"]').empty();
                    $.each(data[1], function(i) {
                        $('[name="updSJ[]"]').append('<option value="' + data[1][i].id + '">' + data[1][i].nosj + '-' + data[1][i].customer.code + '</option>');
                    });
                },
            });

        } else {
            $.ajax({
                type: 'POST',
                url: 'search_order',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'cust_id': idCust,

                },
                success: function(data) {
                    $('[name="order_id"]').empty();
                    $('[name="order_id"]').append('<option value="#">Choose...</option>');
                    $('[name="order_id"]').append('<option value="blank">BLANK (NO PO)</option>');
                    $.each(data, function(i) {
                        $('[name="order_id"]').append('<option value="' + data[i]
                            .id + '">' + data[i].no_po + '</option>');
                    })

                },
            });
            $.ajax({
                type: 'POST',
                url: 'search_invoice',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'cust_id': idCust,

                },
                success: function(data) {
                    $('[name="invoice_id"]').empty();
                    $('[name="invoice_id"]').append('<option value="#">Choose...</option>');
                    $('[name="invoice_id"]').append('<option value="blank">BLANK (NO INV)</option>');
                    $.each(data, function(i) {
                        $('[name="invoice_id"]').append('<option value="' + data[i]
                            .id + '">' + data[i].no_invoice + '</option>');
                    })

                },
            });

            $('#update-price').show();
            $('#update_price').hide();
            $('#mass_price').show();
            $('#modal_sj').hide();
            $('#mass').modal('show');
        }

    });
    //update price
    $(document).on('click', '#update-price', function() {
        var date = $('#reservation').val().split(" - ");

        $.ajax({
            type: 'POST',
            url: 'update_price',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': idPart,
                'dateStart': date[0],
                'dateEnd': date[1],
                'order_id': $('#order_id').val(),
                'invoice_id': $('#invoice_id').val(),
            },
            beforeSend: function(xhr) {
                if (!verifyData()) {
                    xhr.abort();
                }
            },
            success: function(data) {
                document.getElementById("form-mass").reset();
                $('#mass').modal('hide');
            },
            error: function(xhr) {
                console.log('Error: ' + xhr.statusText);
            }
        });

        function verifyData() {
            // Lakukan verifikasi data di sini
            if ($('#order_id').val() === '#' && $('#invoice_id').val() === '#') {
                alert('No PO atau No Invoice harus diisi');
                return false;
            }
            if ($('#reservation').val() === '') {
                alert('Tanggal harus diisi');
                return false;
            }
            return true;
        }
    });
    //update price by SJ
    $(document).on('click', '#update_price', function() {
        var form = document.getElementById("form-sj");
        var fd = new FormData(form);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: 'update_price_bysj',
            data: fd,
            processData: false,
            contentType: false,
            success: function(data) {
                document.getElementById("form-sj").reset();
                $('#mass').modal('hide');
            },
        });
    });
</script>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#mass')
        })
        $('#reservation').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            },
            function(start, end) {
                dateinn = start.format('YYYY-MM-DD');
                dateenn = end.format('YYYY-MM-DD');
                // console.log(dateinn);
            }
        )
        // AutoNumeric.multiple('.autonumeric-integer', AutoNumeric.getPredefinedOptions().integerPos);
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
        AutoNumeric.multiple('.autonumeric-integer', mixedOptions);
    })
    $(document).ready(function() {
        // $('.pt-2').on('click', '#in', function() {
        //     var date = $('#reservation').val().split(" - ");
        //     $('#example1').data('dt_params', {
        //         'cust_id': $('#cust_id').val(),
        //         'date_st': date[0],
        //         'date_ot': date[1],
        //         'type': $('#type').val(),
        //         'part_id': $('#part_id').val(),
        //     });
        //     $('#example1').DataTable().draw();
        // });

    });
</script>

@endsection