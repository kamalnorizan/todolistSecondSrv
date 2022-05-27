<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables;
use Cache;
class UserController extends Controller
{
    //Auth::user()->getPermissionNames(); -- Semua permission untuk user (String)
    //Auth::user()->getDirectPermission(); -- Semua direct permission untuk user
    //Auth::user()->getPermissionViaRoles(); -- permission untuk user via roles
    //Auth::user()->getAllPermissions(); -- Semua permission untuk user (Collection)

    // Auth::user()->getRoleNames() Collection of roles
    // User::role('Admin')->get();
    // User::doesntHave('roles')->get();
    // User::permission('edit todolist')->get();

    public function index()
    {

        // $users = User::all();
        // dd($users);
        // Cache::put('usersFC',$users,6000);

        $roles = Role::all();
        $permissions = Permission::all();
        return view('user.index',compact('roles','permissions'));
    }

    public function loadFromCache()
    {
        foreach (Cache::get('usersFC') as $key => $value) {
            echo '-'.$value->name.'<br>';
        }
    }

    public function index2()
    {
        // $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('user.index2',compact('roles','permissions'));
    }

    public function ajaxLoadUserTable(Request $request)
    {
        $users=User::select('*');



        $roles = Role::all();
        $permissions = Permission::all();
        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('rolespermission', function(User $user){
                $badges='';
                foreach ($user->roles as $key => $role) {
                    $badges.= '<button data-userid="'.$user->id.'" data-rpid="'.$role->id.'" data-type="role" class="badge badge-primary removeRolePermisson"> '.$role->name.' </button> ';
                }

                foreach ($user->permissions as $key => $permission) {
                    $badges.= '<button data-userid="'.$user->id.'" data-rpid="'.$permission->id.'" data-type="permission" class="badge badge-warning removeRolePermisson"> '.$permission->name.' </button> ';
                }

                return $badges;
            })
            ->addColumn('action', function(User $user) use ($roles, $permissions){
                $buttons='';
                foreach ($roles as $role){
                    $buttons=$buttons.'<button class="dropdown-item assignroletouser-btn" data-roleid="'.$role->id.'" data-userid="'.$user->id.'">'.$role->name.'</button>';
                }
                $dropdown = '<div class="dropdown open">';
                $dropdown .=     '<button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Assign Role</button>';
                $dropdown .=   '<div class="dropdown-menu" aria-labelledby="triggerId">';
                $dropdown .= $buttons;
                $dropdown .=     '</div>';
                $dropdown .= '</div>';

                $permissionBtn ='';
                foreach ($permissions as $permission){
                    $permissionBtn=$permissionBtn.'<button class="dropdown-item assignpermissiontouser-btn" data-permissionid="'.$permission->id.'" data-userid="'.$user->id.'">'.$permission->name.'</button>';
                }
                $permissiondropdown = '<div class="dropdown open">';
                $permissiondropdown .=     '<button class="btn btn-primary dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Assign Permission</button>';
                $permissiondropdown .=   '<div class="dropdown-menu" aria-labelledby="triggerId">';
                $permissiondropdown .= $permissionBtn;
                $permissiondropdown .=     '</div>';
                $permissiondropdown .= '</div>';

                $allbuttons = $dropdown .' '.$permissiondropdown;
                return $allbuttons;
            })
            ->rawColumns(['rolespermission','action'])
            ->make(true);
    }

    public function storeRole(Request $request)
    {
        $role = new Role;
        $role->name = $request->role;
        $role->save();

        return response()->json(['status'=>'success']);
    }

    public function storePermission(Request $request)
    {
        $permission = new Permission;
        $permission->name = $request->permission;
        $permission->save();

        return response()->json(['status'=>'success']);
    }

    public function getRolePermissions(Request $request)
    {
        $role = Role::find($request->id);
        $permissions = $role->permissions;

        $data['permissions']=$permissions;

        return response()->json($data);
    }

    public function roleassignpermission(Request $request)
    {
        $role = Role::find($request->role);
        $role->givePermissionTo($request->permission);
        $data['permissions'] = $role->permissions;
        return response()->json($data);
    }

    public function userassignrole(Request $request)
    {
        $user = User::find($request->userid);
        $role = Role::find($request->roleid);
        $user->assignRole($role);

        return response()->json(['status'=>'success']);
    }

    public function userassignpermission(Request $request)
    {
        $user = User::find($request->userid);
        $permission = Permission::find($request->permissionid);
        $user->givePermissionTo($permission);

        return response()->json(['status'=>'success']);
    }

    public function removeuserrolepermission(Request $request)
    {
        $user = User::find($request->userid);
        if($request->type=='role'){
            $role = Role::find($request->rpid);
            $user->removeRole($role);
        }else{
            $permission = Permission::find($request->rpid);
            $user->revokePermissionTo($permission);
        }

        return response()->json(['status'=>'success']);

    }
}
