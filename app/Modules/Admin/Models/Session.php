<?php

namespace App\Modules\Admin\Models;

use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Contracts\Auth\Authenticatable;

class Session extends AuthUser
{
    use EntrustUserTrait;

    /**
     * Table Name
     *
     * @var string
     */
    protected $table = 'huge__admin';

    /**
     * Accepted fields
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'cell', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function createRoles()
    {
        $owner = new Role();
        $owner->name         = 'owner';
        $owner->display_name = 'Project Owner'; // optional
        $owner->description  = 'User is the owner of a given project'; // optional
        $owner->save();
        
        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'User Administrator'; // optional
        $admin->description  = 'User is allowed to manage and edit other users'; // optional
        $admin->save();
    }

    // public function hasRole($role)
    // {
    //     $user = auth()->user()->hasRole($role);
    // }
}
