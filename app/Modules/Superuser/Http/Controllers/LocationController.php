<?php

namespace App\Modules\Superuser\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Superuser\Models\Location;

class LocationController extends Controller
{
    public function ajaxData()
    {
        $locations = Location::where('parent_id', request()->input('locationId'))->get();
        return response()->json($locations);
    }
}
