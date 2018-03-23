<?php

namespace App\Modules\Superuser\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class RolePermission extends Model implements Transformable
{
    use TransformableTrait;
    
    /**
     * Customized table name
     *
     * @var string
     */
    protected $table = 'huge__permission_role';

    /**
     * No incrementing id
     *
     * @var boolean
     */
    public $incrementing = false;

    protected $primaryKey = 'permission_id';


    /**
     * Acceptable params
     *
     * @var array
     */
    protected $fillable = ['role_id', 'permission_id'];

    /**
     * Do not store timestamps
     *
     * @var boolean
     * 
     */
    public $timestamps = false;

    /**
     * Undocumented function
     *
     * @param [type] $roleId
     * 
     * @return array
     */
    public function roleHasPermissions($roleId) 
    {
        $permissionIds = self::where('role_id', $roleId)->get();

        $permissions = [];
        foreach ($permissionIds as $permitKey => $permissionId) {
            $permissionIdAsKey = Permission::find($permissionId->permission_id)->id;
            $permissions[$permissionIdAsKey] = Permission::find($permissionId->permission_id)->display_name;
        }

        return $permissions;
    }

    /**
     * Update role permissions
     *
     * @param integer $roleId
     * @param array $rolePermissions
     * @return void
     */
    public function updateRolePermissions($roleId, array $rolePermissions)
    {
        $rolePermissionsExisted = $this->roleHasPermissions($roleId);
        
        foreach ($rolePermissions as $rolePermit) {
            if (!array_key_exists($rolePermit, $rolePermissionsExisted)) {
                self::create(
                    [
                        'role_id' => $roleId,
                        'permission_id' => $rolePermit
                    ]
                );
            } 
        }

        $rolePermissionsUpdated = $this->roleHasPermissions($roleId);

        foreach ($rolePermissionsUpdated as $permitId => $rolePermitUpdated) {
            if (!in_array($permitId, $rolePermissions)) {
                self::where('permission_id', $permitId)
                    ->delete();
            }
        }
    }
}
