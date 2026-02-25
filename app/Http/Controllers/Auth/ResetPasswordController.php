<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/admin/dashboard';

    public function __construct()
    {
        $this->middleware('guest');
    }

   public function showResetForm(Request $request, $token = null)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $user = User::where('email', $request->email)->first();

    if (
        !$user ||
        !$user->password_reset_token ||
        !Hash::check($token, $user->password_reset_token) ||
        Carbon::parse($user->password_reset_token_created_at)->addMinutes(15)->isPast()
    ) {
        abort(403, 'This password reset link is invalid or expired.');
    }

    return view('backEnd.auth.reset', [
        'token' => $token,
        'email' => $request->email
    ]);
}


    // Reset password
    public function reset(Request $request)
{
    $request->validate([
        'email'    => 'required|email|exists:users,email',
        'token'    => 'required',
        'password' => 'required|confirmed|min:8',
    ]);

    $user = User::where('email', $request->email)->first();

    if (
        !$user ||
        !$user->password_reset_token ||
        !Hash::check($request->token, $user->password_reset_token)
    ) {
        return back()->withErrors(['email' => 'Invalid or expired reset link.']);
    }

    $user->password = Hash::make($request->password);

    // 🔥 invalidate link after use
    $user->password_reset_token = null;
    $user->password_reset_token_created_at = null;

    $user->save();

    return redirect()->route('login')->with('status', 'Password reset successfully!');
}

    
}
