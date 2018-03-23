<?php

namespace App\Modules\Superuser\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Modules\Superuser\Http\Requests\StoreRole;
use App\Modules\Superuser\Http\Requests\StoreRolePermission;
use App\Http\Controllers\Controller;
use App\Modules\Superuser\Models\Role;
use App\Modules\Superuser\Models\Permission;
use App\Modules\Superuser\Models\RolePermission;

class RoleController extends Controller
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Role list Page View
     *
     * @return void
     */
    public function index()
    {
        return view('superuser::role.index');
    }

    /**
     * Create role page view
     *
     * @return void
     */
    public function create()
    {
        $permissionModels = Permission::all();
        return view('superuser::role.create', compact('permissionModels'));
    }

    /**
     * Store role page action
     *
     * @param StoreRole $request
     * @param StoreRolePermission $rpRequest
     * @return void
     */
    public function store(StoreRole $request, StoreRolePermission $rpRequest)
    {
        $defaultRoleName = uniqid(Role::DEFAULT_ROLE_PREFIX);
        
        if ($request->has('display_name')) {
            $defaultRoleName = \strpos(\trim($request->input('display_name')), ' ') 
                        ? \strtolower(\str_replace(' ', '_', \trim($request->input('display_name')))) 
                        : \strtolower(\trim($request->input('display_name')));
        }
        
        $roleName = \is_null($request->input('name', $defaultRoleName)) 
                    ? $defaultRoleName 
                    : $request->input('name', $defaultRoleName);
        
        // First store to the role model
        if (!$roleId = $request->input('role_id')) {
            $roleId = Role::create(
                [
                    'name' => $roleName,
                    'display_name' => $request->input('display_name'),
                    'description' => $request->input('description')
                ]
            )->id;
        } else {
            Role::where('id', $roleId)
                ->update(
                    [
                        'name' => $roleName,
                        'display_name' => $request->input('display_name'),
                        'description' => $request->input('description')
                    ]
                );
        }
        // $roleId = Role::update(
        //     [
        //         'id' => $request->input('role_id')
        //     ],
        //     [
        //         'name' => $roleName,
        //         'display_name' => $request->input('display_name'),
        //         'description' => $request->input('description')
        //     ]
        // )->id;
        
        // Then store the permissions to the rolePermission model
        // if create
        if (!$request->has('role_id')) {
            foreach ($rpRequest->input('permissions') as $permission) {
                RolePermission::create(
                    [
                        'permission_id' => $permission,
                        'role_id' => $roleId
                    ]
                );
            }

            return redirect()->route('addRole')->with('status', '添加成功');
        }
        
        // if update
        $rolePermissionModel = new RolePermission();
        $rolePermissionModel->updateRolePermissions(
            $rpRequest->input('role_id'), 
            $rpRequest->input('permissions')
        );
        
        return redirect()->route('editRole', ['id' => $roleId])->with('status', '编辑成功');
    }

    /**
     * Edit a specific role
     *
     * @return void
     */
    public function update($roleId)
    {
        $role = Role::find($roleId);
        $permission = Permission::all();

        $rolePermissions = RolePermission::where('role_id', $roleId)->get();
        $permissionIds = [];

        foreach ($rolePermissions as $rolePermission) {
            $permissionIds[] = $rolePermission->permission_id;
        }

        return view(
            'superuser::role.edit', 
            [
                'role' => $role, 
                'permissionModels' => $permission,
                'selectedPermissions' => $permissionIds
            ]
        );
    }

    /**
     * Ajax send the roles list
     *
     * @return json
     */
    public function ajaxData()
    {
        $role = new Role();

        return $role->getRolesList();
    }
}
