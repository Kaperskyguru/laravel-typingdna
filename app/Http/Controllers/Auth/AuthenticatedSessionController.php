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
            $request->authenticate();
            $request->session()->regenerate();

            Auth::logout();
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

        $user = User::where('email', $request->email)->first();
        $check = TypingDNA::getInstance()->checkUser($user);
        if ($check['success'] === 1 && $check['count'] >= 0) {
            $result = TypingDNA::getInstance()->doAuto($user, $request->typingPattern);
            if ($result['status'] > 200) {
                return $this->destroy($request);
            }
            if ((isset($result['high_confidence']) && isset($result['result'])) && ($result['high_confidence'] === 1 && $result['result'] === 1)) {
                session()->forget('typingPattern');
                session()->forget('textid');
                session()->forget('email');
                session()->forget('password');
                session()->forget('error_message');
                $request->authenticate();
                $request->session()->regenerate();
                return redirect(RouteServiceProvider::HOME);
            }
            session()->put('error_message', $result['message']);
            session()->put('error_count', $check['count']);
            return redirect()->route('verify');
        } else {
            return $this->destroy($request);
        }
    }
}
