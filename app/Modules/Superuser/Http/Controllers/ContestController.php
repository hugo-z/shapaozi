<?php

namespace App\Modules\Superuser\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Superuser\Models\Contest;

class ContestController extends Controller
{
    public function index()
    {
        $contests = Contest::all();
        return view('superuser::contest.index', compact('contests'));
    }

    /**
     * Create new Contest
     *
     * @return void
     */
    public function create()
    {
        return view('superuser::contest.create');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function store($id = null)
    {
        // $validateOption = !$id ? 'unique:huge__constest' : '';
        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:128'
        ]);
        $validator->sometimes('name', 'unique:' . (new Contest)->table, function ($id) {
            return is_null($id);
        });

        if (request()->ajax()) {
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'msg' => $validator->errors()
                ]);
            }
            
            Contest::updateOrCreate(
                [
                    'id' => $id
                ],
                [
                    'name' => request()->input('name'),
                    'status' => request()->input('status')
                ]
            );
            return response()->json([
                'status' => true,
                'msg' => trans('superuser::contest.add_success')
            ]);
        }
    }
}
