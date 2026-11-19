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
                            <div class="matrix-toolbar">
                                <div>
                                    <h5 class="role-section-title">Hak akses per modul</h5>
                                    <p class="role-section-hint">Centang izin yang diberikan kepada setiap role.</p>
                                </div>
                                <div class="matrix-actions">
                                    <input type="search" class="form-control access-search" id="permSearch" placeholder="Cari permission..." aria-label="Cari permission">
                                    <button type="button" class="btn btn-outline-secondary" id="openAddRole">Tambah role</button>
                                    <button type="button" class="btn btn-primary" id="openPermissionModal">Tambah permission</button>
                                </div>
                            </div>
                            <div id="matrixMessage" class="matrix-message" role="status" aria-live="polite"></div>
                            <div class="table-responsive matrix-scroll">
                                <table class="table table-bordered permission-matrix">
                                    <thead>
                                        <tr>
                                            <th class="matrix-permission-heading" scope="col">Permission</th>
                                            @forelse($roles as $role)
                                            <th class="matrix-role-heading" scope="col"><span>{{ $role->name }}</span></th>
                                            @empty
                                            <th class="matrix-role-heading" scope="col">Belum ada role</th>
                                            @endforelse
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($permissions as $groupName => $groupPermissions)
                                        <tr class="matrix-module-row"><th colspan="{{ max(1, $roles->count() + 1) }}">{{ $groupName }}</th></tr>
                                        @foreach($groupPermissions as $permission)
                                        <tr class="matrix-permission-row" data-permission="{{ strtolower($permission->name.' '.$permission->slug.' '.$groupName) }}">
                                            <th scope="row"><span class="permission-name">{{ $permission->name }}</span><small>{{ $permission->slug }}</small></th>
                                            @foreach($roles as $role)
                                            @php
                                                $checked = isset($rolePermissionIds[$role->id][(int) $permission->id]);
                                            @endphp
                                            @if($loop->parent->first && $loop->first)
                                                <!-- DEBUG: {{ json_encode($rolePermissionIds) }} -->
                                            @endif
                                            <td class="matrix-checkbox-cell"><input class="matrix-check" type="checkbox" data-role-id="{{ $role->id }}" data-permission-id="{{ $permission->id }}" aria-label="{{ $permission->name }} untuk {{ $role->name }}" {{ $checked ? 'checked' : '' }} data-debug-checked="{{ $checked ? 'true' : 'false' }}"></td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                        @empty
                                        <tr><td colspan="{{ max(1, $roles->count() + 1) }}" class="matrix-empty">Belum ada permission. Pilih Tambah permission untuk membuatnya.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Daftar role</h3></div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped" id="rolesTable">
                                <thead><tr><th>Role</th><th>Slug</th><th>Deskripsi</th><th>Aksi</th></tr></thead>
                                <tbody>
                                    @forelse($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->slug }}</td>
                                        <td>{{ $role->description }}</td>
                                        <td>
                                            <button type="button" class="edit-role btn btn-sm btn-outline-primary" data-id="{{ $role->id }}">Ubah</button>
                                            <button type="button" class="delete-role btn btn-sm btn-outline-danger" data-id="{{ $role->id }}">Hapus</button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-muted">Belum ada role. Pilih Tambah role untuk membuat role pertama.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="roleModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="roleModalLabel">Tambah Role</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form-role">
                        @csrf
                        <input type="hidden" name="id" id="role_id">
                        <div class="form-group">
                            <label for="role_name">Nama role</label>
                            <input class="form-control" type="text" name="name" id="role_name" required maxlength="255">
                        </div>
                        <div class="form-group">
                            <label for="role_slug">Slug</label>
                            <input class="form-control" type="text" name="slug" id="role_slug" required maxlength="255">
                        </div>
                        <div class="form-group">
                            <label for="role_desc">Deskripsi</label>
                            <input class="form-control" type="text" name="description" id="role_desc">
                        </div>
                    </form>
                    <div id="roleFormMessage" class="text-danger" role="alert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button id="saveRole" type="button" class="btn btn-primary">Simpan role</button>
                </div>
            </div>
        </div>
    </div>

    <div id="permissionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="permissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="permissionModalLabel">Tambah permission</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form-permission">
                        @csrf
                        <div class="form-group">
                            <label for="permission_name">Nama permission</label>
                            <input class="form-control" type="text" id="permission_name" name="name" required maxlength="255" placeholder="Contoh: View Parts">
                        </div>
                        <div class="form-group">
                            <label for="permission_slug">Slug</label>
                            <input class="form-control" type="text" id="permission_slug" name="slug" required maxlength="255" placeholder="Contoh: view_parts">
                        </div>
                        <div class="form-group">
                            <label for="permission_group">Modul</label>
                            <input class="form-control" type="text" id="permission_group" name="group" required maxlength="255" placeholder="Contoh: Part">
                        </div>
                        <div class="form-group">
                            <label for="permission_description">Deskripsi</label>
                            <input class="form-control" type="text" id="permission_description" name="description">
                        </div>
                        <fieldset class="form-group">
                            <legend class="col-form-label">Berikan ke role</legend>
                            @forelse($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="new_permission_role_{{ $role->id }}">
                                <label class="form-check-label" for="new_permission_role_{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                            @empty
                            <p class="text-muted">Buat role terlebih dahulu untuk memberi akses.</p>
                            @endforelse
                        </fieldset>
                    </form>
                    <div id="permissionFormMessage" class="text-danger" role="alert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" id="savePermission" class="btn btn-primary">Simpan permission</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('page-scripts')
<script>
    $(function () {
        var csrf = $('meta[name="csrf-token"]').attr('content');

        function showMessage(text, isError) {
            $('#matrixMessage').text(text).toggleClass('text-danger', !!isError).toggleClass('text-success', !isError);
        }

        function requestError(xhr) {
            var errors = xhr.responseJSON && xhr.responseJSON.errors;
            if (errors) return Object.keys(errors).map(function (key) { return errors[key][0]; }).join(' ');
            return (xhr.responseJSON && xhr.responseJSON.message) || 'Permintaan gagal. Coba lagi.';
        }

        $('#permSearch').on('input', function () {
            var query = $.trim($(this).val().toLowerCase());
            $('.matrix-permission-row').each(function () {
                $(this).toggle($(this).data('permission').indexOf(query) !== -1);
            });
            $('.matrix-module-row').each(function () {
                var nextRows = $(this).nextUntil('.matrix-module-row', '.matrix-permission-row');
                $(this).toggle(!query || nextRows.filter(':visible').length > 0);
            });
        });

        $(document).on('change', '.matrix-check', function () {
            var checkbox = $(this);
            var previousState = !checkbox.prop('checked');
            checkbox.prop('disabled', true);
            showMessage('Menyimpan perubahan...', false);
            $.ajax({
                type: 'POST',
                url: "{{ url('toggle_role_permission') }}",
                data: {_token: csrf, role_id: checkbox.data('role-id'), permission_id: checkbox.data('permission-id'), enabled: checkbox.prop('checked') ? 1 : 0}
            }).done(function () {
                showMessage('Perubahan permission tersimpan.', false);
            }).fail(function (xhr) {
                checkbox.prop('checked', previousState);
                showMessage(requestError(xhr), true);
            }).always(function () {
                checkbox.prop('disabled', false);
            });
        });

        $('#openAddRole').on('click', function () {
            $('#form-role')[0].reset();
            $('#role_id').val('');
            $('#roleFormMessage').text('');
            $('#roleModalLabel').text('Tambah role');
            $('#saveRole').text('Simpan role');
            $('#roleModal').modal('show');
        });

        $('#saveRole').on('click', function () {
            var form = $('#form-role')[0];
            if (!form.reportValidity()) return;
            var roleId = $('#role_id').val();
            var button = $(this).prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: roleId ? "{{ url('update_role') }}/" + roleId : "{{ url('store_role') }}",
                data: $(form).serialize()
            }).done(function () {
                window.location.reload();
            }).fail(function (xhr) {
                $('#roleFormMessage').text(requestError(xhr));
            }).always(function () {
                button.prop('disabled', false);
            });
        });

        $(document).on('click', '#rolesTable .edit-role', function () {
            $.ajax({
                type: 'POST', url: "{{ url('edit_role') }}",
                data: {_token: csrf, id: $(this).data('id')}
            }).done(function (role) {
                $('#role_id').val(role.id);
                $('#role_name').val(role.name);
                $('#role_slug').val(role.slug);
                $('#role_desc').val(role.description);
                $('#roleFormMessage').text('');
                $('#roleModalLabel').text('Ubah role');
                $('#saveRole').text('Simpan perubahan');
                $('#roleModal').modal('show');
            }).fail(function (xhr) { showMessage(requestError(xhr), true); });
        });

        $(document).on('click', '#rolesTable .delete-role', function () {
            if (!window.confirm('Hapus role ini?')) return;
            $.ajax({
                type: 'DELETE', url: "{{ url('delete_role') }}/" + $(this).data('id'),
                data: {_token: csrf}
            }).done(function () { window.location.reload(); })
              .fail(function (xhr) { showMessage(requestError(xhr), true); });
        });

        $('#openPermissionModal').on('click', function () {
            $('#form-permission')[0].reset();
            $('#permissionFormMessage').text('');
            $('#permissionModal').modal('show');
        });

        $('#savePermission').on('click', function () {
            var form = $('#form-permission')[0];
            if (!form.reportValidity()) return;
            var button = $(this).prop('disabled', true);
            $.ajax({type: 'POST', url: "{{ url('store_permission') }}", data: $(form).serialize()})
                .done(function () { window.location.reload(); })
                .fail(function (xhr) { $('#permissionFormMessage').text(requestError(xhr)); })
                .always(function () { button.prop('disabled', false); });
        });
    });
</script>
@endpush

<style>
    .matrix-toolbar,
    .matrix-actions { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .matrix-toolbar { flex-wrap: wrap; margin-bottom: 1rem; }
    .matrix-actions { flex-wrap: wrap; }
    .matrix-actions .access-search { width: min(280px, 100%); }
    .role-section-title { margin: 0 0 .35rem; font-weight: 600; color: #243342; }
    .role-section-hint { margin: 0; color: #4b5866; }
    .matrix-scroll { max-height: 68vh; overflow: auto; border: 1px solid #cbd2d9; }
    .permission-matrix { min-width: max-content; margin: 0; border-color: #cbd2d9; }
    .permission-matrix th, .permission-matrix td { padding: .65rem .8rem; vertical-align: middle; }
    .permission-matrix thead th { position: sticky; top: 0; z-index: 2; background: #f0f3f5; color: #263645; }
    .permission-matrix .matrix-permission-heading { min-width: 260px; position: sticky; left: 0; z-index: 3; }
    .permission-matrix .matrix-role-heading { min-width: 125px; text-align: center; }
    .matrix-role-heading span { display: block; max-width: 150px; overflow-wrap: anywhere; }
    .matrix-module-row th { position: sticky; left: 0; background: #e8edf0; color: #263645; font-weight: 700; }
    .matrix-permission-row th { position: sticky; left: 0; z-index: 1; background: #fff; font-weight: 500; }
    .permission-name { display: block; }
    .permission-matrix th small { display: block; margin-top: .15rem; color: #4b5866; font-size: .78rem; font-weight: 400; }
    .matrix-checkbox-cell { min-width: 90px; text-align: center; }
    .matrix-check { width: 20px; height: 20px; accent-color: #256b59; cursor: pointer; vertical-align: middle; }
    .matrix-check:focus-visible, .matrix-actions button:focus-visible, .matrix-actions input:focus-visible, #rolesTable button:focus-visible { outline: 3px solid #1c5e85; outline-offset: 2px; }
    .matrix-empty { padding: 1.5rem !important; text-align: center; color: #3b4855; }
    .matrix-message { min-height: 1.5rem; margin-bottom: .5rem; }
    #rolesTable { min-width: 600px; }
    @media (max-width: 767.98px) {
        .matrix-actions { width: 100%; align-items: stretch; }
        .matrix-actions .access-search { width: 100%; }
        .matrix-actions button { min-height: 44px; flex: 1 1 auto; }
        .permission-matrix .matrix-permission-heading { min-width: 190px; }
        .matrix-scroll { max-height: 60vh; }
    }
</style>

@endsection
