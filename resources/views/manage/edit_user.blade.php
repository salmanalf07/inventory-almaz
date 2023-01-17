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
                            <form method="post" role="form" action="update/{{$user->id}}" enctype="multipart/form-data">
                                @csrf
                                <span id="peringatan"></span>
                                <input class="form-control" type="text" name="id" value="{{$user->id}}" hidden>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="control-group">
                                            <label class="control-label">Nama User</label>
                                            <div class="controls">
                                                <input class="form-control" type="text" name="name" id="name" value="{{$user->name}}" class="span15">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="control-group">
                                            <label class="control-label">Nomor Telpon</label>
                                            <div class="controls">
                                                <input class="form-control" type="text" name="phone" id="phone" value="{{$user->phone}}" class="span15">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="control-group">
                                            <label class="control-label">Username</label>
                                            <div class="controls">
                                                <input class="form-control" type="text" name="username" id="username" value="{{$user->username}}" class="span15">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="control-group">
                                            <label class="control-label">Password</label>
                                            <div class="controls">
                                                <input class="form-control" type="password" name="password" id="password" value="" class="span15">
                                                <button id="update_pass" type="button" class="btn btn-warning form-control">Update Password</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="control-group">
                                            <label class="control-label"></label>
                                            <div class="controls">
                                                <button id="in" type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
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
                                    <label class="control-label">Nama User</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Nomor Telpon</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="phone" id="phone" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Username</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" name="username" id="username" placeholder="Type something here..." class="span15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="control-label">Password</label>
                                    <div class="controls">
                                        <input class="form-control" type="password" name="password" id="password" placeholder="Type something here..." class="span15">
                                        <button id="update_pass" type="button" class="btn btn-warning form-control">Update Password</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Hak Akses</label>
                            <div class="controls">
                                <select name="role" id="role" class="form-control">
                                    <option selected>Choose...</option>
                                    <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                                    <option value="ADMIN">ADMIN</option>
                                </select>
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
</div>
<!-- jQuery -->
<script src="assets/css/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#update_pass').show();
        $('#password').hide();
    });
    $(document).on('click', '#update_pass', function() {
        $('#update_pass').hide();
        $('#password').show();
    });
</script>

@endsection