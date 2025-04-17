@extends('frontend.layouts.app')

@section('meta')
    @php
        $data = metaData('login');
    @endphp
@endsection

@section('description')
    {{ $data->description }}
@endsection

@section('title')
    {{ __('login') }}
@endsection

@section('og:image')
    {{ asset($data->image) }}
@endsection

@section('main')
<div class="row mt-0 mt-5">
    <div class="full-height1 col-12 order-1 order-lg-0">

        <div class="container">
            <div class="row full-height1 align-items-center">
                <div class="col-xl-12 col-lg-12 col-md-12 tw-bg-white tw-relative tw-mt-5 tw-z-50">
                    <div class="auth-box2">
                        <form id="formId" action="{{ route('submit.application') }}" method="POST" class="rt-form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="rt-mb-20 rt-mb-15 text-center mb-5 gradient-text">
                                        {{ __('quick_apply') }}
                                    </h2>
                                </div>
                                <style>
                                  .gradient-text {
    background: linear-gradient(270deg, 
        #00c6ff,   /* Light Cyan Blue */
        #0072ff,   /* Strong Blue */
        #4b6cb7,   /* Soft Blue Purple */
        #182848,   /* Deep Blue Navy */
        #00d2ff,   /* Sky Blue */
        #3a7bd5,   /* Ocean Blue */
        #00c6ff    /* Repeat for seamless loop */
    );
    background-size: 1400% 1400%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: gradientShift 10s ease infinite;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

                                </style>
                                

                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="fromGroup rt-mb-15">
                                        <input type="text" name="name" required id="name" value="{{ old('name') }}"
                                            class="field form-control @error('name') is-invalid @enderror"
                                            placeholder="{{ __('full_name') }}">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!--<div class="col-lg-6">
                                        <div class="fromGroup rt-mb-15">
                                            <input name="username" id="name" value=""
                                                class="field form-control @error('username') is-invalid @enderror"
                                                type="text" placeholder="user name">
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                            @enderror
                                        </div>
                                    </div>  -->
                                <div class="col-lg-3">
                                    <div class="fromGroup rt-mb-15">
                                        <input type="email" id="email" required value="{{ old('email') }}" name="email"
                                            class="field form-control @error('email') is-invalid @enderror"
                                            placeholder="{{ __('email_address') }}" onchange="checkEmailExists()">
                                        <span id="email-error" class="invalid-feedback d-none" role="alert"></span>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="tel" name="prefixphone" required id="phone" 
                                                class="form-control @error('prefixphone') is-invalid @enderror" 
                                                value="{{ old('prefixphone') }}">
                                            @error('prefixphone')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="d-flex fromGroup rt-mb-15">
                                        <input type="password" name="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="{{ __('password') }}" required>
                                        <div onclick="passToText('password','eyeIcon')" id="eyeIcon" class="has-badge">
                                            <i class="ph-eye @error('password') m-3 @enderror"></i>
                                        </div>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex fromGroup rt-mb-15">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            placeholder="{{ __('confirm_password') }}" required>
                                        <div onclick="passToText('password_confirmation','eyeIcon2')" id="eyeIcon2"
                                            class="has-badge">
                                            <i class="ph-eye @error('password_confirmation') m-3 @enderror"></i>
                                        </div>
                                        @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>



                            <section id="personaldetails" class="rt-mb-15 rt-mb-15">
                                <h5 class="">Personal details</h5>

                                <div class="form-group row">

                                    <div class="col-lg-6 rt-mb-15">
                                        <x-forms.label :required="true" name="date_of_birth"
                                            class="body-font-4 d-block text-gray-900 rt-mb-8" for="date" />
                                        <div class="form-group">
                                            <div class="d-flex align-items-center form-control-icon date datepicker">
                                                <input type="text" name="birth_date"
                                                    value="{{ old('birth_date', isset($request) ? \Carbon\Carbon::parse($request->birth_date)->format('d/m/Y') : '') }}"
                                                    id="date" placeholder="dd/mm/yyyy"
                                                    class="form-control border-custom @error('birth_date') is-invalid @enderror"
                                                    required />
                                                <span class="input-group-addon input-group-text-custom">
                                                    <x-svg.calendar-icon />
                                                </span>
                                            </div>
                                            @error('birth_date')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 rt-mb-15">
                                        <x-forms.label :required="true" name="gender"
                                            class="body-font-4 d-block text-gray-900 rt-mb-8" />


                                        <select
                                            class="rt-selectactive w-100-p single select2-search form-control select2-hidden-accessible @error('gender') is-invalid @enderror"
                                            name="gender" required>
                                            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>{{
                                                __('Select Gender') }}</option>
                                            <option value="male" {{ old('gender')=='male' ? 'selected' : '' }}>{{
                                                __('male') }}</option>
                                            <option value="female" {{ old('gender')=='female' ? 'selected' : '' }}>{{
                                                __('female') }}</option>
                                            <option value="other" {{ old('gender')=='other' ? 'selected' : '' }}>{{
                                                __('other') }}</option>
                                        </select>



                                        @error('gender')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-lg-6 rt-mb-15">
                                        <label class="pointer body-font-4   text-gray-900 rt-mb-8">Marital Status<span
                                                class="form-label-required text-danger">*</span>
                                            <div class="form-text text-muted"> <span class="help-icon"
                                                    text="Select an option for your Marital Status">?</span> </div>
                                        </label>

                                        <select name="marital_status"
                                            class="rt-selectactive w-100-p single select2-search form-control select2-hidden-accessible"
                                            required>
                                            <option value="" disabled {{ old('marital_status') ? '' : 'selected' }}>{{
                                                __('Select Option') }}</option>
                                            <option value="married" {{ old('marital_status')=='married' ? 'selected'
                                                : '' }}>{{ __('married') }}</option>
                                            <option value="single" {{ old('marital_status')=='single' ? 'selected' : ''
                                                }}>{{ __('single') }}</option>
                                            <option value="divorced" {{ old('marital_status')=='divorced' ? 'selected'
                                                : '' }}>{{ __('divorced') }}</option>
                                            <option value="widowed" {{ old('marital_status')=='widowed' ? 'selected'
                                                : '' }}>{{ __('widowed') }}</option>
                                        </select>

                                        @error('marital_status')
                                        <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-lg-6 rt-mb-15">
                                        <label class="pointer body-font-4   text-gray-900 rt-mb-8">Nationality<span
                                                class="form-label-required text-danger">*</span>
                                            <div class="form-text text-muted"> <span class="help-icon"
                                                    text="Select an option for your Nationality">?</span> </div>
                                        </label>

                                        <select name="nationality" class="w-100-p single select2-search form-control select2-hidden-accessible @error('nationality') is-invalid @enderror" required>
                                            <option value="" disabled selected>{{ __('Select Option') }}</option>
                                            @foreach ($nationalities as $nationality)
                                                <option value="{{ $nationality->id }}" {{ old('nationality') == $nationality->id ? 'selected' : '' }}>
                                                    {{ $nationality->nationality }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('nationality')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-lg-6 rt-mb-15">
                                        <label class="pointer body-font-4   text-gray-900 rt-mb-8">Visa Status<span
                                                class="form-label-required text-danger">*</span>
                                            <div class="form-text text-muted"> <span class="help-icon"
                                                    text="Select an option for your Qatar Visa status">?</span> </div>
                                        </label>

                                        <select name="visastatus"
                                            class="w-100-p single select2-search form-control select2-hidden-accessible"
                                            required>
                                            <option value="" disabled selected>{{ __('Select Option') }}</option>
                                            @foreach ($visastatuses as $visastatus)
                                            <option value="{{ $visastatus->id }}" {{ old('visastatus')==$visastatus->id
                                                ? 'selected' : '' }}>
                                                {{ $visastatus->visa_status }}
                                            </option>
                                            @endforeach
                                        </select>

                                        @error('candidate_visa_status')
                                        <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 rt-mb-15">
                                        <label class="pointer body-font-4   text-gray-900 rt-mb-8">Do you have NOC?<span
                                                class="form-label-required text-danger">*</span>
                                            <div class="form-text text-muted"> <span class="help-icon"
                                                    text="Select an option for your NOC status">?</span> </div>
                                        </label>

                                        <select name="noc_available"
                                            class="rt-selectactive w-100-p single select2-search form-control select2-hidden-accessible"
                                            required>
                                            <option value="" disabled selected>{{ __('Select Option') }}</option>
                                            <option value="yes" @if(old('noc_available')=='yes' ) selected @endif>{{
                                                __('yes') }}</option>
                                            <option value="no" @if(old('noc_available')=='no' ) selected @endif>{{
                                                __('no') }}</option>
                                            <option value="not_applicable" @if(old('noc_available')=='not_applicable' )
                                                selected @endif>{{ __('not_applicable') }}</option>
                                        </select>

                                        @error('marital_status')
                                        <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-lg-6 rt-mb-15">
                                        <label class="pointer body-font-4   text-gray-900 rt-mb-8">Driving License<span
                                                class="form-label-required text-danger">*</span>
                                            <div class="form-text text-muted"> <span class="help-icon"
                                                    text="Select an option for your driving license status">?</span>
                                            </div>
                                        </label>

                                        <select name="licensestatus"
                                            class="w-100-p single select2-search form-control select2-hidden-accessible"
                                            required>
                                            <option value="" disabled selected>{{ __('Select Option') }}</option>

                                            @foreach ($licensestatuses as $licensestatus)
                                            <option value="{{ $licensestatus->id }}"
                                                @if(old('licensestatus')==$licensestatus->id) selected @endif>{{
                                                $licensestatus->license_status }}</option>
                                            @endforeach
                                        </select>

                                        @error('candidate_license_status')
                                        <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-lg-6 rt-mb-15">
                                        <x-forms.label :required="true" name="Current Location"
                                            class="body-font-4 d-block text-gray-900 rt-mb-8"
                                            for="currentLocationInput" />
                                        <input type="text" id="currentLocationInput" name="current_location" required
                                            placeholder="Enter current location">
                                        <input type="hidden" id="currentLocationLat" name="current_location_lat">
                                        <input type="hidden" id="currentLocationLng" name="current_location_lng">
                                        <input type="hidden" id="currentCountryInput" name="current_country">
                                        <input type="hidden" id="currentRegionInput" name="current_region">
                                    </div>




                                </div>
                            </section>

                            <section id="personaldetails" class="rt-mb-15 rt-mb-15">
                                <h5 class="">Career details</h5>

                                <div class="form-group row">


                                    <div class="col-lg-6 rt-mb-15">
                                        <label class="pointer body-font-4   text-gray-900 rt-mb-8">Position apply
                                            for<span class="form-label-required text-danger">*</span>
                                            <div class="form-text text-muted"> <span class="help-icon"
                                                    text="Let your employer knows your preferred job position.">?</span>
                                            </div>
                                        </label>

                                        <select name="profession"
                                            class="w-100-p single select2-search form-control select2-hidden-accessible"
                                            required>
                                            <option value="" disabled selected>{{ __('Select Option') }}</option>
                                            @foreach ($professions as $profession)
                                            <option value="{{ $profession->id }}" @if(old('profession')==$profession->
                                                id) selected @endif>{{ $profession->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('profession')
                                        <span class="invalid-feedback" role="alert">{{ __($message) }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 rt-mb-15">

                                        <label class="pointer body-font-4   text-gray-900 rt-mb-8">Desire job types<span
                                                class="form-label-required text-danger">*</span>
                                            <div class="form-text text-muted"> <span class="help-icon"
                                                    text="Your preferred job types from the list.">?</span> </div>
                                        </label>



                                        <select name="jobs_types[]" class="rt-selectactive w-100-p" multiple required>
                                            @foreach ($jobtypes as $jobtype)
                                            <option value="{{ $jobtype->id }}" @if(in_array($jobtype->id,
                                                old('jobs_types', []))) selected @endif>{{ $jobtype->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>

                                    <div class="col-lg-6 rt-mb-15">
                                        <label class="pointer body-font-4   text-gray-900 rt-mb-8"> Languages you
                                            know<span class="form-label-required text-danger">*</span>
                                            <div class="form-text text-muted"> <span class="help-icon"
                                                    text="Select one or more languages from the list.">?</span> </div>
                                        </label>


                                        <select name="languages[]" class="rt-selectactive w-100-p" multiple required>

                                            @foreach ($candidate_languages as $lang)
                                            <option value="{{ $lang->id }}" @if(in_array($lang->id, old('languages',
                                                []))) selected @endif>{{ $lang->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>

                                    <div class="col-lg-6 rt-mb-15">


                                        <label class="pointer body-font-4   text-gray-900 rt-mb-8"> Skills (Maximum
                                            Limit : 5) <div class="form-text text-muted"> <span class="help-icon"
                                                    text="Type your skills as tags">?</span> </div> </label>
                                        <select name="skills[]" class="select2-taggable w-100-p" multiple>
                                            @foreach ($skills as $skill)

                                            @endforeach
                                        </select>



                                    </div>

                                    <div class="col-lg-6 rt-mb-15">
                                        <label class="pointer body-font-4   text-gray-900 rt-mb-8"> Education Level
                                            <span class="form-label-required text-danger">*</span>
                                            <div class="form-text text-muted"> <span class="help-icon"
                                                    text="Your highest level of education.">?</span> </div>
                                        </label>

                                        <select name="education" class="single w-100-p" required>
                                            <option value="" disabled selected>{{ __('Select Option') }}</option>
                                            @foreach ($educations as $education)
                                            <option value="{{ $education->id }}" @if(old('education')==$education->id)
                                                selected @endif>{{ $education->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('education')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 rt-mb-15">
                                        <label class="pointer body-font-4   text-gray-900 rt-mb-8"> Experience Level
                                            <span class="form-label-required text-danger">*</span>
                                            <div class="form-text text-muted"> <span class="help-icon"
                                                    text="Total number of years of experience.">?</span> </div>
                                        </label>

                                        <select name="experience" class="single w-100-p" required>
                                            <option value="" disabled selected>{{ __('Select Option') }}</option>
                                            @foreach ($experiences as $experience)
                                            <option value="{{ $experience->id }}" @if(old('experience')==$experience->
                                                id) selected @endif>{{ $experience->name }}</option>
                                            @endforeach
                                        </select>



                                        @error('experience')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-lg-6 rt-mb-15">
                                        <label class="pointer body-font-4   text-gray-900 rt-mb-8">Your
                                            availability<span class="form-label-required text-danger">*</span>
                                            <div class="form-text text-muted"> <span class="help-icon"
                                                    text="Select an option when you can join.">?</span> </div>
                                        </label>

                                        <select id="available_status" name="status" required
                                            class="rt-selectactive form-control w-100-p">
                                            <option value="" disabled selected>{{ __('Select Option') }}</option>
                                            <option value="available_immediately"
                                                @if(old('status')=='available_immediately' ) selected @endif>{{
                                                __('available_immediately') }}</option>
                                            <option value="available_in15days" @if(old('status')=='available_in15days' )
                                                selected @endif>{{ __('available_in15days') }}</option>
                                            <option value="available_in30days" @if(old('status')=='available_in30days' )
                                                selected @endif>{{ __('available_in30days') }}</option>
                                            <option value="available_in60days" @if(old('status')=='available_in60days' )
                                                selected @endif>{{ __('available_in60days') }}</option>
                                            <option value="available_in90days" @if(old('status')=='available_in90days' )
                                                selected @endif>{{ __('available_in90days') }}</option>
                                        </select>

                                        @error('status')
                                        <span class="error invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>



                                    <div class="col-lg-3   rt-mb-15">
                                        <x-forms.label :required="false" name="Current Salary (QAR)"
                                            class="body-font-4 d-block text-gray-900 rt-mb-8" for="current_salary" />

                                        <x-forms.input type="number" name="current_salary" value=" "
                                            placeholder="Salary per month" min="1000" class="" />
                                    </div>


                                    <div class="col-lg-3   rt-mb-15">
                                        <x-forms.label :required="true" name="Expected Salary (QAR)"
                                            class="body-font-4 d-block text-gray-900 rt-mb-8" for="expected_salary" />
                                        <input type="number" name="expected_salary" class="form-control" required
                                            min="1000" value="" placeholder="Salary per month">
                                    </div>





                                    <div class="col-lg-12 rt-mb-15">



                                        <div>
                                            <h6 class="resume">{{ __('your_cv_resume') }}<span
                                                    class="form-label-required text-danger">*</span>

                                                <div class="form-text text-muted"> <span class="help-icon"
                                                        text="Acccepted file types (PDF,DOC,DOCX, JPG) with maximum 5 MB. You can add/replace later.">?</span>
                                                </div>
                                            </h6>
                                            @if ($errors->has('resume_name') || $errors->has('resume_file'))
                                            <div class="alert alert-danger" role="alert">
                                                @error('resume_name')
                                                <span class="d-block"><strong>{{ $message }}</strong></span>
                                                @enderror
                                                @error('resume_file')
                                                <span class="d-block"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            @endif
                                            <div class="resume-listsx">
                                                <input type="file" required
                                                    class="form-control @error('file_upload') is-invalid @enderror"
                                                    name="file_upload" id="file_upload" />
                                                <style>
                                                    #file_upload {
                                                        position: relative !important;
                                                        opacity: 1;
                                                    }

                                                    .is-invalid {
                                                        border-color: red;
                                                    }
                                                </style>
                                                <x-forms.input type="hidden" name="resume_name" value="MyResume"
                                                    type="hidden" placeholder="My Resume" />

                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </section>






                            @if (config('captcha.active'))
                            <div class="rt-mb-15">
                                <div class="g-custom-css">
                                    {!! NoCaptcha::display() !!}
                                </div>
                                @if ($errors->has('g-recaptcha-response'))
                                <span class="text-danger text-sm">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                                @endif
                            </div>
                            @endif
                            <div class="rt-mb-30">
                                <div class="form-check from-chekbox-custom align-items-center">
                                    <input type="checkbox" id="term" class="form-check-input" value="1" required>
                                    <label class="form-check-label pointer text-gray-700 f-size-14">
                                        {{ __('i_have_read_and_agree_with') }}
                                    </label>
                                    <a href="{{ url('terms-condition') }}" target="_blank"
                                        class="body-font-4 text-primary-500">
                                        {{ __('terms_of_service') }}
                                    </a>
                                </div>

                            </div>
                            <button type="submit" id="submitButton" class="btn btn-primary d-block rt-mb-15">
                                <span class="button-content-wrapper ">
                                    <span class="button-icon align-icon-right">
                                        <x-svg.rightarrow-icon />
                                    </span>
                                    <span class="button-text">
                                        Submit CV
                                    </span>
                                </span>
                            </button>


                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="rt-spacer-100 rt-spacer-md-50"></div>
    </div>




</div>
<!-- The Modal -->
<div id="ModalBtn" class="modal">
    <div class="row justify-content-center m-2 mt-5 pt-5">
        <div class="col-sm-12 col-lg-4">
            <div class="rt-rounded-12">
                <div class="card border border-gray-500">
                    <div class="card-header bg-primary text-white font-size-25">
                        {{ __('select_one') }}
                    </div>
                    <form id="LoginFormHit" class="d-inline justify-content-center" method="GET">
                        <div class="card-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('employer_or_candidate') }}</label>
                                    <select name="user" class="form-controll rounded" id="">
                                        <option value="candidate">{{ __('candidate') }}</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button type="button" onclick="CloseModoal()" class="close btn btn-danger">
                                <div class="button-content-wrapper ">
                                    <span class="button-text">
                                        {{ __('cancel') }}
                                    </span>
                                </div>
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <div class="button-content-wrapper ">
                                    <span class="button-text">
                                        {{ __('register_now') }}
                                    </span>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




@section('script')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
        function LoginService(value) {
            $("#ModalBtn").css("display", "block");
            var action = "auth/" + value + "/redirect";
            $("#LoginFormHit").attr("action", action);
        }

        function CloseModoal() {
            $("#ModalBtn").css("display", "none");
        }
    </script>
   <script>
    $(document).ready(function() {
        validate();
        $('#name, #email, #password, #password_confirmation, #file_upload, #phone, #term').on('keyup', validate);
        $('#name').on('change', validateName);
        $('#email').on('change', validateEmail);
        $('#phone').on('change', validatePhone);
        $('#password').on('change', validatePassword);
        $('#password_confirmation').on('change', validatePasswordConfirmation);
        

    });

function validateName() {
    var name = $('#name');
    if (name.val().length < 4 || !/^[a-zA-Z ]+$/.test(name.val())) {
        name.addClass('is-invalid');
    } else {
        name.removeClass('is-invalid');
    }
}

    
    function validateEmail() {
  var email = $('#email');
  if (!isValidEmail(email.val())) {
    email.addClass('is-invalid');
  } else {
    email.removeClass('is-invalid');
  }
}

function isValidEmail(email) {
  // Email validation regex pattern
  var regex = /^\S+@\S+\.\S+$/;
  return regex.test(email);
}

function validatePhone() {
    var phone = $('#phone');
    if (phone.val().length < 8 || !/^\+?\d+$/.test(phone.val())) {
        phone.addClass('is-invalid');
    } else {
        phone.removeClass('is-invalid');
    }
}

function validatePassword() {
  var password = $('#password').val();
  if (password.length < 8 || !hasValidPassword(password)) {
    $('#password').addClass('is-invalid');
  } else {
    $('#password').removeClass('is-invalid');
  }
}
function hasValidPassword(str) {
  // Password should contain at least one lowercase letter, one uppercase letter, one number, and one special character
  var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}$/;
  return regex.test(str);
}

function validatePasswordConfirmation() {
    var password = $('#password').val();
    var password_confirmation = $('#password_confirmation').val();

    if (password !== password_confirmation || !hasValidPassword(password_confirmation)) {
        $('#password_confirmation').addClass('is-invalid');
    } else {
        $('#password_confirmation').removeClass('is-invalid');
    }
}

function validate() {
  if ($('#name').val().length >= 4 &&
      $('#email').val().length > 0 &&
      $('#password').val().length > 8 &&
      $('#password_confirmation').val().length > 8 &&
      $('#term').val().length > 0 &&
      $('#phone').val().length > 0  ) {
     $('#submitButton').attr('disabled', false);
  } else {
    $('#submitButton').attr('disabled', true);
  }
}  

    function passToText(id, icon) {
        var input = $('#' + id);
        var eyeIcon = $('#' + icon);
        if (input.is('input[type="password"]')) {
            eyeIcon.html('<i class="ph-eye-slash @error('password') m-3 @enderror"></i>');
            input.attr('type', 'text');
        } else {
            eyeIcon.html('<i class="ph-eye @error('password') m-3 @enderror"></i>');
            input.attr('type', 'password');
        }
    }
</script>

@endsection
 


@section('frontend_links')
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/bootstrap-datepicker.min.css">
     <!-- >=>Leaflet Map<=< -->
     <x-map.leaflet.map_links/>
     <x-map.leaflet.autocomplete_links/>

    <style>
    
    .font-size-25 {
            font-size: 25px !important;
        }
        .ck-editor__editable_inline {
            min-height: 300px;
        }

        .w-100-percent {
            width: 100% !important;
        }

        #jobrole #basic-addon1 {
            width: 50px !important;
            margin-left: 28px !important;
        }

        .border-cutom {
            border-radius: 5px 0 0 5px !important;
        }

        .input-group-text-custom {
            max-height: 48px;
            padding: 12px;
            background-color: #e9ecef;
            border-radius: 0 5px 5px 0;
        }

        .has-badge-cutom {
            top: 34% !important;
        }
    </style>

    <!-- >=>Mapbox<=< -->
    @include('map::links')
    <!-- >=>Mapbox<=< -->
    <style>
        .mymap {
            border-radius: 12px;
            z-index: 999;
        }
        
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    <style>
        // ... existing styles ...
        
        /* IntlTelInput Custom Styles */
        .iti {
            width: 100%;
            position: relative;
            z-index: 1000;
        }
        
        .iti__country-list {
            position: absolute;
            z-index: 1001;
            width: 300px;
        }
        
        .iti__flag-container {
            z-index: 1001;
        }
        
        .iti--separate-dial-code .iti__selected-flag {
            background-color: #f8f9fa;
            border-radius: 4px 0 0 4px;
        }
        
        .iti--separate-dial-code .iti__selected-dial-code {
            color: #333;
        }
        
        .iti__country-list {
            border-radius: 4px;
            margin-top: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,.15);
        }
        
        .iti__search-container {
            padding: 10px;
            background: #fff;
            position: sticky;
            top: 0;
            z-index: 1002;
        }
        
        .phone-error-message {
            color: #dc3545;
            font-size: 80%;
            margin-top: 4px;
            display: none;
        }
    </style>
@endsection

@section('frontend_scripts')
    <script src="{{ asset('frontend/assets/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('frontend') }}/assets/js/ckeditor.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Phone input initialization
            const phoneInputField = document.querySelector("#phone");
            const errorMsg = document.createElement('div');
            errorMsg.className = 'phone-error-message';
            phoneInputField.parentNode.appendChild(errorMsg);

            const phoneInput = window.intlTelInput(phoneInputField, {
                preferredCountries: ["qa", "ae", "sa", "kw", "bh", "om"],
                separateDialCode: true,
                initialCountry: "qa",
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
                formatOnDisplay: true,
                autoPlaceholder: "polite",
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    return "e.g. " + selectedCountryPlaceholder;
                }
            });

            const reset = () => {
                phoneInputField.classList.remove("is-invalid");
                errorMsg.style.display = "none";
            };

            // Validation function
            const validatePhone = () => {
                reset();
                if (phoneInputField.value.trim()) {
                    if (phoneInput.isValidNumber()) {
                        phoneInputField.classList.remove("is-invalid");
                        errorMsg.style.display = "none";
                        // Store the full number with country code
                        document.querySelector("input[name='prefixphone']").value = phoneInput.getNumber();
                        return true;
                    } else {
                        phoneInputField.classList.add("is-invalid");
                        const errorCode = phoneInput.getValidationError();
                        let errorMessage = "";
                        switch (errorCode) {
                            case intlTelInputUtils.validationError.INVALID_COUNTRY_CODE:
                                errorMessage = "Invalid country code";
                                break;
                            case intlTelInputUtils.validationError.TOO_SHORT:
                                errorMessage = "Phone number is too short";
                                break;
                            case intlTelInputUtils.validationError.TOO_LONG:
                                errorMessage = "Phone number is too long";
                                break;
                            case intlTelInputUtils.validationError.NOT_A_NUMBER:
                                errorMessage = "Invalid phone number";
                                break;
                            default:
                                errorMessage = "Invalid phone number format";
                        }
                        errorMsg.textContent = errorMessage;
                        errorMsg.style.display = "block";
                        return false;
                    }
                }
                return false;
            };

            // Event listeners
            phoneInputField.addEventListener('blur', validatePhone);
            phoneInputField.addEventListener('change', validatePhone);
            phoneInputField.addEventListener('keyup', validatePhone);
            
            // Country change event
            phoneInput.promise.then(function() {
                phoneInputField.addEventListener('countrychange', function() {
                    validatePhone();
                });
            });

            // Update the main form validation
            const form = document.getElementById('formId');
            form.addEventListener('submit', function(e) {
                const isPhoneValid = validatePhone();
                if (!isPhoneValid) {
                    e.preventDefault();
                }
            });
        });

        // Rest of your existing scripts...
        function UploadMode(param) {
            if (param === 'photo') {
                $('#photo-uploadMode').removeClass('d-none');
                $('#photo-oldMode').addClass('d-none');
            } else {
                $('#banner-uploadMode').removeClass('d-none');
                $('#banner-oldMode').addClass('d-none');
            }
        }
        //init datepicker
        $("#date").attr("autocomplete", "off");
        //init datepicker
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            startDate: '-100y',
            endDate: '-18y'
        });
    </script>
    <script>
        
        $('#visibility').on('change', function() {
            $(this).submit();
        });
        $('#alert').on('change', function() {
            $(this).submit();
        });

        function AccountDelete() {
            if (confirm("Are you sure ??") == true) {
                $('#AccountDelete').submit();
            } else {
                return false;
            }
        }

        function resumeDelete() {
            if (confirm("Are you sure ?") == true) {
                $('#resumeForm').submit();
            } else {
                return false;
            }
        }

        function editResume(id, name, size) {
            $('#resume_id_input').val(id);
            $('#resume_name_input').val(name);
            $('#resume_file_size').html(size);
            $('#resumeEditModal').modal('show');
        }
        $('.cv-remove-image').on('click', function() {
            $('.resume-file-upload-input').replaceWith($('.resume-file-upload-input').clone());
            $('.resume-file-upload-content').hide();
            $('.cv-image-upload-wrap').show();
            $('.resume-file-upload-input').val('');
        })

        function resumeManageReadURL(input, type) {
            if (type == 'add') {
                var fileName = document.querySelector('#resume_add_input').files[0].name;
                var fileSize = document.querySelector('#resume_add_input').files[0].size / 1024 / 1024;
                var fileType = document.querySelector('#resume_add_input').files[0].type;
            } else {
                var fileName = document.querySelector('#resume_edit_input').files[0].name;
                var fileSize = document.querySelector('#resume_edit_input').files[0].size / 1024 / 1024;
                var fileType = document.querySelector('#resume_edit_input').files[0].type;
            }
            $('.resume_selected_file_name').html(fileName);
            $('.resume_selected_file_size').html(fileSize.toFixed(4));
            $('.resume_selected_file_type').html(fileType);
            if (input.files && input.files[0]) {
                console.log(input.className)
                var reader = new FileReader();
                reader.onload = function(e) {
                    if (input.className === 'profile-file-upload-input') {
                        $('.profile-image-upload-wrap').hide();
                        $('.profile-file-upload-image').attr('src', e.target.result);
                        $('.profile-file-upload-content').show();
                        // $('.image-title').html(input.files[0].name);
                    }
                    if (input.className === 'banner-file-upload-input') {
                        $('.banner-image-upload-wrap').hide();
                        $('.banner-file-upload-image').attr('src', e.target.result);
                        $('.banner-file-upload-content').show();
                        // $('.image-title').html(input.files[0].name);
                    }
                    if (input.className === 'resume-file-upload-input') {
                        $('.cv-image-upload-wrap').hide();
                        $('.resume-file-upload-content.none').show();
                    }
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                $('.profile-remove-image').on('click', function() {
                    // console.log(this.className)
                    $('.profile-file-upload-input').replaceWith($('.profile-file-upload-input').clone());
                    $('.profile-file-upload-content').hide();
                    $('.profile-file-upload-image').attr('src', '');
                    $('.profile-image-upload-wrap').show();
                })
                $('.banner-remove-image').on('click', function() {
                    // console.log(this.className)
                    $('.banner-file-upload-input').replaceWith($('.banner-file-upload-input').clone());
                    $('.banner-file-upload-content').hide();
                    $('.banner-file-upload-image').attr('src', '');
                    $('.banner-image-upload-wrap').show();
                })
            }
        }
        setTimeout(function() {
            {{ session()->forget('type') }}
        }, 10000);
        
        
    </script>

    
   
    <script type="text/javascript">
        // feature field
        function add_features_field() {
            $("#multiple_feature_part").append(`
        <div class="col-12 custom-select-padding">
            <div class="d-flex">
                <div class="d-flex mborder">
                    <div class="position-relative">
                        <select
                            class="w-100-p border-0 rt-selectactive form-control" name="social_media[]">
                            <option value="" class="d-none" disabled selected>{{ __('select_one') }}</option>
                            <option value="facebook">{{ __('facebook') }}</option>
                            <option value="twitter">{{ __('twitter') }}</option>
                            <option value="instagram">{{ __('instagram') }}</option>
                            <option value="youtube">{{ __('youtube') }}</option>
                            <option value="linkedin">{{ __('linkedin') }}</option>
                            <option value="pinterest">{{ __('pinterest') }}</option>
                            <option value="reddit">{{ __('reddit') }}</option>
                            <option value="github">{{ __('github') }}</option>
                            <option value="other">{{ __('other') }}</option>
                        </select>
                    </div>
                    <div class="w-100">
                        <input class="border-0" type="url" name="url[]" id="" placeholder="{{ __('profile_link_url') }}...">
                    </div>
                </div>
                <div class="ms-2">
                    <button type="button" class="btn tw-bg-[#F1F2F4] tw-p-[13px]"  id="remove_item">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" stroke="#18191C" stroke-width="1.5" stroke-miterlimit="10"/>
                            <path d="M15 9L9 15" stroke="#18191C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M15 15L9 9" stroke="#18191C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `);
            $(".rt-selectactive").select2({ // minimumResultsForSearch: Infinity,
            });
        }
        $(document).on("click", "#remove_item", function() {
            $(this).parent().parent().parent('div').remove();
        });
    </script>
    
<script>
function checkEmailExists() {
    let emailInput = document.getElementById('email');
    let emailError = document.getElementById('email-error');
    let email = emailInput.value;

    // Make sure the email input is not empty
    if (email.trim() !== '') {
        fetch('{{ route('check.email') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: email })
        })
        .then(function(response) {
            if (response.ok) {
                return response.json(); // Parse the response as JSON
            } else {
                throw new Error('Request failed with status: ' + response.status); // Throw an error for other error cases
            }
        })
        .then(function(data) {
            if (data.exists) {
                // If the email exists
                emailInput.classList.add('is-invalid');
                emailError.classList.remove('d-none');
                emailError.innerText = 'This email is already registered.';
                submitButton.disabled = true;
            } else {
                // If the email is available
                emailInput.classList.remove('is-invalid');
                emailError.classList.add('d-none');
                emailError.innerText = 'This email is available.';
                submitButton.disabled = false;
            }
        })
        .catch(function(error) {
            // Handle any errors that occur during the request
            console.error(error);
        });
    }
}




$(document).ready(function() {
    $('.single').select2();
});




</script>



<script>
    function initAutocomplete() {
        var input = document.getElementById('currentLocationInput');
        var latInput = document.getElementById('currentLocationLat');
        var lngInput = document.getElementById('currentLocationLng');
        var countryInput = document.getElementById('currentCountryInput');
        var regionInput = document.getElementById('currentRegionInput');

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.setFields(['address_component', 'geometry']);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();

            if (place.geometry && place.geometry.location) {
                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();

                latInput.value = lat;
                lngInput.value = lng;

                // Get country and region from address components
                var country = '';
                var region = '';

                place.address_components.forEach(function(component) {
                    if (component.types.includes('country')) {
                        country = component.long_name;
                    }
                    if (component.types.includes('administrative_area_level_1')) {
                        region = component.long_name;
                    }
                });

                countryInput.value = country;
                regionInput.value = region;

                // You can now use the country, region, lat, and lng values as needed
                console.log('Country:', country);
                console.log('Region:', region);
                console.log('Latitude:', lat);
                console.log('Longitude:', lng);
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ $setting->google_map_key }}&libraries=places&callback=initAutocomplete" async defer></script>


<style>.help-icon {
    display: inline-block;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background-color: #ccc;
    text-align: center;
    line-height: 16px;
    cursor: pointer;
    position: relative; /* Add this line */
}

.help-icon:hover::after {
    content: attr(text);
    position: absolute;
    bottom: calc(100% + 8px); /* Update this line */
    left: 0;
    width: max-content;
    padding: 8px;
    background-color: #333;
    color: #fff;
    font-size: 14px;
    border-radius: 4px;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s, visibility 0.3s;
    z-index: 5;
}

.help-icon:hover::after {
    opacity: 1;
    visibility: visible;
}


.text-muted { 
    display: inline-grid;
}

</style>
@endsection
