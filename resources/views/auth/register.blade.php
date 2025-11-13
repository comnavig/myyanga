@extends('layouts.auth')
@section('title', 'Sign up')
@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 col-sm-12 py-4" style="margin-top: 10%; background-color: rgba(21,21,21,.68);">
           <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right gold">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label text-md-right gold">{{ __('Mobile') }}</label>

                            <div class="col-md-6">
                                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" autofocus>

                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="whatsapp" class="col-md-4 col-form-label text-md-right gold">Whatsapp</label>

                            <div class="col-md-6">
                                <input id="whatsapp" type="text" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" value="{{ old('whatsapp') }}" required autocomplete="whatsapp" autofocus>

                                @error('whatsapp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right gold">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right gold">{{ __('Type of Account') }}</label>

                            <div class="col-md-6">
								<label class="col-form-label gold" for="indType">
									<input class="" type="radio" name="type" id="indType" value="individual" {{ ( old("type") == "individual" ? "checked" : "" ) }} /> 
									Individual
								</label>
								<label class="col-form-label gold" for="busType">
									<input class="" type="radio" name="type" id="busType" value="business"{{ ( old("type") == "business" ? "checked" : "" ) }} />
									Business
								</label>
							  

                                @error('type')
                                    <span class="invalid-feedback gold" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right  gold">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right gold">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn main-color-bg">
                                    {{ __('Register') }}
                                </button>
                                
                                <a class="btn btn-link  gold" href="{{ route('login') }}">
									Already Registered
								</a>
                            </div>
                        </div>
                    </form>
        </div>
</div> --}}


<section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center h-100">
        <div class="col-md-8 col-lg-7 col-xl-6">
          <img src="{{ asset('assets/img/african-women.jpg') }}" style="height: 450px"
            class="img-fluid" alt="Phone image">
        </div>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">

          <form method="POST" action="{{ route('register') }}">

            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; font-weight:900; font-size: 25px">Sign Up</h3>
            @csrf

            {{-- Name input --}}

            <div class="form-outline mb-4">
                <!--label class="form-label" for="email">{{ __('Name') }}</label-->
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror form-control-lg" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Enter Name" autofocus />
                @error('name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div>

            {{-- Mobile Input --}}

            <div class="form-outline mb-4">
                <!--label class="form-label" for="email">{{ __('Mobile') }}</label-->
                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror form-control-lg" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" placeholder="Enter Mobile" autofocus />
                @error('mobile')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div>
            
            <div class="form-outline mb-4">
                <!--label class="form-label" for="email">{{ __('Mobile') }}</label-->
                <input id="whatsapp" type="text" class="form-control @error('whatsapp') is-invalid @enderror form-control-lg" name="whatsapp" value="{{ old('whatsapp') }}" required autocomplete="whatsapp" placeholder="Enter Whatsapp Number" autofocus />
                @error('whatsapp')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div>

            <!-- Email input -->
            <div class="form-outline mb-4">
              <!--label class="form-label" for="email">{{ __('E-Mail Address') }}</label-->
              <input id="email" type="email" type="email" class="form-control @error('email') is-invalid @enderror form-control-lg" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address" autofocus />
              @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="form-outline mb-4">
                <!--label for="type" class="form-label" >{{ __('Type of Account') }}</label-->

                <div class="col-md-6">
                    <label class="col-form-label black" for="indType">
                        <input class="" type="radio" name="type" id="indType" value="individual" {{ ( old("type") == "individual" ? "checked" : "" ) }} /> 
                        Individual
                    </label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label class="col-form-label black" for="busType">
                        <input class="" type="radio" name="type" id="busType" value="business"{{ ( old("type") == "business" ? "checked" : "" ) }} />
                        Business
                    </label>
                  

                    @error('type')
                        <span class="invalid-feedback gold" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
  
            <!-- Password input -->
            <div class="form-outline mb-4">
              <!--label class="form-label" for="password">{{ __('Password') }}</label-->
              <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror rounded-0" name="password" placeholder="Password" required autocomplete="current-password" />
              @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <!--label class="form-label" for="password-confirm">{{ __('Confirm Password') }}</label-->
                <input id="password-confirm" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror rounded-0" name="password_confirmation" placeholder="Confirm Password" required autocomplete="current-password" />
                @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div>
  
            
            <!--This is google captcha implemented by JTMax on 17/06/2025-->
                        <div class="form-group mb-4">
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                            @endif
                        </div>
                        
            <!--End of captcha-->
  
            <!-- Submit button -->
            <button type="submit" class="btn main-color-bg btn-lg btn-block">{{ __('Register') }}</button>

            Already have an Account ? <a style="color: #85000b" href="{{ route('login') }}">
                login
              </a>
  
              <br>
              <br>
              <br>
              <br>
              <br>
              
              <div style="margin-bottom: 20px;margin-top: 20px;"></div>
              
            {{-- <div class="divider d-flex align-items-center my-4">
              <p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p>
            </div>
  
            <a class="btn btn-primary btn-lg btn-block" style="background-color: #3b5998" href="#!"
              role="button">
              <i class="fab fa-facebook-f me-2"></i>Continue with Facebook
            </a>
            <a class="btn btn-primary btn-lg btn-block" style="background-color: #55acee" href="#!"
              role="button">
              <i class="fab fa-twitter me-2"></i>Continue with Twitter</a> --}}
  
          </form>
        </div>
      </div>
    </div>
</section>
<br><br><br>

@endsection

@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
