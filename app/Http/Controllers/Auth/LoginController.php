<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function showLoginForm()
    {
        if (Auth::check()) {
            // Already logged in → redirect to admin/dashboard
            return redirect($this->redirectTo);
        }
        return view('backEnd.auth.login'); // তোমার login blade
    }
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended($this->redirectTo);
    }

     protected function attemptLogin(Request $request)
{
    $remember = $request->filled('remember');

    // Normal session lifetime 120 মিনিট, no extra 2-day
    return $this->guard()->attempt(
        $this->credentials($request),
        $remember
    );
}



    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/myfashionpanel');
    }


    public function checkStatus(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['logout' => true]);
        }

        $user = Auth::user();

        if ($user->status == 0) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json(['logout' => true]);
        }

        return response()->json(['logout' => false]);
    }

    
}
