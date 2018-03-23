<?php

namespace App\Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Session\Models\Session;
use Illuminate\Support\Facades\Auth;
use App\Rules\cellPhone;
use Illuminate\Support\Facades\Hash;
use Validator;
// use Illuminate\Foundation\Auth\RegistersUsers;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Foundation\Auth\ResetsPasswords;
// use Illuminate\Foundation\Auth\SendsPasswordResetEmails;


class SessionsController extends Controller
{
    // use AuthenticatesUsers;
    
    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = '/admin';    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('destroy');
    }

    public function showLoginForm()
    {
        return view('admin::auth.login');
    }

    public function authenticate()
    {
        if (
            Auth::attempt(
                [
                    'cell' => request()->input('cell'), 
                    'password' => request()->input('password'),
                    'suspended' => 0
                ],
                request()->input('remember')
            )
        ) {
            return redirect()->intended('admin');
        }

        return redirect()->back()->withInput(request()->only('cell', 'remember'))
                                ->withErrors($this->loginFailedErrors());
    }

    /**
     * Validate the login process
     * 
     * @return void
     */
    private function loginFailedErrors()
    {
        $validator = Validator::make(request()->all(), [
            'cell' => ['required', new cellPhone],
            'password' => 'required'
        ]);

        $errors = $validator->errors();

        if (!$errors->any()) {
            $user = \App\Modules\Superuser\Models\User::where('cell', request()->input('cell'))->first();
            if (!$user) {
                $errors = ['cell' => trans('auth.cell')];
            } elseif (!Hash::check(request()->input('password'), $user->password)) {
                $errors = ['password' => trans('auth.password')];
            } elseif ($user->suspended != 1) {
                $errors = ['suspended' => trans('auth.suspended')];
            }
        }

        return $errors;
    }

    public function destroy()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
