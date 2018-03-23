<?php

namespace App\Modules\Superuser\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Modules\Superuser\Http\Requests\StoreUser;
use App\Http\Controllers\Controller;
use App\Modules\Superuser\Models\User;
use App\Modules\Superuser\Models\Role;
use App\Modules\Superuser\Models\UserRoles;
use App\Modules\Superuser\Models\Location;
use App\Rules\cellPhone;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Users List
     *
     * @return void
     */
    public function index()
    {
        // dd((new UserRoles)->userHasRoles());
        return view('superuser::people.users.index');
    }

    /**
     * Create and edit page
     *
     * @param string $userId
     * @param string $step
     * @return void
     */
    public function createOrUpdate($userId = '', $step = '')
    {
        if (!$step) $step = 1;

        $userModel = new User;
        $user = $userModel->user($userId);

        # Roles for user
        $roleModels = Role::all();

        # Location Model
        $locationModel = new Location;

        # Locations for user
        $countryModels = Location::where('parent_id', 0)->get();
        $provinceModels = $cityModels = $districtModels = null;

        if ($user) {
            $countryModels = Location::where('location_id', $user->country)->get();

            # Provinces for user
            $provinceModels = Location::where('parent_id', $user->country)->get();

            # Cities for user
            $cityModels = Location::where('parent_id', $user->province)->get();

            # Districts for user
            $districtModels = Location::where('parent_id', $user->city)->get();

            # Selected Roles
            $selectedRoles = $userModel->hasRoles($userId);
        }
        
        $userDataStandBy = [];

        # Deal with Posted Data
        if (request()->isMethod('post')) {
            $userInfo = request()->except(['_token', 'step']);
            $validated = [];

            switch (request()->input('step')) {
                case 2: # step 2
                    $ifUnique = request()->has('user_id') ? '' : 'unique:huge__admin';
                    $validated = [
                        'name' => 'required|max:20',
                        'email' => 'email',
                        'cell' => [$ifUnique, new cellPhone],
                        'password' => 'required|max:8|min:6',
                        'country' => 'digits:6|integer',
                        'province' => 'digits:6|integer',
                        'city' => 'digits:6|integer',
                        'division' => 'digits:6|numeric'
                    ];
                    
                    request()->session()->reflash();
                    request()->session()->flash('storeUserSteps', $userInfo);
                    
                    $step = 2;
                    break;
                case 3: # step 3
                    $validated = [
                        'divisionOption' => 'required'
                    ];
                    
                    request()->session()->reflash();
                    request()->session()->flash('storeUserSteps.division', $userInfo);
                    
                    $step = 3;
                    break;
                case 4:
                    $validated = [
                        'roles' => 'required|array',
                    ];
                    
                    request()->session()->reflash();
                    request()->session()->flash('storeUserSteps.roles', $userInfo['roles']);
                    
                    if (array_key_exists('suspended', $userInfo)) {
                        request()->session()->flash('storeUserSteps.suspended', $userInfo['suspended']);
                    } else {
                        request()->session()->flash('storeUserSteps.suspended', 0);
                    }
        
                    $step = 'final';
                    break;
                case 'final':
                    $userData = request()->session()->get('storeUserSteps');
                    
                    $storedResult = $this->store($userData);
                    
                    return redirect()->route(
                        'editUser', 
                        [
                            'id' => $storedResult->get('id')
                        ]
                    )->with('status', $storedResult->get('msg'));
                    break;
                default:
                    break;
            }
            # store everything into single session
            request()->validate($validated);
        }
        
        return view(
            'superuser::people.users.create', 
            compact (
                'roleModels', 
                'countryModels', 
                'provinceModels',
                'cityModels',
                'districtModels',
                'selectedRoles',
                'step', 
                'user'
            )
        );
    }

    /**
     * Store the user data stored in the flash session
     *
     * @param array $userInfo
     * @return void
     */
    public function store(array $userInfo)
    {
        # Store the user info first
        $userDataStandBy = null;

        if (null !== $userInfo) {
            switch ($userInfo['division']['divisionOption']) {
                case 'province':
                    $userInfo['division'] = $userInfo['province'];
                    break;
                case 'city':
                    $userInfo['division'] = $userInfo['city'];
                    break;
            }

            $userDataStandBy = $userInfo;

            # Hash the password
            $userDataStandBy['password'] = Hash::make($userDataStandBy['password']);

            unset($userDataStandBy['roles']);
            
            if (
                array_key_exists('user_id', $userDataStandBy)
            ) {
                unset($userDataStandBy['user_id']);
                $userId = $userInfo['user_id'];
            }
            
            if (!isset($userId)) {
                $user = new User;
                $user->fill($userDataStandBy);
                $user->save();
                $userId = $user->id;

                $msg = trans('superuser::user.messages.create_success');
            } else {
                User::where('id', $userId)
                    ->update($userDataStandBy);

                $msg = trans('superuser::user.messages.edit_success');
            }
            
            # Store the associated user roles
            $userRoles = new UserRoles;
            $userRoles->setUserId($userId);

            # Check the existing user roles
            $userRoles->storeRoles($userInfo['roles']);

            $return = collect([
                'id' => $userId,
                'msg' => $msg
            ]);

            return $return;
        }
        
    }

    /**
     * User list pager
     *
     * @return json
     */
    public function ajaxData()
    {
        $users = new User;

        return $users->usersToArray();
    }
}
