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
                            <form method="post" role="form" id="form-add" enctype="multipart/form-data">
                                <span id="peringatan"></span>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="control-group">
                                            <label class="control-label">Customer</label>
                                            <div class="controls">
                                                <select name="cust_id" id="cust_id" class="form-control select2">
                                                    <option value="#" selected="selected">Choose...</option>
                                                    @foreach($customer as $customer)
                                                    <option value="{{$customer->id}}">{{$customer->code}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="control-group">
                                            <label>Date Range</label>
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
                                    <div class="col-md-2">
                                        <div class="control-group">
                                            <label class="control-label">Type</label>
                                            <div class="controls">
                                                <select name="type" id="type" class="form-control select2">
                                                    <option value="#" selected="selected">Choose...</option>
                                                    <option value="REGULER">REGULER</option>
                                                    <option value="BAYAR_RETUR">BAYAR RETUR</option>
                                                    <option value="REPAINTING">REPAINTING</option>
                                                    <option value="SAMPEL">SAMPEL</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="control-group">
                                            <label class="control-label">Part Name</label>
                                            <div class="controls">
                                                <select name="part_id" id="part_id" class="form-control">
                                                    <option value="#" selected="selected">Choose...</option>
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
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>No Po</th>
                                        <th>Customer</th>
                                        <th>Part Name</th>
                                        <th>Qty</th>
                                        <th>Qty Progress</th>
                                        <th>Out Standing</th>
                                    </tr>
                                </thead>
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
</div>
<!-- jQuery -->
<script src="assets/css/jquery/jquery.min.js"></script>
<!-- <script src="/js/jquery-3.5.1.js"></script> -->
<script>
    $(document).ready(function() {
        $('#reservation').val("")
        var date
        var oTable = $('#example1').DataTable({
            processing: true,
            paging: false,
            serverSide: true,
            order: [
                [1, "asc"]
            ],
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
                    targets: [4, 5, 6],
                    render: $.fn.dataTable.render.number('.')
                },
            ],
            buttons: [{
                    extend: 'excel',
                    footer: true,

                },
                {
                    extend: 'csv',
                    footer: true
                },
                {
                    extend: 'pdf',
                    footer: true
                },
                {
                    extend: 'print',
                    footer: true
                }
            ],
            ajax: {
                url: '{{ url("report_order") }}',
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
                    data: 'order.date',
                    name: 'order.date'
                },
                {
                    data: 'order.no_po',
                    name: 'order.no_po'
                },
                {
                    data: 'parts.customer.code',
                    name: 'parts.customer.code'
                },
                {
                    data: 'parts.name_local',
                    name: 'parts.name_local'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'qty_progress',
                    name: 'qty_progress'
                },
                {
                    "data": function(row) {
                        var qtyProgress = row.qty_progress - row.qty;

                        function formatAngkaRibuan(angka) {
                            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }

                        var formattedQtyProgress = formatAngkaRibuan(qtyProgress);

                        if (qtyProgress < 0) {
                            return '<span style="color: red;">' + formattedQtyProgress + '</span>';
                        } else {
                            return formattedQtyProgress;
                        }
                    },
                    name: 'qty_progress'
                },
            ],
        });
        $('.pt-2').on('click', '#in', function() {
            var date = $('#reservation').val().split(" - ");
            // console.log($('#reservation').val().split(" - "));
            $('#example1').data('dt_params', {
                'cust_id': $('#cust_id').val(),
                'date_st': date[0],
                'date_ot': date[1],
                'type': $('#type').val(),
                'part_id': $('#part_id').val(),
            });
            $('#example1').DataTable().draw();
            reset_form();
        });
    });
    //end update
    $(document).ready(function() {
        // $('#in2,#in3,#in4').hide();
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
                    $('[name="part_id"]').empty();
                    $('[name="part_id"]').append('<option value="#">Choose...</option>');
                    $.each(data, function(i) {
                        $('[name="part_id"]').append('<option value="' + data[i].id + '">' + data[i].name_local + '</option>');
                    })

                },
            });

        });
    });
</script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('[name="part_id"],[name="type[]"],#cust_id,#order_id').select2({
            placeholder: "Choose..",
            theme: 'bootstrap4'
        })
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'DD/MM/YYYY'

        });
        $('#reservation').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            },
            function(start, end) {
                dateinn = start.format('YYYY-MM-DD');
                dateenn = end.format('YYYY-MM-DD');
                //console.log(dateinn);
            }
        )
        $('#reservation').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        AutoNumeric.multiple('.autonumeric-integer', AutoNumeric.getPredefinedOptions().integerPos);
    })

    function reset_form() {
        $('#form-add select').val("#").trigger('change.select2');
        // $('#form-add input').val(null);
        document.getElementById("form-add").reset();
    };
    window.onload = reset_form;
</script>

@endsection