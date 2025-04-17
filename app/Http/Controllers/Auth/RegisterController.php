<?php

namespace App\Http\Controllers\Auth;

use App\Models\Job;
use App\Models\User;
use App\Models\Skill;
use App\Models\JobType;
use App\Models\Setting;
use App\Models\Candidate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profession;
use App\Models\ContactInfo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CandidateVisa;
use Illuminate\Support\Carbon;
use App\Models\CandidateResume;
use App\Models\CandidateLicense;
use App\Models\SkillTranslation;
use App\Models\CandidateLanguage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CandidateNationality;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\ProfessionTranslation;
use App\Providers\RouteServiceProvider;
use Modules\Language\Entities\Language;
use App\Http\Traits\HasCountryBasedJobs;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailVerifyNotification;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\CompanyCreatedNotification;
use App\Notifications\CandidateCreateNotification;
use App\Notifications\CompanyCreateApprovalPendingNotification;
use App\Notifications\CandidateCreateApprovalPendingNotification;

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

    public function showQuickApplyForm()
    {
    $setting = Setting::first();
    $nationalities = CandidateNationality::all();
    $visastatuses = CandidateVisa::all();
    $licensestatuses = CandidateLicense::all();
    $professions = Profession::all();
    $jobtypes = JobType::all();
    $skills = Skill::all();
    $languages = CandidateLanguage::all(['id', 'name']);
    $experiences = Experience::all();
    $educations = Education::all();
    
     $data = [
     'setting' => $setting,
     'nationalities' => $nationalities,
     'licensestatuses' => $licensestatuses,
     'visastatuses' => $visastatuses,
     'skills' => $skills,
     'experiences' => $experiences,
     'educations' => $educations,
     'candidate_languages' => $languages,
     'professions' => $professions,
     'jobtypes' => $jobtypes,
     'newjobs' => $this->filterCountryBasedJobs(Job::withoutEdited()->newJobs())->count(),
      ];
      // resources/views/frontend/auth/quickapply.blade.php
     return view('frontend.auth.quickapply', $data);
    }

    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
    
        if ($user) {
            return response()->json([
                'exists' => true
            ]);
        } else {
            return response()->json([
                'exists' => false
            ]);
        }
    }

    public function submitQuickApplyForm(Request $request)
    {
        \Log::info('Submitted status value: ' . $request->status);

        $request->validate([
'name' => 'required|string|min:4|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'marital_status' => 'required|in:married,single,divorced,widowed',
            'nationality' => 'required|exists:candidate_nationalities,id',
            'visastatus' => 'required|exists:candidate_visas,id',
            'noc_available' => 'required|in:yes,no,not_applicable',
            'licensestatus' => 'required|exists:candidate_licenses,id',
            'current_location' => 'required|string',
            'profession' => 'required',
            'jobs_types' => 'required|array',
            'jobs_types.*' => 'exists:job_types,id',
            'languages' => 'required|array',
            'languages.*' => 'exists:candidate_languages,id',
            'education' => 'required|exists:education,id',
            'experience' => 'required|exists:experiences,id',
            'status' => 'required',
            'expected_salary' => 'required|numeric|min:1000',
            'file_upload' => 'required|mimes:pdf,jpg,jpeg,doc,docx|max:5120',
            'prefixphone' => 'required',        ]);

        $newUsername = Str::slug($request['name']);

        $oldUserName = User::where('username', $newUsername)->first();

        if ($oldUserName) {
            $username = Str::slug($newUsername) . '_' . Str::random(5);
        } else {
            $username = Str::slug($newUsername);
        }

        $user = User::create([
            'role' => 'candidate',
            'name' => $request['name'],
            'username' => $username,
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $experience_request = $request->experience;
        $experience = Experience::where('id', $experience_request)->first();

        if (!$experience) {
            $experience = Experience::create(['name' => $experience_request]);
        }

        // Education
        $education_request = $request->education;
        $education = Education::where('id', $education_request)->first();

        if (!$education) {
            $education = Education::create(['name' => $education_request]);
        }

        $dateTime = Carbon::parse($request->birth_date);
        $date = $request['birth_date'] = $dateTime->format('Y-m-d H:i:s');

        if ($request->status == 'available_in') {
            $request->validate([
                'available_in' =>  'required'
            ]);
        }

        // Profession
        $profession_request = $request->profession;
        $profession = ProfessionTranslation::where('profession_id', $profession_request)->orWhere('name', $profession_request)->first();

        if (!$profession) {
            $new_profession = Profession::create(['name' => $profession_request]);

            $languages = Language::all();
            foreach ($languages as $language) {
                $new_profession->translateOrNew($language->code)->name = $profession_request;
            }
            $new_profession->save();

            $profession_id = $new_profession->id;
        } else {
            $profession_id = $profession->profession_id;
        }

        $candidate = $user->candidate;

        $candidate->update([
            'experience_id' => $experience->id,
            'noc_available' => $request->noc_available,
            'education_id' => $education->id,
            'birth_date' => $date,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'profession_id' => $profession_id,
            'status' => $request->status,
            'nationality_id' => $request->nationality,
            'candidate_visa_status_id' => $request->visastatus,
            'candidate_license_status_id' => $request->licensestatus,
            'profile_complete' => "0",
            'country' => $request->current_country,
            'address' => $request->current_region . ', ' . $request->current_country,
            'region' => $request->current_region,
            'locality' => "",
            'long' =>  $request->current_location_lng,
            'lat' => $request->current_location_lat,
            'current_salary' => $request->current_salary,
            'expected_salary' => $request->expected_salary,
            'available_in' => $request->available_in ? Carbon::parse($request->available_in)->format('Y-m-d') : null,
        ]);

        $jobTypeIds = $request->jobs_types; // corrected variable name
        $selectedJobTypes = [];
        if ($jobTypeIds) {
            $selectedJobTypes = JobType::whereIn('id', $jobTypeIds)->get();
            $candidate->jobTypes()->sync(collect($selectedJobTypes)->pluck('id')->toArray());
        }

        $skills = $request->skills;
        if ($skills) {
            $skillsArray = [];
            $count = 0; // Counter to keep track of the number of skills added

            foreach ($skills as $skill) {
                if ($count >= 5) {
                    break; // Stop synchronizing skills if the limit is reached
                }

                $skillExists = SkillTranslation::where('skill_id', $skill)->orWhere('name', $skill)->first();

                if (!$skillExists) {
                    $newSkill = Skill::create(['name' => $skill]);

                    $languages = Language::all();
                    foreach ($languages as $language) {
                        $newSkill->translateOrNew($language->code)->name = $skill;
                    }
                    $newSkill->save();

                    array_push($skillsArray, $newSkill->id);
                    $count++; // Increment the counter
                } else {
                    array_push($skillsArray, $skillExists->skill_id);
                    $count++; // Increment the counter
                }
            }

            $candidate->skills()->sync($skillsArray);
        }

        $candidate->languages()->sync($request->languages);

        $contact = ContactInfo::where('user_id', $user->id)->first();

        if (empty($contact)) {
            $phonenumber = $request->prefixphone;

            ContactInfo::create([
                'user_id' => $user->id,
                'phone' => $phonenumber,
                'email' => $request->email,
            ]);
        } else {
            $phonenumber = $request->prefixphone;
            $email = $request->email;
            $contact->update([
                'phone' => $phonenumber,
                'email' => $email,
            ]);
        }

        $validator = Validator::make($request->all(), [
            'file_upload' => 'required|mimes:pdf,jpg,jpeg,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            $user->delete();

            return redirect()->back()->with('error', 'Please check your resume file format or size.')->withInput();
        }

        $data['name'] = $user->username;
        $data['candidate_id'] = $candidate->id;

        // cv
        if ($request->file_upload) {
            $pdfPath = "file/candidates/";
            $file = uploadFileToPublic($request->file_upload, $pdfPath);
            $data['file'] = $file;
        }

        // try {
            $resume = CandidateResume::create($data);

            // Get the ID of the last saved resume
            $resumeId = $resume->id;

            // Update the candidate's default_cv field with the resume ID
            $candidate->update(['default_cv' => $resumeId,]); 

            // if mail configured, send notification to candidate and company
            if (checkMailConfig()) {
                if ($user->role == "candidate") {
                    $candidate_account_auto_activation_enabled = Setting::where("candidate_account_auto_activation", 1)->count();

                    if ($candidate_account_auto_activation_enabled) {
                        Notification::route('mail', $user->email)->notify(new CandidateCreateNotification($user, $request->password));
                    } else {
                        Notification::route('mail', $user->email)->notify(new CandidateCreateApprovalPendingNotification($user, $request->password));
                    }
                }
            }
        // } catch (\Illuminate\Database\QueryException $e) {
        //     $errorCode = $e->errorInfo[1];
        //     if ($errorCode == 1364) {
        //         return redirect()->back()->with('error', 'File field is required.');
        //     }

        //     return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        // }

        Auth::login($user);

        return redirect()->route('website.home')->with('success', 'Your application has been submitted successfully!')->with('user', $user);
    }
    
}
