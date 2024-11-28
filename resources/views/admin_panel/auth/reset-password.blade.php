{{-- extending master layout here --}}
@extends('admin_panel.comman.authmaster')
{{-- extending master layout here --}}

{{-- main section start here --}}
@section('authContent')
<div class="content content-fixed content-auth" style="background-image: url('{{ asset('assets/newimage/bg-app.jpg') }}'); background-size: cover; min-height: 100vh;">
  <div class="container d-flex justify-content-center ht-100p">
      <div class="reset_form mx-wd-300 wd-sm-550 ht-100p d-flex flex-column align-items-center justify-content-center">
          <!-- Image Section -->
          <div class="wd-30p mg-b-15">
              <img src="{{ asset('assets/newimage/forgot.jpg') }}" class="img-fluid" alt="Reset Password">
          </div>

          <!-- Title and Description -->
          <h4 class="tx-20 tx-sm-24">Reset your password</h4>
          <p class="tx-color-03 mg-b-30 tx-center">Please enter your email and new password to reset your password.</p>


        
          <!-- Form -->
          <form method="POST" action="{{ route('password.store') }}" class="wd-100p px-4">
              @csrf
              
              <div class="form-group">
              <!-- Hidden Token Input -->
              <input type="hidden" name="token" value="{{ $request->route('token') }}">

              <!-- Email Input -->
              <input type="email" class="form-control flex-fill" name="email" value="{{ old('email', $request->email) }}" required autofocus placeholder="Email Address">
              @error('email')
                <span class="text-danger mt-2 fw-bold">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group">
              <!-- Password Input -->
              <div class="mt-4 ">
                  <input type="password" class="form-control" name="password" required placeholder="New Password">
                  @error('password')
                    <span class="text-danger mt-2 fw-bold">{{ $message }}</span>
                  @enderror
              </div>
            </div>
            <div class="form-group">
              <!-- Confirm Password Input -->
              <div class="mt-4 ">
                  <input type="password" class="form-control" name="password_confirmation" required placeholder="Confirm New Password">
                  @error('password_confirmation')
                    <span class="text-danger mt-2 fw-bold">{{ $message }}</span>
                  @enderror
              </div>
            </div>
              <!-- Reset Button -->
              <div class="mt-4 p-0 d-flex justify-content-center">
                  <button class="btn btn-brand-02 mg-sm-l-10 mg-t-10 mg-sm-t-0 me-3">Reset Password</button>
                  <a href="{{ route('admin.login') }}" class="btn btn-outline-success mg-sm-l-10 mg-t-10 mg-sm-t-0">
                    <i href="" class="fa fa-arrow-left" aria-hidden="true"></i> Back to Login
                </a>
              </div>
          </form>

          <!-- Back to Login -->
        

          <!-- Footer -->
          <span class="tx-12 tx-color-03 mt-3">
              Key business concept vector created by 
              <a href="https://digivity.in" target="_blank">Deigivity(digivity.in)</a>
          </span>
      </div>
  </div>
</div>
{{-- section end here --}}
@endsection
