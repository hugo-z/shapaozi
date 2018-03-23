<?php

namespace App\Modules\Superuser\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Superuser\Models\Zone;
use App\Modules\Superuser\Models\Location;
use App\Modules\Superuser\Models\Contest;
use App\Modules\Superuser\Models\ContestZone;
use App\Modules\Superuser\Models\ZoneLocation;
use Validator;

class ZoneController extends Controller
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Zone List Page
     *
     * @return void
     */
    public function index()
    {
        return view('superuser::people.zone.index');
    }

    /**
     * Zone create page
     *
     * @return void
     */
    public function create()
    {
        $countries = Location::where('level_type', 0)->get();

        $contests = Contest::all();
        
        return view('superuser::people.zone.create', compact('countries', 'contests'));
    }

    public function store($id = null)
    {
        $nameRequired = $id ? '' : 'unique:huge__zones';

        $validator = Validator::make(request()->all(), [
            'name'          => 'required|' . $nameRequired,
            'contest'       => 'required|integer',
            'country'       => 'required|integer',
            'divisionType'  => 'required',
            'provinces'     => 'sometimes|required|array',
            'cities'        => 'sometimes|required|array',
            'active'        => 'sometimes|required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        $zoneData = request()->all();

        $status = array_key_exists('active', $zoneData) ? $zoneData['active'] : 0;
        
        switch ($zoneData['divisionType']) {
            case 'province':
                $divisions = $zoneData['provinces'];
                break;
            case 'city':
                $divisions = $zoneData['cities']; 
                break;
        }

        if ($id) {
            Zone::updateOrCreate(
                [
                    'id'        => $id
                ],
                [
                    'name'      => $zoneData['name'],
                    'type'      => $zoneData['divisionType'],
                    'region_id' => $zoneData['country'],
                    'status'    => $status
                ]
            );
        } else {
            $id = Zone::create(
                [
                    'name'      => $zoneData['name'],
                    'type'      => $zoneData['divisionType'],
                    'region_id' => $zoneData['country'],
                    'status'    => $status
                ]
            )->id;
        }

        (new ZoneLocation)->modifyLocations($id, $divisions); 

        ContestZone::updateOrCreate(
            [
                'host_id' => $zoneData['contest']
            ],
            [
                'host_id' => $zoneData['contest'],
                'zone_id' => $id
            ]
        );

        return redirect()->route('editZone', ['id' => $id])
                            ->with(['status' => __('common.messages.zone.add_success', ['name' => $zoneData['name']])]);
    }

    /**
     * Zone edit function
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        $zone = Zone::find($id);
        $countries = Location::where('level_type', 0)->get();

        # Selected country
        $region = $zone->region;

        $provinces = Location::where('parent_id', $region->location_id)->get();

        $contests = Contest::all();

        # Selected contest
        $contestZone = ContestZone::where('zone_id', $id)->first();
        $selectedContest = $contestZone->contest;
        
        # Selected province and cities

        $zoneLocations = $zone->locations;
        
        foreach ($zoneLocations as $zoneLocation) {
            $selectedLocations[] = array_map(function($country) use($zoneLocation) {
                // $locations['zones'] = $zoneLocation->location;
                if ($country['location_id'] == $zoneLocation->location->parent_id) {
                    $locations['zones']['provinces'] = $zoneLocation->location;
                    $locations['type'] = 'province';
                } else {
                    $locations['zones']['provinces'] = $zoneLocation->location->belongsToLocation;
                    $locations['zones']['cities'] = $zoneLocation->location;
                    $locations['type'] = 'city';
                }
                return $locations;
            }, $countries->toArray()); 
        }

        $selectedRegions['provinces'] = array_map(function($location) {
            return $location[0]['zones']['provinces']->location_id;
        }, $selectedLocations);
        
        switch ($zone->type) {
            case 'city':
                # selected cities
                $selectedRegions['cities'] = array_map(function($location) {
                    return $location[0]['zones']['cities']->location_id;
                }, $selectedLocations);

                $selectedCity = Location::where('location_id', $selectedRegions['cities'][0])->first();
                $selectedProvince = $selectedCity->belongsToLocation;
                $cities = $selectedProvince->subsidiaries;
                break;
            default:
                
        }
    
        return view(
            'superuser::people.zone.create', 
            compact(
                'zone', 
                'countries', 
                'provinces',
                'cities',
                'contests',
                'selectedContest',
                'selectedRegions',
                'region'
            )
        );
    }

    /**
     * Get associated location subsidiaries
     *
     * @param Request $request
     * @return json
     */
    public function ajaxFetchLocations(Request $request)
    {

        $request->validate(['locationId' => 'required|size:6']);
        $zone = Location::where('location_id', $request->get('locationId'))->first();
        $data = [];

        switch ($zone->level_type) {
            case Zone::COUNTRY:
            case Zone::PROVINCE:
                $lvl_type = $zone->level_type;
                
                foreach ($zone->subsidiaries as $key => $location) {
                    $data[$key]['id'] = $location->location_id;
                    $data[$key]['text'] = $location->name . $location->pinyin;
                }
                break;
            default:
                $lvl_type = null;
                $multiple = '';
        }
        
        $json = response()->json(['lvl_type' => $lvl_type, 'array' => $data]);
        return $json;
    }

    /**
     * Zone list pager
     *
     * @return void
     */
    public function ajaxData()
    {
        return (new Zone)->zonesList();
    }

}
