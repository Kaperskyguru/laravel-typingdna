<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Services\TypingDNA;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\TypingDNARequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            session()->put('typingPattern', $request->typingPattern);
            session()->put('textid', $request->textid);
            session()->put('email', $request->email);
            session()->put('password', $request->password);

            return redirect()->route('verify');
        } else {
            // Send back errors
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function verifyTypingDNA(LoginRequest $request)
    {
        // dd($request);

        $user = User::where('email', $request->email)->first();

        $check = TypingDNA::getInstance()->checkUser($user);

        if ($check['success'] === 1 && $check['count'] >= 0) {
            $result = TypingDNA::getInstance()->doAuto($user, session()->get('typingPattern'));
            if ($result['status'] > 200) {
                return $this->destroy($request);
            }
            
            $request->authenticate();
            $request->session()->regenerate();
            session()->forget('typingPattern');
            session()->forget('textid');
            session()->forget('email');
            session()->forget('password');

            return redirect(RouteServiceProvider::HOME);
        } else {
            return $this->destroy($request);
        }
    }
}
