@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Roles<button type="button" class="btn btn-primary btn-sm float-right"
                            data-toggle="modal" data-target="#mdl-addrole">
                            Add Role
                        </button></div>

                    <div class="card-body">
                        <table class="table" id="tbl-role">
                            <tr>
                                <td>Role</td>
                                <td>Permissions</td>
                                <td>Action</td>
                            </tr>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @foreach ($role->permissions as $permission)
                                            <button class="btn">
                                                <span class="badge badge-primary">{{ $permission->name }}</span>
                                            </button>
                                        @endforeach
                                    </td>
                                    <td><button type="button" class="btn btn-primary btn-sm" data-name="{{ $role->name }}"
                                            data-id="{{ $role->id }}" data-toggle="modal"
                                            data-target="#mdl-assignpermission">
                                            Assign Permission
                                        </button></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            @can('delete todolist')
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Permissions<button type="button" class="btn btn-primary btn-sm float-right"
                                data-toggle="modal" data-target="#mdl-addpermission">
                                Add Permission
                            </button></div>

                        <div class="card-body">
                            <table class="table" id="tbl-permission">
                                <tr>
                                    <td>Permission</td>
                                    <td>Action</td>
                                </tr>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->name }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            @endcan
            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header">Users</div>

                    <div class="card-body">
                        <table class="table" id="tblUsers">
                            <thead>
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Email Address
                                    </th>
                                    <th>
                                        Roles/Permissions
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (cache('usersFC') as $user)
                                    <tr>
                                        <td>
                                            {{ $user->name }}
                                        </td>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                <span class="badge badge-primary">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="dropdown open">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    Assign Role
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                                    @foreach ($roles as $role)
                                                        <button class="dropdown-item assignroletouser-btn"
                                                            data-roleid="{{ $role->id }}"
                                                            data-userid="{{ $user->id }}">{{ $role->name }}</button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="mdl-assignpermission" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Permisson To <span id="rolename"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="role_id-hdn" id="role_id-hdn" class="form-control" value="">

                    <div class="form-group">
                        <label for="rolepermissions">Permission</label>
                        <select class="form-control" name="rolepermissions" id="rolepermissions">
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-primary float-right" id="btn-assignpermission">Save</button>

                        <div id="addedPermission">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="mdl-addpermission" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="permission">Permission</label>
                        <input type="text" class="form-control" name="permission" id="permission"
                            aria-describedby="helpId" placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button data-dismiss="modal" id="btnAddPermission" type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="mdl-addrole" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmAddRole">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <input type="text" class="form-control" name="role" id="role" aria-describedby="help-role"
                                placeholder="">
                            <small id="help-role" class="form-text text-muted">Please enter role name</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="btnAddRole" type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#tblUsers').DataTable();
        $('#btnAddRole').click(function(e) {
            $.ajax({
                type: "post",
                url: "{{ route('user.storeRole') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    role: $('#role').val()
                },
                dataType: "json",
                success: function(response) {
                    $('#mdl-addrole').modal('toggle');
                    $('#tbl-role').append(
                        '<tr>' +
                        '<td>' + $('#role').val() + '</td>' +
                        '<td></td>' +
                        '<td>Action</td>' +
                        '</tr>'
                    );

                }
            });
        });

        $('#btnAddPermission').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "{{ route('user.storePermission') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    permission: $('#permission').val()
                },
                dataType: "json",
                success: function(response) {
                    $('#mdl-addpermission').modal('hide');
                    $('#tbl-permission').append(
                        '<tr>' +
                        '<td>' + $('#permission').val() + '</td>' +
                        '<td>Action</td>' +
                        '</tr>'
                    );
                }
            });
        });

        $('#mdl-assignpermission').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var name = button.data('name');
            var id = button.data('id');
            $('#role_id-hdn').val(id);
            $('#rolename').text(name);
            $.ajax({
                type: "post",
                url: "{{ route('user.getRolePermissions') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    addPermissionsBadge(response.permissions);
                }
            });
        });

        $('#btn-assignpermission').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "{{ route('user.roleassignpermission') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    role: $('#role_id-hdn').val(),
                    permission: $('#rolepermissions').val()
                },
                dataType: "json",
                success: function(response) {
                    addPermissionsBadge(response.permissions);
                }
            });
        });

        $('.assignroletouser-btn').click(function(e) {
            e.preventDefault();
            var userid = $(this).attr('data-userid');
            var roleid = $(this).attr('data-roleid');

            $.ajax({
                type: "post",
                url: "{{ route('user.userassignrole') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    userid: userid,
                    roleid: roleid,
                },
                dataType: "json",
                success: function(response) {

                }
            });
        });

        function addPermissionsBadge(permissions) {
            $('#addedPermission').empty();
            $.each(permissions, function(indexInArray, permission) {
                $('#addedPermission').append(
                    '<button class="btn"><span class="badge badge-primary">' + permission.name + '</span>' +
                    '</button>'
                );
            });
        }
    </script>
@endsection
