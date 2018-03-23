<?php

namespace App\Modules\Superuser\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Contest extends Model implements Transformable
{
    use TransformableTrait;
    /**
     * Table Name
     *
     * @var string
     */
    protected $table = 'huge__contest';

    /**
     * Accept these data
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'status'];

    public function contestZones()
    {
        $this->hasMany(ContestZone::class);
    }
    
}
