@extends('layouts.auth')
@section('title', 'Login')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 col-sm-12" style="margin-top: 20%; background-color: rgba(21,21,21,.68);">
				<form method="POST" action="{{ route('login',['redirect' => $_REQUEST['redirect'] ?? '' ]) }}">
                        @csrf

                        <div class="form-group row my-3">
<!--
                            <label for="email" class="col-md-12 col-form-label text-md-right white">{{ __('E-Mail Address') }}</label>
-->

                            <div class="col-sm-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror rounded-0" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row my-3">
<!--
                            <label for="password" class="col-md-12 col-form-label text-md-right">{{ __('Password') }}</label>
-->

                            <div class="col-sm-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror rounded-0" name="password" placeholder="Password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row my-3">
                            <div class="col-sm-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label gold" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        @if (Route::has('password.request'))
                        <div class="form-group row my-3">
                            <div class="col-md-12">
                                <div class="">
                                    <a class="btn btn-link gold m-0 p-0" href="{{ route('password.request') }}">
										{{ __('Forgot Your Password?') }}
									</a>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="form-group row my-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn main-color-bg">
                                    {{ __('Login') }}
                                </button>

                                
									<a class="btn btn-link gold" href="{{ route('register') }}">
                                        Sign Up
                                    </a>
                            </div>
                        </div>
                 </form>
        </div>
    </div>
</div>
@endsection
