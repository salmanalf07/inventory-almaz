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
                            @if(request()->is('rekap_inv'))
                            <form id="form-add" method="post" role="form" id="form-print" action="rekap_invoice" enctype="multipart/form-data" formtarget="_blank" target="_blank">
                                @else
                                <form id="form-add" method="post" role="form" id="form-print" action="track_inv" enctype="multipart/form-data" formtarget="_blank" target="_blank">
                                    @endif
                                    @csrf
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
                                                <label class="control-label">Number PO</label>
                                                <div class="controls">
                                                    <select name="order_id" id="order_id" class="form-control select2" style="width: 100%;">
                                                        <option value="#" selected="selected">Choose...</option>
                                                        <option value="blank">BLANK (NO PO)</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
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
                                                        <option value="INVOICE">INVOICE</option>
                                                        <!-- <option value="CLOSE">CLOSE</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="control-group">
                                                <div class="controls pt-2">
                                                    <input onclick="reset_form()" id="subpr" class="btn btn-secondary btn-block" type="button" value="Rekap Surat Jalan">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                        </div>
                    </div>
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
    //end update
    $(document).ready(function() {
        // $('#in2,#in3,#in4').hide();
        // Set option selected onchange
        $('#cust_id').change(function() {
            var value = $(this).val();
            //console.log(value);
            $.ajax({
                type: 'POST',
                url: 'search_order',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'cust_id': $(this).val(),

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
                    'cust_id': $(this).val(),

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

        });
    });
</script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('#invoice_id,#status,#cust_id,#order_id').select2({
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
        frm.submit();
        frm.reset();
        $('#form-add select').val("#").trigger('change.select2');
        return false;
    };
</script>
@endsection