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
                            <h5>SISA SALDO KAS OPERASIONAL</h5>
                            <table>
                                <tr>
                                    <td>Bensin & Tol</td>
                                    <td>:</td>
                                    <td style="text-align:right">{{number_format($sisaBensinTol,0,'.','.')}}</td>
                                </tr>
                                <tr>
                                    <td>Petty Cash</td>
                                    <td>:</td>
                                    <td style="text-align:right">{{number_format($sisaPettyCash,0,'.','.')}}</td>
                                </tr>
                                <tr>
                                    <td>Uang Makan</td>
                                    <td>:</td>
                                    <td style="text-align:right">{{number_format($sisaUMakan,0,'.','.')}}</td>
                                </tr>
                                <tr>
                                    <td><br></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Total</td>
                                    <td>:</td>
                                    <td>{{number_format($totalSeluruh,0,'.','.')}}</td>
                                </tr>

                            </table>
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