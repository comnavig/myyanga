@extends('layouts.auth')
@section('title', 'Login')
@section('content')

<section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center h-100">
        <div class="col-md-8 col-lg-7 col-xl-6">
          <img src="{{ asset('assets/img/african-women.jpg') }}" style="height: 450px"
            class="img-fluid" alt="Phone image">
        </div>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">

          
          <form method="POST" action="{{ route('login',['redirect' => $_REQUEST['redirect'] ?? '' ]) }}">

            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; font-weight:900; font-size: 25px">Log in</h3>

            @csrf
            <!-- Email input -->
            <div class="form-outline mb-4">
              <input id="email" type="email" type="email" class="form-control @error('email') is-invalid @enderror form-control-lg" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address" autofocus />
              <!--label class="form-label" for="email">{{ __('E-Mail Address') }}</label-->
              @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
  
            <!-- Password input -->
            <div class="form-outline mb-4">
              <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password" />
              <!--label class="form-label" for="password">{{ __('Password') }}</label-->
              @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
  
            <div class="d-flex align-items-left mb-4">
              <!-- Checkbox -->
              <div class="custom-control custom-checkbox checkbox-xl">
                  <input type="checkbox" name="remember" class="custom-control-input" id="remember" {{ old('remember') ? 'checked' : '' }}>
                  <label class="custom-control-label" for="remember">Remember me</label>
              </div>
              
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
              
              <a style="color: #85000b" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
              </a>
              <a style="color: #85000b" href="{{ route('register') }}">
                {{ __('Register') }}
              </a>
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
            <button type="submit" class="btn main-color-bg btn-lg btn-block">{{ __('Login') }}</button>
            <br />
            <br /><br /><br /><br />
            &nbsp;  
          </form>
        </div>
      </div>
    </div>
</section>


@endsection

@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush


@push('styles')
    <style>
        .divider:after,
.divider:before {
content: "";
flex: 1;
height: 1px;
background: #eee;
}
    .form-control:focus {
        border-color: #85000b;
    }

    .log-inpage-log-inpage {
  width: 1440px;
  height: 1024px;
  display: flex;
  overflow: hidden;
  position: relative;
  max-width: 1440px;
  box-sizing: border-box;
  align-items: flex-start;
  border-color: transparent;
  background-color: rgba(255, 255, 255, 1);
}
.log-inpage-footer {
  top: 947px;
  left: 0px;
  width: 1440px;
  height: 77px;
  display: flex;
  position: absolute;
  box-sizing: border-box;
  align-items: flex-start;
  flex-shrink: 1;
  border-color: transparent;
  background-color: rgba(255, 255, 255, 1);
}
.log-inpage-svg {
  top: 28px;
  left: 1335px;
  width: 22;
  height: 22;
  position: absolute;
}
.log-inpage-svg1 {
  top: 28px;
  left: 1221px;
  width: 22;
  height: 22;
  position: absolute;
}
.log-inpage-svg2 {
  top: 28px;
  left: 1277px;
  width: 24;
  height: 24;
  position: absolute;
}
.log-inpage-text {
  top: 23px;
  left: 33px;
  color: rgba(0, 0, 0, 1);
  height: auto;
  position: absolute;
  font-size: 23px;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-family: Garamond;
  font-weight: 400px;
  line-height: normal;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text01 {
  color: rgba(0, 0, 0, 1);
  height: auto;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-weight: 400px;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text02 {
  color: rgba(136, 0, 11, 1);
  height: auto;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-weight: 700px;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text03 {
  color: rgba(0, 0, 0, 1);
  height: auto;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-weight: 400px;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text04 {
  color: rgba(148, 0, 14, 1);
  height: auto;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-weight: 400px;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text05 {
  color: rgba(0, 0, 0, 1);
  height: auto;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-weight: 400px;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text06 {
  color: rgba(146, 0, 13, 1);
  height: auto;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-weight: 400px;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text07 {
  color: rgba(0, 0, 0, 1);
  height: auto;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-weight: 400px;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text08 {
  color: rgba(136, 0, 11, 1);
  height: auto;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-weight: 400px;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text09 {
  color: rgba(0, 0, 0, 1);
  height: auto;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-weight: 400px;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text10 {
  color: rgba(146, 0, 13, 1);
  height: auto;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-weight: 400px;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text11 {
  color: rgba(0, 0, 0, 1);
  height: auto;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-weight: 400px;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text12 {
  color: rgba(136, 0, 11, 1);
  height: auto;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-weight: 400px;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-navigationbar {
  top: 0px;
  left: 0px;
  width: 1440px;
  height: 101px;
  display: flex;
  position: absolute;
  box-sizing: border-box;
  align-items: flex-start;
  flex-shrink: 1;
  border-color: transparent;
  background-color: rgba(255, 255, 255, 1);
}
.log-inpage-text13 {
  top: 43px;
  left: 1333px;
  color: rgba(19, 18, 18, 1);
  width: 95px;
  height: auto;
  position: absolute;
  font-size: 16px;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-family: Raleway;
  font-weight: 700px;
  line-height: normal;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text14 {
  top: 48px;
  left: 727px;
  color: rgba(220, 156, 0, 1);
  width: 112px;
  height: auto;
  position: absolute;
  font-size: 17px;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-family: Raleway;
  font-weight: 600px;
  line-height: normal;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text15 {
  top: 48px;
  left: 644px;
  color: rgba(220, 156, 0, 1);
  width: 87px;
  height: auto;
  position: absolute;
  font-size: 17px;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-family: Raleway;
  font-weight: 600px;
  line-height: normal;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text16 {
  top: 48px;
  left: 824px;
  color: rgba(220, 156, 0, 1);
  width: 102px;
  height: auto;
  position: absolute;
  font-size: 17px;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-family: Raleway;
  font-weight: 600px;
  line-height: normal;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text17 {
  top: 48px;
  left: 286px;
  color: rgba(19, 18, 18, 0.5);
  width: 112px;
  height: auto;
  position: absolute;
  font-size: 18px;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-family: Raleway;
  font-weight: 500px;
  line-height: normal;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text18 {
  top: 48px;
  left: 914px;
  color: rgba(220, 156, 0, 1);
  width: 162px;
  height: auto;
  position: absolute;
  font-size: 17px;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-family: Raleway;
  font-weight: 600px;
  line-height: normal;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text19 {
  top: 44px;
  left: 1221px;
  color: rgba(19, 18, 18, 1);
  width: 99px;
  height: auto;
  position: absolute;
  font-size: 16px;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-family: Raleway;
  font-weight: 700px;
  line-height: normal;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-rectangle3467524 {
  top: 27px;
  left: 18px;
  width: 205px;
  height: 61px;
  position: absolute;
  box-sizing: border-box;
  object-fit: cover;
  border-color: transparent;
}
.log-inpage-rectangle3467526 {
  top: 39px;
  left: 260px;
  width: 349px;
  height: 49px;
  position: absolute;
  box-sizing: border-box;
  object-fit: cover;
  border-color: rgba(0, 0, 0, 0.6000000238418579);
  border-style: solid;
  border-width: 1px;
  border-radius: 5px;
}
.log-inpage-svg3 {
  top: 53px;
  left: 286px;
  width: 20;
  height: 20;
  position: absolute;
}
.log-inpage-svg4 {
  top: 59px;
  left: 1210px;
  width: 23;
  height: 20;
  position: absolute;
}
.log-inpage-svg5 {
  top: 58px;
  left: 1138px;
  width: 25;
  height: 22;
  position: absolute;
}
.log-inpage-svg6 {
  top: 47px;
  left: 1126px;
  width: 12;
  height: 12;
  position: absolute;
}
.log-inpage-personcircle {
  top: 58px;
  left: 1323px;
  width: 23px;
  height: 23px;
  position: absolute;
  box-sizing: border-box;
  object-fit: cover;
  border-color: transparent;
}
.log-inpage-body {
  top: 304px;
  left: 613.9464111328125px;
  width: 571px;
  height: 466px;
  display: flex;
  position: absolute;
  box-sizing: border-box;
  align-items: flex-start;
  flex-shrink: 1;
  border-color: transparent;
}
.log-inpage-text20 {
  top: 108.87625122070312px;
  left: 2.107790470123291px;
  color: rgba(146, 0, 13, 1);
  width: 84px;
  height: auto;
  position: absolute;
  font-size: 20px;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-family: Raleway;
  font-weight: 700px;
  line-height: normal;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text21 {
  top: 220.876220703125px;
  left: 0.10779047012329102px;
  color: rgba(146, 0, 13, 1);
  width: 122px;
  height: auto;
  position: absolute;
  font-size: 20px;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-family: Raleway;
  font-weight: 700px;
  line-height: normal;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-text22 {
  top: 0px;
  left: 39.053592681884766px;
  color: rgba(0, 0, 0, 1);
  width: 137px;
  height: auto;
  position: absolute;
  font-size: 33px;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-family: Raleway;
  font-weight: 700px;
  line-height: normal;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-email {
  top: 107px;
  left: 140.0535888671875px;
  width: 431px;
  height: 58px;
  display: flex;
  position: absolute;
  box-sizing: border-box;
  align-items: flex-start;
  border-color: transparent;
}
.log-inpage-rectangle3467538 {
  top: 0px;
  left: 0px;
  width: 431px;
  height: 58px;
  position: absolute;
  box-sizing: border-box;
  object-fit: cover;
  border-color: rgba(0, 0, 0, 0.4000000059604645);
  border-style: solid;
  border-width: 1px;
  border-radius: 4px;
  background-color: rgba(217, 217, 217, 0.10000000149011612);
}
.log-inpage-password {
  top: 213px;
  left: 140.0535888671875px;
  width: 431px;
  height: 58px;
  display: flex;
  position: absolute;
  box-sizing: border-box;
  align-items: flex-start;
  border-color: transparent;
}
.log-inpage-rectangle3467539 {
  top: 0px;
  left: 0px;
  width: 431px;
  height: 58px;
  position: absolute;
  box-sizing: border-box;
  object-fit: cover;
  border-color: rgba(0, 0, 0, 0.4000000059604645);
  border-style: solid;
  border-width: 1px;
  border-radius: 4px;
  background-color: rgba(217, 217, 217, 0.10000000149011612);
}
.log-inpage-loginbtn {
  top: 350px;
  left: 144.0535888671875px;
  width: 194px;
  height: 58px;
  display: flex;
  position: absolute;
  box-sizing: border-box;
  align-items: flex-start;
  border-color: transparent;
}
.log-inpage-rectangle3467541 {
  top: 0px;
  left: 0px;
  width: 194px;
  height: 58px;
  position: absolute;
  box-sizing: border-box;
  object-fit: cover;
  border-color: rgba(0, 0, 0, 0.4000000059604645);
  border-style: solid;
  border-width: 1px;
  border-radius: 15px;
  background-color: rgba(146, 0, 13, 1);
}
.log-inpage-text23 {
  top: 4px;
  left: 55px;
  color: rgba(255, 255, 255, 1);
  width: 84px;
  height: auto;
  position: absolute;
  font-size: 20px;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-family: Raleway;
  font-weight: 700px;
  line-height: normal;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-forgotpassword {
  top: 441px;
  left: 140.0535888671875px;
  width: 198px;
  height: 25px;
  display: flex;
  position: absolute;
  box-sizing: border-box;
  align-items: flex-start;
  border-color: transparent;
}
.log-inpage-text24 {
  top: 0px;
  left: 0px;
  color: rgba(146, 0, 13, 0.6100000143051147);
  width: 198px;
  height: auto;
  position: absolute;
  font-size: 20px;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-family: Raleway;
  font-weight: 600px;
  line-height: normal;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-remenberme {
  top: 298px;
  left: 144.0535888671875px;
  width: 183px;
  height: 25px;
  display: flex;
  position: absolute;
  box-sizing: border-box;
  align-items: flex-start;
  border-color: transparent;
}
.log-inpage-text25 {
  top: 0px;
  left: 24px;
  color: rgba(0, 0, 0, 1);
  width: 159px;
  height: auto;
  position: absolute;
  font-size: 20px;
  align-self: auto;
  font-style: normal;
  text-align: center;
  font-family: Raleway;
  font-weight: 600px;
  line-height: normal;
  font-stretch: normal;
  text-decoration: none;
}
.log-inpage-b-g {
  top: 0px;
  left: 0px;
  width: 25px;
  height: 25px;
  position: absolute;
  box-sizing: border-box;
  object-fit: cover;
  border-color: rgba(217, 217, 217, 1);
  border-style: solid;
  border-width: 1px;
  border-radius: 4px;
  background-color: rgba(217, 217, 217, 1);
}

    </style>
@endpush
