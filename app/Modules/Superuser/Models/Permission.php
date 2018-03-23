<?php

namespace App\Modules\Superuser\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Permission extends EntrustPermission implements Transformable
{
    use TransformableTrait;
    
    /**
     * Table Name
     *
     * @var string
     */
    protected $table = 'huge__permissions';

    /**
     * Accept two params
     *
     * @var array
     */
    protected $fillable = ['role_id', 'permission_id'];
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
