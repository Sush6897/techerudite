<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordResetToken;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


class PasswordResetController extends Controller
{
    //
    public function showForgotPasswordForm()
    {
        return view('forget-password');
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email not found.');
        }

        $token = Str::random(64);
        PasswordResetToken::updateOrCreate(
            ['email' => $user->email],
            ['email' => $user->email, 'token' => $token]
        );

        // You can send the password reset link via email here
        Mail::send('email.reset', ['user'=>$user, "token"=>$token], function ($message) use ($request) {
            $message->to($request->email)->subject('Password Reset');
        });

        return redirect()->back()->with('success', 'Password reset link sent successfully.');
    }
}
