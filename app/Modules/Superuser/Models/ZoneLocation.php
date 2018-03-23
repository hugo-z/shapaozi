<?php

namespace App\Modules\Superuser\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ZoneLocation extends Model implements Transformable
{
    use TransformableTrait;
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'huge__zone_location';

    /**
     * Primary key
     *
     * @var string
     */
    protected $primaryKey = 'zone_id';

    /**
     * No incrementing
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * No timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    protected $fillable = ['zone_id', 'location_id'];

    /**
     * Undocumented function
     *
     * @return void
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function modifyLocations($id, $locations)
    {
        # check if records exist
        $existedLocations = self::where('zone_id', $id)->get();
        
        if ($existedLocations->isNotEmpty()) {
            array_map(function ($location) use ($id, $existedLocations) {
                if (!$existedLocations->contains('location_id', $location)) {
                    self::create(
                        [
                            'zone_id'       => $id,
                            'location_id'   => $location
                        ]
                    );
                } 
            }, $locations);

            # delete locations
            $deletedLocations = $existedLocations->whereNotIn('location_id', $locations);
            
            if ($deletedLocations) {
                $deletedLocations->map(function($deletedLocation) {
                    self::where('location_id', $deletedLocation->location_id)
                            ->where('zone_id', $deletedLocation->zone_id)
                            ->delete();
                });
            }
        } else {
            # create new zone
            array_map(function ($location) use ($id) {
                self::create(
                    [
                        'zone_id'       => $id,
                        'location_id'   => $location
                    ]
                );
            }, $locations);
        }
    }

}
