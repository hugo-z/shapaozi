<?php

namespace App\Modules\Superuser\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContestantsController extends Controller
{
    //
    public function index()
    {
        return view('superuser::people.contestants.index');
    }
}
