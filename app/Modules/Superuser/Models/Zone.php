<?php

namespace App\Modules\Superuser\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Zone extends Model implements Transformable
{
    use TransformableTrait;
    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'huge__zones';

    /**
     * The zone location table name
     */
    const ZONE_LOCATION_TBL = 'huge__zone_location';

    /**
     * The location table name
     */
    const LOCATION_TBL      = 'huge__locations';

    /**
     * No timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The level type of country
     */
    const COUNTRY = 0;
    
    /**
     * The level type of province
     */
    const PROVINCE = 1;

    /**
     * The level type of city
     */
    const CITY     = 2;

    /**
     * The level type of district
     */
    const DISTRICT = 3;

    /**
     * Accept these data
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'location_id',
        'type',
        'region_id',
        'status'
    ];

    /**
     * Get the subordinates of a specified location
     *
     * @return void
     */
    public function contestants()
    {
        return $this->hasMany(Contestant::class, 'zone', 'location_id');
    }

    /**
     * Locations belong to certain reagion
     *
     * @return object
     */
    public function region()
    {
        return $this->belongsTo(Location::class, 'region_id', 'location_id');
    }

    /**
     * Locations belongs to certain zone
     *
     * @return void
     */
    public function locations()
    {
        return $this->hasMany(ZoneLocation::class, 'zone_id', 'id');
    }

    /**
     * Generates a json formatted data for the jquery DataTable
     *
     * @return json
     */
    public function zonesList()
    {      
        $zones = self::all(['id', 'name', 'type', 'status'])->toArray();

        $zones = array_map(function($zone) {
            $zoneLocInfo = [];

            # ZoneLocation
            $zoneLocations = ZoneLocation::where('zone_id', $zone['id'])
                                        ->select('location_id')
                                        ->get()
                                        ->toArray();

            $locations = array_map(function($zoneLocation) use($zone) {
                $relatedLocations = Location::where('location_id', $zoneLocation)
                                            ->select('name', 'pinyin')
                                            ->first()
                                            ->toArray();
                return '<span class="label label-info">' . $relatedLocations['name'] . $relatedLocations['pinyin'] . '</span>';
            }, $zoneLocations);

            $zoneLocInfo['id']          = $zone['id'];
            $zoneLocInfo['name']        = $zone['name'];
            $zoneLocInfo['type']        = 
                $zone['type'] == 'province' ? 
                '<span class="label label-primary">' . __('superuser::zone.html.text.province_type') . '</span>' : 
                '<span class="label label-success">' . __('superuser::zone.html.text.city_type') . '</span>';
            $zoneLocInfo[$zone['id']]   = $locations;
            $zoneLocInfo['status']      = $zone['status'] ? 
                '<span class="label label-primary">' . __('common.html.status.active') . '</span>' : 
                '<span class="label label-danger">' . __('common.html.status.inactive') . '</span>';
            # Action Buttons
            $zoneLocInfo['action']      = 
                '<div class="row">' .
                '<a href="' . route('editZone', ['id' => $zone['id']]) . 
                '" class="col-xs-6 glyphicon glyphicon-pencil">' . 
                // __('common.html.button.edit') . 
                '</a>' .
                '<a href="" class="col-xs-6 glyphicon glyphicon-trash">' . 
                // __('common.html.button.delete') . 
                '</a>' . 
                '</div>';
            return array_values($zoneLocInfo);
        }, $zones);

        // return $zones;
        return response()->json(['data' => $zones]);
    }
}
