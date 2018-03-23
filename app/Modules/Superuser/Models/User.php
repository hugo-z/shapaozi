<?php

namespace App\Modules\Superuser\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthUser;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;


class User extends Model implements Transformable
{
    use EntrustUserTrait;
    use TransformableTrait;
    
    /**
     * User table name
     *
     * @var string
     */
    protected $table = 'huge__admin';

    /**
     * Accept these
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'cell', 
        'password', 
        'country', 
        'province', 
        'city', 
        'district', 
        'division',
        'suspended'
    ];

    /**
     * Returns the user info
     *
     * @param int $userId
     * @return void
     */
    public function user($userId)
    {
        $userData = self::find($userId);

        return $userData;
    }

    /**
     * Returns the collection of roles of user
     *
     * @param int $userId
     * @return void
     */
    public function hasRoles($userId)
    {
        $userRoleCollections = UserRoles::where('user_id', $userId)->get();

        $selectedRoles = [];

        foreach ($userRoleCollections as $userRoleCollection) {
            $selectedRoles[] = $userRoleCollection->role_id;
        }
        
        return $selectedRoles;
    }

    /**
     * Generates list for dataTable
     *
     * @return void
     */
    public function usersToArray()
    {        
        $users = self::all(['id', 'name', 'email', 'cell', 'suspended', 'created_at'])->toArray();

        $data = array_map(function ($user) {
            if (!array_key_exists('operation', $user)) {
                $user['operation'] = 
                '<div class="row">' .
                '<a href="' . route('editUser', ['id' => $user['id']]) . 
                '" class="col-xs-6 glyphicon glyphicon-pencil">' . 
                // __('common.html.button.edit') . 
                '</a>' .
                '<a href="" class="col-xs-6 glyphicon glyphicon-trash">' . 
                // __('common.html.button.delete') . 
                '</a>' . 
                '</div>';
            }
            $user['suspended'] = 
                $user['suspended'] == 1 ? 
                __('superuser::user.html.text.invalid') : 
                __('superuser::user.html.text.valid');
            return array_values($user);
        }, $users);

        return response()->json(['data' => $data]);
    }

    
}
