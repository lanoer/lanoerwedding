<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function logout()
    {
        Auth::guard('web')->logout();

        return redirect()->route('auth.login');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        $resetLink = route('auth.reset-password.form', $token);

        Mail::send('back.pages.auth.email.forgot-password', ['url' => $resetLink], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password Link');
        });

        return back()->with('status', 'We have emailed your password reset link!');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Token tidak valid.']);
        }

        // Check expiration (more than 60 minutes)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['email' => 'Token sudah kadaluarsa. Silakan minta ulang.']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('auth.login')->with('status', 'Password berhasil direset! Silakan login kembali.');
    }
    public function resetPasswordForm($token)
    {
        return view('back.pages.auth.reset', ['token' => $token]);
    }
}
