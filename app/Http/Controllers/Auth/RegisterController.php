<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Providers\RouteServiceProvider;
// use App\User;
// use Illuminate\Foundation\Auth\RegistersUsers;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;

// class RegisterController extends Controller
// {
//     /*
//     |--------------------------------------------------------------------------
//     | Register Controller
//     |--------------------------------------------------------------------------
//     |
//     | This controller handles the registration of new users as well as their
//     | validation and creation. By default this controller uses a trait to
//     | provide this functionality without requiring any additional code.
//     |
//     */

//     use RegistersUsers;

//     /**
//      * Where to redirect users after registration.
//      *
//      * @var string
//      */
//     //~ protected $redirectTo = RouteServiceProvider::HOME;
//     protected $redirectTo = RouteServiceProvider::VERIFYEMAIL;

//     /**
//      * Create a new controller instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         $this->middleware('guest');
//     }

//     /**
//      * Get a validator for an incoming registration request.
//      *
//      * @param  array  $data
//      * @return \Illuminate\Contracts\Validation\Validator
//      */
//     protected function validator(array $data)
//     {
//         return Validator::make($data, [
//             'name' => ['required', 'string', 'max:255'],
//             'mobile' => ['required', 'string', 'max:255', 'unique:users'],
//             'whatsapp' => ['required', 'string', 'max:255', 'unique:users'],
//             'type' => ['required', 'string'],
//             'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//             'password' => ['required', 'string', 'min:8', 'confirmed'],
//         ]);
//     }

//     /**
//      * Create a new user instance after a valid registration.
//      *
//      * @param  array  $data
//      * @return \App\User
//      */
//     protected function create(array $data)
//     {
//         // phpinfo();
//         $user = User::create([
//             'name' => $data['name'],
//             'mobile' => $data['mobile'],
//             'whatsapp' => $data['whatsapp'],
//             'email' => $data['email'],
//             'type' => strtoupper($data['type']),
//             'avatar' => asset('assets/img/avatar.png'),
//             'password' => Hash::make($data['password']),
//             'status' => 'ACTIVE',
//         ]);

//         $user->sendEmailVerificationNotification();
//         // event(new Registered($user));
//         return $user;
//     }
// }



namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // For API request to Google

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //~ protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = RouteServiceProvider::VERIFYEMAIL;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:255', 'unique:users'],
            'whatsapp' => ['required', 'string', 'max:255', 'unique:users'],
            'type' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => ['required'], // Ensure reCAPTCHA is present
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        // Validate reCAPTCHA token with Google API
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$response->json('success')) {
            return redirect()->back()
                ->withErrors(['g-recaptcha-response' => 'reCAPTCHA validation failed. Please try again.'])
                ->withInput();
        }

        // Proceed with normal registration flow
        $user = $this->create($request->all());

        $this->guard()->login($user);

        return redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // phpinfo();
        $user = User::create([
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'whatsapp' => $data['whatsapp'],
            'email' => $data['email'],
            'type' => strtoupper($data['type']),
            'avatar' => asset('assets/img/avatar.png'),
            'password' => Hash::make($data['password']),
            'status' => 'ACTIVE',
        ]);

        $user->sendEmailVerificationNotification();
        // event(new Registered($user));
        return $user;
    }
}

