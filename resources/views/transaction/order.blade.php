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
                                        <th>No PO</th>
                                        <th>Date In</th>
                                        <th>Customer</th>
                                        <th>Progress</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>No PO</th>
                                        <th>Date In</th>
                                        <th>Customer</th>
                                        <th>Progress</th>
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
                        <span id="peringatan"></span>
                        <input class="form-control" type="text" name="id" id="id" hidden>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="control-group">
                                    <label>Date</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="date" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" />
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label">No Order</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="no_po" id="no_po" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
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
                                                    <th style="width: 10%">Qty</th>
                                                    <th style="width: 10%">Progress</th>
                                                    <th style="width: 15%">Price</th>
                                                    <th style="width: 20%">Total Price</th>
                                                </tr>
                                            </thead>
                                            <tbody id="roww">
                                                <tr>
                                                    <td id="col0">
                                                        <input type="hidden" id="detail_id0" name="detail_id[]">
                                                        <select name="part_id[]" id="part_id0" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected">Choose...</option>
                                                        </select>
                                                    </td>
                                                    <td id="col1">
                                                        <input class="form-control number-input" type="text" name="qty[]" onchange="search_price(this)" id="qty0" placeholder="Qty" class="span15">
                                                    </td>
                                                    <td id="col2">
                                                        <input class="form-control number-input" type="text" name="qty_progress[]" id="qty_progress0" readonly class="span15">
                                                    </td>
                                                    <td id="col3">
                                                        <input class="form-control number-input" type="text" name="price[]" id="price0" readonly class="span15">
                                                    </td>
                                                    <td id="col4">
                                                        <input class="form-control number-input" type="text" name="total_price[]" id="total_price0" readonly class="span15">
                                                    </td>
                                                    <td id="col5">
                                                        <button id="upd_pr0" class="btn btn-warning" type="button" onclick="update_price(this)">Update</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot id="addfoot">
                                                <tr>
                                                    <td colspan="3">
                                                        <button id="addrow" type="button" name="add-tab" onclick="addRows()" class="btn btn-secondary">Add Row</button>
                                                        <button id="deleterow" type="button" name="add-tab" onclick="deleteRows()" class="btn btn-secondary">Delete Row</button>
                                                        <button id="revisi-tab" type="button" name="revisi-tab" class="btn btn-secondary">Revisi</button>
                                                    </td>
                                                    <td>
                                                        <p style="text-align: right;">Grand Total</p>
                                                    </td>
                                                    <td>
                                                        <input class="form-control number-input" name="grand_total" id="grand_total" type="text" readonly>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
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
<!-- <script type="text/javascript" src="assets/js/autonumeric/autoNumeric.min.js"></script>
<script>
    new AutoNumeric('[name="qty[]"]', {
        decimalPlaces: "0",
    });
</script> -->
<!-- <script src="/js/jquery-3.5.1.js"></script> -->
<script>
    $(function() {
        //open-user
        $.fn.dataTable.ext.buttons.add = {
            text: 'Add Order',
            action: function(e, dt, node, config) {
                $('.modal-title').text('Tambah Data');
                $("#in").removeClass("btn btn-primary update");
                $("#in").addClass("btn btn-primary add");
                $('#in').text('Save');
                // reset_form();
                $('#SJJ').hide();
                //document.getElementById("addfoot").removeAttribute("hidden");
                // autonumeric(0);
                $("#addrow,#deleterow").show();
                $('#revisi-tab').hide();
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
                    "targets": [0, 1, 2, 3, 4, 5, 6], // table ke 1
                },
                // {
                //     "visible": false,
                //     "targets": [9]
                // },
                {
                    targets: 2,
                    render: function(oTable) {
                        return moment(oTable).format('DD-MM-YYYY');
                    }
                },
                {
                    orderable: false,
                    targets: 0
                }
            ],
            order: [
                [2, "desc"]
            ],
            "buttons": ["add",
                {
                    extend: "colvis",
                    text: '<i class="fas fa-border-all"></i>'
                }

            ],
            ajax: {
                url: '{{ url("json_order") }}'
            },
            "fnCreatedRow": function(row, data, index) {
                $('td', row).eq(0).html(index + 1);
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'no_po',
                    name: 'no_po'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'customer.code',
                    name: 'customer.code'
                },
                {
                    data: 'count',
                    name: 'count',
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
    //import data
    $('.modal-footer').on('click', '#import', function() {
        var form = document.getElementById("form-import");
        var fd = new FormData(form);
        $.ajax({
            type: 'POST',
            url: '{{ url("import_order") }}',
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
            url: 'store_order',
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
                    // $('#example1').DataTable().ajax.reload();
                    reset_form();
                    location.reload();
                }

            },
        });
    });
    //end add data
    $('#revisi-tab').click(function() {
        $('[name="part_id[]"],[name="qty[]"],[name="detail_id[]"]').attr("disabled", false);
        $("#addrow").show();
        $('#revisi-tab').hide();
    });
    //edit data
    $(document).on('click', '#edit', function(e) {
        e.preventDefault();
        var uid = $(this).data('id');
        var updSJ = $(this).data('sj');
        var newDateOptions = {
            year: "numeric",
            month: "2-digit",
            day: "2-digit"
        }

        $.ajax({
            type: 'POST',
            url: 'edit_order',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': uid,
            },
            success: function(data) {
                //console.log(data.detail_part_in[0].part_id);

                //isi form
                $('#id').val(data[0].id);
                $('#cust_id').val(data[0].cust_id).trigger('change').attr("disabled", true);;
                $('#no_po').val(data[0].no_po);
                $('#status').val(data[0].status).trigger('change');
                // let text = "";
                for (let i = 1; i < data[0].detail_order.length; i++) {
                    addRows();
                }
                // $('#roww').append(text);
                setTimeout(function() {
                    for (let j = 0; j < data[0].detail_order.length; j++) {
                        // setTimeout(function() {
                        $('#detail_id' + [j]).val(data[0].detail_order[j].id).attr("disabled", true);
                        $('#total_price' + [j]).val(formatNumberr(data[0].detail_order[j].price)).attr("disabled", true);
                        $('#part_id' + [j]).val(data[0].detail_order[j].part_id).trigger('change').attr("disabled", true);
                        $('#qty' + [j]).val(formatNumberr(data[0].detail_order[j].qty)).attr("disabled", true);;
                        $('#price' + [j]).val(formatNumberr(data[0].detail_order[j].price / data[0].detail_order[j].qty));
                        $.ajax({
                            type: 'POST',
                            url: 'search_progress_po',
                            data: {
                                '_token': "{{ csrf_token() }}",
                                'po_id': data[0].detail_order[j].order_id,
                                'part_id': data[0].detail_order[j].part_id

                            },
                            success: function(data) {
                                if (data != "false") {
                                    $('#qty_progress' + [j]).val(formatNumberr(data.qty)).attr("disabled", true);
                                } else {
                                    $('#qty_progress' + [j]).val(formatNumberr(data.qty)).attr("disabled", true);
                                }
                            },
                        });
                        // autonumeric(j);
                        // }, 1000);
                    }
                    findTotal(data[0].detail_order.length);
                }, 1000);

                $('#date').val(new Date(data[0].date).toLocaleString("id-ID", newDateOptions).split(' ')[0]).attr("disabled", true);;
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
                //document.getElementById("rowadd").setAttribute("hidden", "hidden");
                $("#addrow,#deleterow").hide();
                $('#revisi-tab, #upd_pr0').show();
                $("#in").removeClass("btn btn-primary add");
                $("#in").addClass("btn btn-primary update");
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
            url: 'update_order/' + id,
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
                url: 'delete_order/' + $(this).data('id'),
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

    $(document).ready(function() {
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
                        $('[name="part_id[]"]').append('<option value="' + data[i].id + '">' + data[i].name_local + '</option>');
                    })

                },
            });
        });


    });
</script>
<script>
    // Set option selected onchange
    function search_price(i) {
        //console.log(i.id);
        var matches = i.id.match(/\d+/);
        var total_price = $('#total_price' + matches[0]).val();
        var price = $("#price" + matches[0]).val();
        var qty = $('#qty' + matches[0]).val();
        // console.log(total_price);
        // console.log(qty);
        $.ajax({
            type: 'POST',
            url: 'search_price',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': $('#part_id' + matches[0]).val(),

            },
            success: function(data) {
                if (total_price === "") {
                    $('#price' + matches[0]).val(formatNumberr(data));
                    // $('#total_price' + matches[0]).val(qty.replaceAll(".", "") * data);
                    // autonumeric(matches[0]);
                    $('#total_price' + matches[0]).val(formatNumberr(qty.replaceAll(".", "") * data));
                } else if (price.replaceAll(".", "") == data) {
                    // $('#total_price' + matches[0]).val(qty.replaceAll(".", "") * data);
                    // autonumeric(matches[0]);
                    $('#total_price' + matches[0]).val(formatNumberr(qty.replaceAll(".", "") * data));
                }
                findTotal(matches[0] + 1);
            },
        });
    };

    function update_price(i) {
        //console.log(i.id);
        var matches = i.id.match(/\d+/);
        var total_price = $('#total_price' + matches[0]).val();
        var price = $("#price" + matches[0]).val();
        var qty = $('#qty' + matches[0]).val();
        // console.log(total_price);
        // console.log(qty);
        $.ajax({
            type: 'POST',
            url: 'search_price',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': $('#part_id' + matches[0]).val(),

            },
            success: function(data) {
                // if (total_price === "") {
                $('#price' + matches[0]).val(formatNumberr(data));
                $('#total_price' + matches[0]).val(formatNumberr(qty.replaceAll(".", "") * data));
                // } else if (price.replaceAll(".", "") == data) {
                //     $('#total_price' + matches[0]).val(qty.replaceAll(".", "") * data);
                //     autonumeric(matches[0]);
                // }
                findTotal(matches[0] + 1);
            },
        });
    };

    $(function() {
        //Initialize Select2 Elements
        $('#cust_id,#status').select2({
            dropdownParent: $('#myModal'),
            theme: 'bootstrap4'
        })
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'DD/MM/YYYY'

        });
    });

    function findTotal(id) {
        //var arr = document.getElementsByName('total_price[]');
        var table = document.getElementById('roww');
        var rowCount = table.rows.length;
        //console.log(rowCount);
        //console.log(id);
        var tow = $('#grand_total').val();
        var tot = 0;
        for (var i = 0; i < id; i++) {
            if (parseFloat($('#total_price' + i).val())) {
                var total_p = $('#total_price' + i).val().replaceAll(".", "");
                tot += parseFloat(total_p);
            }
        }
        //AutoNumeric.getAutoNumericElement('#grand_total').set(tot);
        $('#grand_total').val(formatNumberr(tot));
    }

    function addRows() {
        var table = document.getElementById('roww');
        var rowCount = table.rows.length;
        var cellCount = table.rows[0].cells.length;
        var row = table.insertRow(rowCount);
        for (var i = 0; i < cellCount; i++) {
            var cell = 'cell' + i;
            cell = row.insertCell(i);
            var copycel = document.getElementById('col' + i).innerHTML;
            cell.id = 'col' + i + rowCount;
            cell.innerHTML = copycel;

            if (i == 0) {
                var detailId = document.getElementById('col0' + rowCount).getElementsByTagName('input');
                detailId[0].id = 'detail_id' + rowCount;
                detailId[0].value = "";
                var partidinput = document.getElementById('col0' + rowCount).getElementsByTagName('select');
                partidinput[0].id = 'part_id' + rowCount;
                $('#part_id' + rowCount).select2({
                    placeholder: "Choose..",
                    theme: 'bootstrap4'
                })
            }
            if (i == 1) {
                var qtyinput = document.getElementById('col1' + rowCount).getElementsByTagName('input');
                qtyinput[0].id = 'qty' + rowCount;
                qtyinput[0].value = "";
            }
            if (i == 2) {
                var progressinput = document.getElementById('col2' + rowCount).getElementsByTagName('input');
                progressinput[0].id = 'qty_progress' + rowCount;
                progressinput[0].value = "";
            }
            if (i == 3) {
                var priceinput = document.getElementById('col3' + rowCount).getElementsByTagName('input');
                priceinput[0].id = 'price' + rowCount;
                priceinput[0].value = "";

            }
            if (i == 4) {
                var radioinput = document.getElementById('col4' + rowCount).getElementsByTagName('input');
                radioinput[0].id = 'total_price' + rowCount;
                radioinput[0].value = "";
            }
            if (i == 5) {
                var upd_pr = document.getElementById('col5' + rowCount).getElementsByTagName('button');
                upd_pr[0].id = 'upd_pr' + rowCount;
            }
            $(".number-input").on("input", function() {
                formatNumber(this);
            });
        }
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

    function reset_form() {
        $('#form-add select').val(null).trigger('change.select2').attr("disabled", false);
        $('#form-add input').removeAttr('value').attr("disabled", false);
        document.getElementById("form-add").reset();
        $('.datetimepicker-input').val(null).prop('readonly', false);
        //$('#upd_pr0').hide();
        var table = document.getElementById('roww');
        var rowCount = table.rows.length;
        for (o = 0; o <= rowCount; o++) {
            deleteRows();
        }
        //$('#user_id').val('{{ Auth::user()->name }}');
    };
</script>

@endsection