<?php

namespace App\Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Admin\Models\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {

        if (auth()->check()) {
            
        }
        
        return view('admin::dashboard');
    }
}
