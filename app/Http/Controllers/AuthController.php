<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Validator;

class AuthController extends Controller
{
    public function auth_index(){
        return view('auth.index');
    }

    public function AuthLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->password == $credentials['password']) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function AuthLogout(Request $request): RedirectResponse
{
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
}


// Change_Password
public function ChangePasswordIndex()
        {
            $user = Auth::user();

            return view('changePassword.index')->with('user',$user);
        }

        public function ChangePassword(Request $request)
        {

            $validated = $request->validate([
                'email' => 'required|exists:users,email',
                'old_password' => 'required|exists:users,password',
                'password' => 'required|string|min:8',
                'confirm_password' => 'required|same:password',
            ]);

           User::where('email', $request->email)
          ->where('password', $request->old_password)
          ->update(['password' => $request->password]);

           return redirect()->back()->with('success','Change Password Successfully..!');
        }
}
