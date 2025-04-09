<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasCountryBasedJobs;
use App\Models\Candidate;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CandidateCreateApprovalPendingNotification;
use App\Notifications\CandidateCreateNotification;
use App\Notifications\CompanyCreateApprovalPendingNotification;
use App\Notifications\CompanyCreatedNotification;
use App\Notifications\EmailVerifyNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

    use HasCountryBasedJobs, RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

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
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $data['candidates'] = Candidate::count();

        return view('frontend.auth.register', $data);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'indisposable',
                ],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'g-recaptcha-response' => config('captcha.active') ? 'required|captcha' : '',
            ],
            [
                'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
                'indisposable' => 'Please use a valid email address.',
                'g-recaptcha-response.captcha' => 'Captcha error! Try again later or contact site admin.',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $newUsername = Str::slug($data['name']);
        $oldUserName = User::where('username', $newUsername)->first();

        if ($oldUserName) {
            $username = Str::slug($newUsername).'_'.Str::random(5);
        } else {
            $username = Str::slug($newUsername);
        }
        //  user data store in session
        $user = new User;
        $user->role = $data['role'] == 'candidate' ? 'candidate' : 'company';
        $user->name = $data['name'];
        $user->username = $username;
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->created_ip = request()->ip();

        session()->put('user_data', $user);

        $verify_data = DB::table('password_resets')->insertGetId([
            'email' => $data['email'],
            'token' => Str::random(60),
            'created_at' => now(),
        ]);

        // if mail configured, send notification to candidate and company
        if (checkMailConfig()) {
            if ($user->role == 'candidate') {
                $candidate_account_auto_activation_enabled = Setting::where('candidate_account_auto_activation', 1)->count();

                if ($candidate_account_auto_activation_enabled) {
                    Notification::route('mail', $user->email)->notify(new CandidateCreateNotification($user, $data['password']));
                } else {
                    Notification::route('mail', $user->email)->notify(new CandidateCreateApprovalPendingNotification($user, $data['password']));
                }
            } elseif ($user->role == 'company') {

                $employer_auto_activation_enabled = Setting::where('employer_auto_activation', 1)->count();

                if ($employer_auto_activation_enabled) {
                    Notification::route('mail', $user->email)->notify(new CompanyCreatedNotification($user, $data['password']));
                } else {
                    Notification::route('mail', $user->email)->notify(new CompanyCreateApprovalPendingNotification($user, $data['password']));
                }

            }
            if (setting('email_verification')) {
                $token = DB::table('password_resets')->where('email', $user->email)->first();
                Notification::route('mail', $user->email)->notify(new EmailVerifyNotification($user->email, $token->token));
            }
        }

        // This code is commented only to reduce bounce rate
        return $user;
    }

    public function resendMail()
    {
        $user = session()->get('user_data');
        if (setting('email_verification')) {
            $token = DB::table('password_resets')->where('email', $user->email)->first();
            Notification::route('mail', $user->email)->notify(new EmailVerifyNotification($user->email, $token->token));
        }

        return view('frontend.auth.verify');
    }
}
