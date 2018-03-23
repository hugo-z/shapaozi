<?php

namespace App\Modules\Superuser\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ContestZone extends Model implements Transformable
{
    use TransformableTrait;
    
    /**
     * Table Name
     *
     * @var string
     */
    protected $table = 'huge__host_zone';

    /**
     * No timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Primary Key
     *
     * @var string
     */
    protected $primaryKey = 'host_id';

    /**
     * No increment
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Accept these data
     *
     * @var array
     */
    protected $fillable = ['host_id', 'zone_id'];

    /**
     * Returns associated contest object
     *
     * @return void
     */
    public function contest()
    {
        return $this->hasOne(Contest::class, 'id');
    }
    public function getContest($zoneId)
    {
        $contest = Zone::where();
    }
}
