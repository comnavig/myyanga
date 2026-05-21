<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Add reCAPTCHA validation here
    public function login(Request $request)
    {
        $rules = [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ];

        // Only enforce reCAPTCHA in production with a valid secret key
        $recaptchaSecret = config('services.recaptcha.secret_key');
        $isRecaptchaEnabled = app()->environment('production') && !empty($recaptchaSecret);

        if ($isRecaptchaEnabled) {
            $rules['g-recaptcha-response'] = 'required';
        }

        $request->validate($rules);

        if ($isRecaptchaEnabled) {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $recaptchaSecret,
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]);

            if (! $response->json('success')) {
                return back()->withErrors([
                    'g-recaptcha-response' => 'reCAPTCHA verification failed.',
                ])->withInput();
            }
        }

        // Proceed with normal login
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function authenticated(Request $request, $user)
    {
        if (empty($request->redirect)) {
            if ($user->type == "ADMIN") {
                return redirect()->route('admin.dashboard');
            } elseif ($user->type == "BUSINESS") {
                return redirect()->route('business.dashboard');
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect($request->redirect);
        }
    }
}

