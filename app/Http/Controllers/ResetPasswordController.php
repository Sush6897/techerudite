<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordResetToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    //
    public function showResetPasswordForm($email, $token)
    {
        $passwordReset = PasswordResetToken::where('email', $email)->where('token', $token)->first();

        if (!$passwordReset || now()->subMinutes(60)->gt($passwordReset->created_at)) {
            return redirect()->route('password.forgot')->with('error', 'Invalid or expired reset link.');
        }

        return view('reset-password', ['email' => $email, 'token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $passwordReset = PasswordResetToken::where('email', $request->email)->where('token', $request->token)->first();

        if (!$passwordReset || now()->subMinutes(60)->gt($passwordReset->created_at)) {
            return redirect()->route('password.forgot')->with('error', 'Invalid or expired reset link.');
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {
            return redirect()->route('password.forgot')->with('error', 'Email not found.');
        }

        $user->update(['password' => Hash::make($request->password)]);
        $passwordReset->delete();

        return redirect()->route('login')->with('success', 'Password changed successfully. You can now log in.');
    }
}
