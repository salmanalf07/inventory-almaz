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
                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
                                        <div class="control-group">
                                            <label class="control-label">Month</label>
                                            <div class="controls">
                                                <select name="month" id="month" class="form-control select2">
                                                    <option value="#" selected="selected">Choose...</option>
                                                    <?php for ($i = 1; $i <= 31; $i++) { ?>
                                                        <option value="{{$i}}">{{$i}}</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="control-group">
                                            <label class="control-label">Year</label>
                                            <div class="controls">
                                                <select name="year" id="year" class="form-control select2">
                                                    <option value="#" selected="selected">Choose...</option>
                                                    <?php for ($j = 2017; $j <= 2040; $j++) { ?>
                                                        <option value="{{$j}}">{{$j}}</option>
                                                    <?php } ?>
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
                                        <th>Tahun</th>
                                        <th>Bulan</th>
                                        <th>Customer</th>
                                        <th>Nomor Inv</th>
                                        <th>Harga Jual</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" style="text-align:right">Total:</th>
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
                    "targets": [0, 1, 2, 3, 4, 5, 6], // table ke 1
                },
                {
                    targets: [5, 6],
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

                if (api.column(6).data().length) {
                    var total = api
                        .column(6)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        })
                } else {
                    total = 0
                };

                // Update footer
                $(api.column(6).footer()).html(
                    new Intl.NumberFormat().format(total)
                );
            },
            ajax: {
                url: '{{ url("report_invoice") }}',
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
                    data: 'book_year',
                    name: 'book_year'
                },
                {
                    data: 'book_month',
                    name: 'book_month'
                },
                {
                    data: 'customer.code',
                    name: 'customer.code'
                },
                {
                    data: 'no_invoice',
                    name: 'no_invoice'
                },
                {
                    data: 'harga_jual',
                    name: 'harga_jual'
                },
                {
                    data: 'total_harga',
                    name: 'total_harga'
                }
            ],
        });
        $('.pt-2').on('click', '#in', function() {
            // console.log($('#reservation').val().split(" - "));
            $('#example1').data('dt_params', {
                'cust_id': $('#cust_id').val(),
                'month': $('#month').val(),
                'year': $('#year').val(),
            });
            $('#example1').DataTable().draw();
            reset_form();
        });
    });
</script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('#month,#year,#cust_id').select2({
            placeholder: "Choose..",
            theme: 'bootstrap4'
        })

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