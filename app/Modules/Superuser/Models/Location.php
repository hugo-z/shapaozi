<?php

namespace App\Modules\Superuser\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Location extends Model implements Transformable
{
    use TransformableTrait;
    
    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'huge__locations';

    /**
     * Set the customized primary key
     *
     * @var boolean
     */
    protected $primaryKey = 'location_id';

    /**
     * Do not increment
     *
     * @var boolean
     */
    public $incrementing = false;
    /**
     * Don't need timestamp stored
     *
     * @var boolean
     */
    public $timestamp = false;

    /**
     * Accept these
     *
     * @var array
     */
    protected $fillable = [
        'locationId'
    ];

    /**
     * Get the subordinates of a specified location
     *
     * @return void
     */
    public function subsidiaries()
    {
        return $this->hasMany(Location::class, 'parent_id', 'location_id');
    }

    /**
     * Get the parent for the specified location
     *
     * @return void
     */
    public function belongsToLocation()
    {
        return $this->belongsTo(Location::class, 'parent_id', 'location_id');
    }
}
