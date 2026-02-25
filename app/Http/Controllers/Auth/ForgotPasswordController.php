<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Mail\OtpMail;



class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email', $request->email)->first();

        // Check if valid token already exists
       if ($user->password_reset_token && $user->password_reset_token_created_at) {
    // password_reset_token_created_at কে Carbon object এ convert করি
    $tokenCreatedAt = Carbon::parse($user->password_reset_token_created_at);

    if (Carbon::now()->lte($tokenCreatedAt->addMinutes(2))) {
        return back()->with('status', 'A reset link has already been sent! Check your email.');
    }
}
        $token = Str::random(64);
        $user->password_reset_token = Hash::make($token);
        $user->password_reset_token_created_at = Carbon::now();
        $user->save();

        $link = route('password.reset', ['token' => $token, 'email' => $user->email]);

        Mail::raw("Click here to reset your password: $link", function($message) use ($user){
            $message->to($user->email)
                    ->subject('Password Reset Link');
        });

        return back()->with('status', 'A password reset link has been sent to your email.');
    }

    // Show forgot password view (reset link / OTP selection)
    public function showLinkRequestForm()
    {
        return view('backEnd.auth.email'); // Blade তৈরি হবে
    }



public function sendOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email'
    ]);

    $user = User::where('email', $request->email)->first();

    // Check if a valid OTP already exists
    if ($user->otp && $user->otp_expires_at && Carbon::now()->lte($user->otp_expires_at)) {
        // OTP still valid, redirect to OTP page with same email
        return redirect()->route('password.otp.form')
                         ->with('email', $user->email)
                         ->with('status', 'OTP already sent! Please check your email.');
    }

    // Generate new OTP
    $otp = rand(100000, 999999); // 6-digit OTP
    $user->otp = $otp;
    $user->otp_created_at = Carbon::now();
    $user->otp_expires_at = Carbon::now()->addMinutes(2);
    $user->save();

    // Send OTP via email
    Mail::to($user->email)->send(new OtpMail($user, $otp));

    // Redirect to OTP page with email
    return redirect()->route('password.otp.form')
                     ->with('email', $user->email)
                     ->with('status', 'OTP has been sent to your email.');
}



public function getOtpExpiry(Request $request)
{
    $user = User::where('email', $request->email)->first();
    if($user && $user->otp_expires_at && Carbon::now()->lt($user->otp_expires_at)){
        return response()->json(['otp_expires_at' => $user->otp_expires_at]);
    }
    return response()->json(['otp_expires_at' => null]);
}

public function resendOtp(Request $request)
{
    $user = User::where('email', $request->email)->first();
    if(!$user) return response()->json(['message'=>'User not found'], 404);

    $otp = rand(100000, 999999);
    $user->otp = $otp;
    $user->otp_created_at = Carbon::now();
    $user->otp_expires_at = Carbon::now()->addMinutes(2); // 1 min expiry
    $user->save();

    Mail::raw("Your OTP: $otp", function($message) use($user){
        $message->to($user->email)->subject('Password Reset OTP');
    });

    return response()->json(['message'=>'OTP resent successfully!']);
}




    // Show OTP verification page
    public function showOtpForm(Request $request)
    {
        // চেষ্টা করো session থেকে email নেবার, না হলে request থেকে নাও
        $email = session('email', $request->email ?? '');

        return view('backEnd.auth.otp', compact('email'));
    }

    public function validateOtpAjax(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'otp' => 'required|digits:6'
    ]);

    $user = User::where('email', $request->email)
                ->where('otp', $request->otp)
                ->where('otp_expires_at', '>=', now())
                ->first();

    return response()->json([
        'valid' => $user ? true : false
    ]);
}


    // Verify OTP
public function verifyOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'otp'   => 'required|digits:6',
    ]);

    $user = User::where('email', $request->email)
        ->where('otp', $request->otp)
        ->where('otp_expires_at', '>=', now())
        ->first();

    if (!$user) {
        return back()->withErrors(['otp' => 'Invalid or expired OTP']);
    }

    // 🔥 new token → old token auto invalid
    $plainToken = Str::random(64);

    $user->password_reset_token = Hash::make($plainToken);
    $user->password_reset_token_created_at = now();
    $user->otp = null;
    $user->otp_expires_at = null;
    $user->save();
    session()->flash('status', 'OTP verified successfully!');
    return redirect()->route('password.reset', [
        'token' => $plainToken,
        'email' => $user->email
    ]);
}




    // Reset password via OTP
    public function resetWithOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->where('otp_expires_at', '>', now())
                    ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        $user->password = Hash::make($request->password);
        $user->otp = null;
        $user->otp_created_at = null;
        $user->otp_expires_at = null;
        $user->save();

        return redirect()->route('login')->with('status', 'Password reset successfully!');
    }
}
