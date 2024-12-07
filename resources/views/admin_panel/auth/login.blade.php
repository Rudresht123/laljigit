{{-- extending master layout here --}}
@extends('admin_panel.comman.authmaster')
{{-- extending master layout here --}}

{{-- main section start here --}}
@section('authContent')
<div class="p-0 p-md-3 content-auth" style="background-image: url('{{ asset('assets/newimage/bg-app.jpg') }}'); background-size: 100% 100vh; min-height: 100vh;">
    <div class="container">
        <div class="loginContainer media align-items-stretch justify-content-center ht-100p pos-relative">
            <div class="media-body align-items-center d-none d-lg-flex">
                <div class="mx-wd-100 border">
                    <img src="{{ asset('assets/newimage/lalji.png') }}" class="img-fluid" alt="">
                </div>
            </div>
            <div class="divider-text divider-vertical "></div>
            <div class="sign-wrapper mg-lg-l-20 mg-xl-l-20 animated bounce">
                <div class="wd-100p">
                    <div class="class mb-4 d-flex fw-bold">
                        <span class="fs-3">Intellectual Property Service</span>
                    </div>
                    <h3 class="tx-color-01 mg-b-5">Sign In</h3>
                    <p class="tx-color-03 tx-16 mg-b-3 fs-10">Welcome back! Please sign in to continue.</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" id="email" class="form-control" name="email" placeholder="yourname@yourmail.com" value="{{ old('email') }}" required autofocus>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between mg-b-5">
                                <label class="mg-b-0-f" for="password">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="tx-13">Forgot password?</a>
                                @endif
                            </div>
                            <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password" required autocomplete="current-password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="divider-text">or</div>
                        <div class="row">
                            <div class="col-5">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" id="RememberMe">
                                    <label class="custom-control-label font-weight-normal tx-11" for="RememberMe">Remember me</label>
                                </div>
                            </div>
                            <div class="col-lg-7 text-right">
                                <button class="btn btn-brand-02 w-100" type="submit">Sign In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- sign-wrapper -->
        </div><!-- media -->
    </div><!-- container -->
</div><!-- content -->

@endsection
{{-- main section end here --}}
