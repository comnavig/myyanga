<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Providers\RouteServiceProvider;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;
// use App\User;

// class LoginController extends Controller
// {
//     /*
//     |--------------------------------------------------------------------------
//     | Login Controller
//     |--------------------------------------------------------------------------
//     |
//     | This controller handles authenticating users for the application and
//     | redirecting them to your home screen. The controller uses a trait
//     | to conveniently provide its functionality to your applications.
//     |
//     */

//     use AuthenticatesUsers;

//     /**
//      * Where to redirect users after login.
//      *
//      * @var string
//      */
//     protected $redirectTo = RouteServiceProvider::HOME;

//     /**
//      * Create a new controller instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         $this->middleware('guest')->except('logout');
//     }
    
//     protected function authenticated(Request $request, $user)
// 	{
		
// 		if (empty($request->redirect))
// 		{
// 			if ($user->type == "ADMIN")
// 			{
// 				return redirect()->route('admin.dashboard');
// 			}
// 			elseif ($user->type == "BUSINESS")
// 			{
// 				return redirect()->route('business.dashboard');
// 			}
// 			else
// 			{
// 				//~ return redirect()->route('user.dashboard');
// 				return redirect()->route('home');
// 			}
// 		}
// 		else
// 		{
// 			return redirect($request->redirect);
// 		}
// 	}
// }



namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // Disabled for local dev - needed for reCAPTCHA
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
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            // 'g-recaptcha-response' => 'required', // Disabled for local development
        ]);

        // Verify reCAPTCHA - DISABLED FOR LOCAL DEVELOPMENT
        // Uncomment the code below when deploying to production
        
        // $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        //     'secret' => config('services.recaptcha.secret_key'),
        //     'response' => $request->input('g-recaptcha-response'),
        //     'remoteip' => $request->ip(),
        // ]);

        // if (! $response->json('success')) {
        //     return back()->withErrors([
        //         'g-recaptcha-response' => 'reCAPTCHA verification failed.',
        //     ])->withInput();
        // }

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

