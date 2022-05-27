@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @role('Admin|Moderator')
                    <h2>Role admin</h2>
                @endrole

                @role('Writer')
                    <h2>Role admin</h2>
                @endrole

                Paparan untuk semua

                @hasanyrole('Writer|Moderator')
                    <h2>Role Writer | Moderator</h2>
                @endhasanyrole

                @hasallroles('Writer|Moderator')
                    <h2>Role Writer & Moderator</h2>
                @endhasallroles

                @unlessrole('Admin')
                    <h2>Tiada Role Admin</h2>
                @endunlessrole

                @hasexactroles('Admin|Moderator')
                    <h2>Wajib Admin & Moderator sahaja</h2>
                @endhasexactroles

            </div>
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



            @cannot('delete todolist')
            <h3>Test</h3>
            @endcannot

            @canany(['delete todolist','delete task'])
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
          var userTbl = $('#tblUsers').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
              "type": "post",
              "url": "{{ route('user.ajaxLoadUserTable') }}",
              "dataType": "json",
              "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
              { "data": "name" },
              { "data": "email" },
              { "data": "rolespermission" },
              { "data": "action" }
            ]
        });
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

        $(document).on('click','.assignroletouser-btn',function(e) {
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
                    userTbl.ajax.reload(null,false);
                }
            });
        });
        $(document).on('click','.assignpermissiontouser-btn',function(e) {
            e.preventDefault();
            var userid = $(this).attr('data-userid');
            var permissionid = $(this).attr('data-permissionid');

            $.ajax({
                type: "post",
                url: "{{ route('user.userassignpermission') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    userid: userid,
                    permissionid: permissionid,
                },
                dataType: "json",
                success: function(response) {
                    userTbl.ajax.reload(null,false);
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

        $(document).on('click','.removeRolePermisson',function(e){
            var userid=$(this).attr('data-userid');
            var rpid=$(this).attr('data-rpid');
            var type=$(this).attr('data-type');

            swal({
                title: "Are you sure?",
                text: "You are going to remoce this user role/permission!",
                icon: "warning",
                buttons: {cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "Yes, i'm sure!",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: true
                }}
            }).then((value)=>{

                if(value==true){
                    $.ajax({
                        type: "post",
                        url: "{{route('user.removeuserrolepermission')}}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            userid: userid,
                            rpid: rpid,
                            type: type
                        },
                        dataType: "json",
                        success: function (response) {
                            userTbl.ajax.reload(null,false);
                        }
                    });
                }
            });

        });
    </script>
@endsection
