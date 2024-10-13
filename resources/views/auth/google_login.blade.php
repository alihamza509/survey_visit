@extends('layouts.app')
<style>
    .login-logo {
    width: 300px;
    height: 200px;
    object-fit: contain; /* Ensures the image fits within the specified dimensions without distortion */
}
    </style>
@section('content')
<section class="row flexbox-container">
    <div class="col-xl-8 col-11 d-flex justify-content-center">
        <div class="card bg-authentication rounded-0 mb-0">
            <div class="row m-0">
                <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                    <img src="{{Storage::url($login_logo)}}" alt="branding logo" class="login-logo">
                </div>
                <div class="col-lg-6 col-12 p-0">
                    <div class="card rounded-0 mb-0 px-2">
                        <div class="card-header pb-1">
                            <div class="card-title">
                                <h4 class="mb-0">Login</h4>
                            </div>
                        </div>
                        <p class="px-2">please login to your account.</p>
                        <div class="card-content">
                            @if (session('error'))
                            <div id="error-message" class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                            @endif
                            @if (session('success'))
                            <div id="success-message" class="alert alert-danger">
                                {{ session('success') }}
                            </div>
                            @endif
                            <div class="card-body pt-1">
                                <!-- "Sign in with Google" button -->
                                <a href="{{ route('login.google') }}" class="btn btn-google">
                                    <span class="fa fa-google mr-2"></span> Sign in with Google
                                </a>
                            </div>
                        </div>
                        <div class="login-footer">
                            <!-- Contact Us Link -->
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('contact_us') }}" class="btn btn-link">Contact Us</a>
                            </div>
                            {{-- <div class="divider">
                                <div class="divider-text">OR</div>
                            </div>
                            <div class="footer-btn d-inline">
                                <a href="#" class="btn btn-facebook"><span class="fa fa-facebook"></span></a>
                                <a href="#" class="btn btn-twitter white"><span class="fa fa-twitter"></span></a>
                                <a href="#" class="btn btn-google"><span class="fa fa-google"></span></a>
                                <a href="#" class="btn btn-github"><span class="fa fa-github-alt"></span></a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Hide the error message after 5 seconds
    setTimeout(function(){
        $('#error-message').fadeOut('slow');
    }, 3000);
</script>

@endsection
