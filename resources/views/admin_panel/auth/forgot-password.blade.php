{{-- extending master layout here --}}
@extends('admin_panel.comman.authmaster')
{{-- extending master layout here --}}

{{-- main section start here --}}
@section('authContent')
<div class="content content-fixed content-auth" style="background-image: url('{{ asset('assets/newimage/bg-app.jpg') }}'); background-size: cover; min-height: 100vh;">
  <div class="container d-flex justify-content-center ht-100p">
      <div class="reset_form mx-wd-300 wd-sm-650 ht-100p d-flex flex-column align-items-center justify-content-center">
          <!-- Image Section -->
          <div class="wd-80p wd-sm-300 mg-b-15">
              <img src="{{ asset('assets/newimage/forgot.jpg') }}" class="img-fluid" alt="Reset Password">
          </div>

          <!-- Title and Description -->
          <h4 class="tx-20 tx-sm-24">Reset your password</h4>
          <p class="tx-color-03 mg-b-30 tx-center">Enter your username or email address and we will send you a link to reset your password.</p>

          <!-- Session Status -->
          @if (session('status'))
              <div class="alert alert-success wd-100p mg-b-40">
                  {{ session('status') }}
              </div>
          @endif

          <!-- Form -->
          <form method="POST" action="{{ route('password.email') }}" class="wd-100p d-flex flex-column flex-sm-row mg-b-40">
              @csrf
              <!-- Email Input -->
              <input type="email" class="form-control wd-sm-250 flex-fill" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter username or email address">
              <button class="btn btn-brand-02 mg-sm-l-10 mg-t-10 mg-sm-t-0 me-3">Reset Password</button>
          </form>
          @error('email')
          <span class="text-danger mt-2 fw-bold">{{ $message }}</span>
      @enderror
          <!-- Buttons -->
          <div class="row mb-3">
              <div class="col mx-auto">
                  <a href="{{ route('admin.login') }}" class="btn btn-outline-success mg-sm-l-10 mg-t-10 mg-sm-t-0">
                      <i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Login
                  </a>
              </div>
          </div>

          <!-- Footer -->
          <span class="tx-12 tx-color-03">
              Key business concept vector created by 
              <a href="https://digivity.in" target="_blank">Digivity Technology Pvt. Ltd.(Digivity.in)</a>
          </span>
      </div>
  </div>
</div>


    {{-- section end here --}}
@endsection
