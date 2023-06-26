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
                            <form id="form-add" method="post" role="form" action="pettyCashReport" enctype="multipart/form-data" target="_blank">
                                @csrf
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
                                                <button id="in" onclick="reset_form()" type="button" class="form-control btn btn-secondary">Rekap</button>
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
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2({
            placeholder: "Choose..",
            theme: 'bootstrap4'
        })
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