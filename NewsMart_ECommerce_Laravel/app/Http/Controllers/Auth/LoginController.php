<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function username()
    { 
        $login = request()->input('login');
        
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ], [
            $this->username() . '.required' => 'The login field (username or email) is required.',
            'password.required' => 'The password field is required.',
        ]);
    }

    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['isactive' => 1]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where($this->username(), $request->input($this->username()))->first();

        if ($user && $user->isactive === 0) {
             throw ValidationException::withMessages([
                 'login' => ['Your account has been disabled.'], 
             ]); 
        }

        throw ValidationException::withMessages([
            'login' => [trans('auth.failed')], 
        ]);
    }
    
    protected function authenticated(Request $request, $user)
    {
        return redirect($this->redirectTo)->with('status', 'Login successful! Welcome ' . $user->name . '.');
    }
}