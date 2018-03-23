<?php

namespace App\Modules\Superuser\Models;

// use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;
use Carbon\Carbon;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Role extends EntrustRole implements Transformable
{
    use TransformableTrait;
    /**
     * The default Role Prefix
     */
     const DEFAULT_ROLE_PREFIX = 'role_';

     /**
     * Table name
     *
     * @var string
     */
    // protected $table = 'huge__roles';

    /**
     * The fillable params
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'description'];

    /**
     * Returns an array of roles
     *
     * @return array
     */
    public function rolePermissions()
    {
        $roles = self::all();
        $rolePermission = new RolePermission();

        if (!$roles) return false;

        $rolesWithPermits = [];

        foreach ($roles as $roleKey => $role) {
            $rolesWithPermits[$roleKey]['id'] = $role->id;
            $rolesWithPermits[$roleKey]['display_name'] = $role->display_name;
            $rolesWithPermits[$roleKey]['created_at'] = $role->created_at->format('Y/m/d');
            $rolesWithPermits[$roleKey]['permissions'] = $rolePermission->roleHasPermissions($role->id);
        } 

        return $rolesWithPermits;
    }

    /**
     * Generates a set of data for the jquery dataTable
     *
     * @return json
     */
    public function getRolesList()
    {
        $rolesArray = $this->rolePermissions();
        
        $roleListArray = [];
        foreach ($rolesArray as $roleKey => $role) {
            $roleListArray[$roleKey][] = $role['id'];
            $roleListArray[$roleKey][] = $role['display_name'];
            $roleListArray[$roleKey][] = implode('<br />', $role['permissions']);
            $roleListArray[$roleKey][] = $role['created_at'];
            $roleListArray[$roleKey][] = 
                '<div class="row">' .
                '<a href="' . route('editRole', ['id' => $role['id']]) . 
                '" class="col-xs-6 glyphicon glyphicon-pencil">' . 
                // __('common.html.icons.add') .
                '</a>' .
                '<a href="" class="col-xs-6 glyphicon glyphicon-trash">' . 
                // __('common.html.icons.delete') .
                '</a>' . 
                '</div>';
        }

        return response()->json(['data' => $roleListArray]);
    }

}
