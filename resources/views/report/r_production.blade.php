@extends('index')


@section('konten')
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
                        <div class="card-body">
                            <form id="form-add" method="post" role="form" enctype="multipart/form-data">
                                <span id="peringatan"></span>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="control-group">
                                            <label class="control-label">Customer</label>
                                            <div class="controls">
                                                <select name="cust_id" id="cust_id" class="form-control select2">
                                                    <option value="#" selected="selected">Choose...</option>
                                                    @foreach ($customer as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->code }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="control-group">
                                            <label class="control-label">Part Name</label>
                                            <div class="controls">
                                                <select name="part_id" id="part_id" class="form-control">
                                                    <option value="#" selected="selected">Choose...</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="control-group">
                                            <label class="control-label">Part Type</label>
                                            <div class="controls">
                                                <select name="type" id="type" class="form-control select2" style="width: 100%;">
                                                    <option value="#" selected="selected">Choose...</option>
                                                    <option value="WIP">WIP</option>
                                                    <option value="REPAINTING">REPAINTING</option>
                                                    <option value="RETURN">RETURN</option>
                                                    <option value="SAMPLE">SAMPLE</option>
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
                                                <input type="text" name="date" class="form-control float-right" id="reservation">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="control-group">
                                            <label class="control-label">Status</label>
                                            <div class="controls">
                                                <select name="status" id="status" class="form-control select2" style="width: 100%;">
                                                    <option value="#" selected="selected">Choose...</option>
                                                    <option value="OPEN">OPEN</option>
                                                    <option value="CLOSE">CLOSE</option>
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
                                        <th>No Rak</th>
                                        <th>Customer</th>
                                        <th>Name Part</th>
                                        <th>Type</th>
                                        <th>Qty In</th>
                                        <th>Time Start</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="8" style="text-align:right">Total:</th>
                                        <th></th>
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
</div>
<!-- jQuery -->
<script src="assets/css/jquery/jquery.min.js"></script>
<!-- <script src="/js/jquery-3.5.1.js"></script> -->
<script>
    $(document).ready(function() {
        $('#reservation').val("")
        var dateinn, dateenn
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
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8], // table ke 1
                },
                {
                    targets: [1],
                    render: function(oTable) {
                        return moment(oTable).format('DD/MM/YYYY');
                    },
                },
                {
                    targets: [7],
                    render: function(oTable) {
                        return moment(oTable).format('H:mm:s');
                    },
                },
                {
                    targets: [8],
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
            footerCallback: function(row, data, start, end, display) {
                var api = this.api();
                // Remove the formatting to get integer data for summation
                var intVal = function(i) {

                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;

                };

                // Total over all pages

                if (api.column(8).data().length) {
                    var total = api
                        .column(8)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        })
                } else {
                    total = 0
                };

                // Update footer
                $(api.column(8).footer()).html(
                    new Intl.NumberFormat().format(total)
                );
            },
            ajax: {
                url: '{{ url("rekap_production") }}',
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
                    data: 'transaction.no_transaction',
                    name: 'transaction.no_transaction'
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
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'qty_in',
                    name: 'qty_in'
                },
                {
                    data: 'transaction.time_start',
                    name: 'transaction.time_start'
                },
                {
                    data: 'price',
                    name: 'price'
                }
            ],
        });
        $('.pt-2').on('click', '#in', function() {
            var date = $('#reservation').val().split(" - ");
            // console.log($('#cust_id').val());
            $('#example1').data('dt_params', {
                'cust_id': $('#cust_id').val(),
                'part_id': $('#part_id').val(),
                'type': $('#type').val(),
                'dateinn': date[0],
                'dateenn': date[1],
                'status': $('#status').val(),
            });
            $('#example1').DataTable().draw();
            reset_form();
        });

        $('#cust_id').change(function() {
            var value = $(this).val();
            console.log(value);
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
        $('[name="part_id"],#status,#cust_id,#order_id,#type').select2({
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
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                'DD/MM/YYYY'));
        });

        $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        AutoNumeric.multiple('.autonumeric-integer', AutoNumeric.getPredefinedOptions().integerPos);
    })

    function reset_form() {
        // $('#form-add input').val(null);
        var frm = document.getElementById("form-add");
        frm.reset();
        $('#form-add select').val("#").trigger('change.select2');
        return false;
    };
</script>
@endsection