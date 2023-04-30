@extends('index')


@section('konten')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="form-add" method="post" role="form" id="form-print" action="grafik_packing" enctype="multipart/form-data" formtarget="_blank" target="_blank">
                                @csrf
                                <span id="peringatan"></span>
                                <div class="row">
                                    <div class="col-md-3">
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
                                    <div class="col-md-2">
                                        <div class="control-group">
                                            <label>Shift</label>
                                            <div class="controls">
                                                <select name="shift" id="shift" class="form-control select2">
                                                    <option value="#" selected="selected">Choose...</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
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
                                    <div class="col-md-4">
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
                                                <input onclick="reset_form('form-add')" class="btn btn-secondary btn-block" type="button" value="Rekap Grafik NG">
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
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Grafik Pareto NG By Part</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="form-rng" method="post" role="form" id="form-print" action="r_ng" enctype="multipart/form-data" formtarget="_blank" target="_blank">
                                @csrf
                                <span id="peringatan"></span>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="control-group">
                                            <label class="control-label">Customer</label>
                                            <div class="controls">
                                                <select name="cust_id" id="cust_id1" class="form-control select2">
                                                    <option value="#" selected="selected">Choose...</option>
                                                    @foreach($customers as $customers)
                                                    <option value="{{$customers->id}}">{{$customers->code}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="control-group">
                                            <label>Shift</label>
                                            <div class="controls">
                                                <select name="shift" id="shift1" class="form-control select2">
                                                    <option value="#" selected="selected">Choose...</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
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
                                                <input type="text" name="date" class="form-control float-right" id="reservation1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="control-group">
                                            <label class="control-label">Type NG</label>
                                            <div class="controls">
                                                <select name="typeNg" id="typeNg" class="form-control">
                                                    <option value="#" selected="selected">Choose...</option>
                                                    <option value="bintik_or_pin_hole">Bintik Or Pin Hole</option>
                                                    <option value="minyak_or_map">Minyak Or Map</option>
                                                    <option value="cotton">Cotton</option>
                                                    <option value="no_paint_or_tipis">No Paint Or Tipis</option>
                                                    <option value="scratch">Scratch</option>
                                                    <option value="air_pocket">Air Pocket</option>
                                                    <option value="kulit_jeruk">Kulit Jeruk</option>
                                                    <option value="kasar">Kasar</option>
                                                    <option value="karat">Karat</option>
                                                    <option value="water_over">Water Over</option>
                                                    <option value="minyak_kering">Minyak Kering</option>
                                                    <option value="dented">Dented</option>
                                                    <option value="keropos">Keropos</option>
                                                    <option value="nempel_jig">Nempel Jig</option>
                                                    <option value="lainnya">Lainnya</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="control-group">
                                            <div class="controls pt-2">
                                                <input onclick="reset_form('form-rng')" class="btn btn-secondary btn-block" type="button" value="Rekap Pareto NG By Part">
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
                    $.each(data, function(i) {
                        $('[name="order_id"]').append('<option value="' + data[i]
                            .id + '">' + data[i].no_po + '</option>');
                    })

                },
            });

        });
    });
</script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('[name="part_id"],#typeNg,#cust_id,#cust_id1,#shift,#shift1').select2({
            placeholder: "Choose..",
            theme: 'bootstrap4'
        })
        //Date picker
        $('#reservationdate,#reservationdate1').datetimepicker({
            format: 'DD/MM/YYYY'

        });
        $('#reservation,#reservation1').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            },
            function(start, end) {
                dateinn = start.format('YYYY-MM-DD');
                dateenn = end.format('YYYY-MM-DD');
            }
        )

        AutoNumeric.multiple('.autonumeric-integer', AutoNumeric.getPredefinedOptions().integerPos);
    })
    $(document).ready(function() {
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
    })

    function reset_form(form) {
        // $('#form-add input').val(null);
        var frm = document.getElementById(form);
        frm.submit();
        frm.reset();
        $('#' + form + ' select').val("#").trigger('change.select2');
        return false;
    };
</script>
@endsection