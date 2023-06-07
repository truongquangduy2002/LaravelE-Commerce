@extends('frontend.master_dashboard')
@section('dashboard')
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Pages <span></span> My Account
                </div>
            </div>
        </div>
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-8 col-md-12 m-auto">
                        <div class="row">
                            <div class="heading_s1">
                                <div class="logo">
                                    <img src="{{ asset('frontend/assets/imgs/theme/logo.svg') }}" alt="Logo"
                                        width="200px">
                                </div>
                                <h2 class="mb-15 mt-15">Reset password</h2>
                            </div>
                            <div class="col-lg-6 col-md-8">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="padding_eight_all bg-white">
                                        <!-- Validation Errors -->
                                        <x-auth-validation-errors class="mb-4" :errors="$errors" />

                                        <form method="POST" action="{{ route('password.update') }}">
                                            @csrf

                                            <!-- Password Reset Token -->
                                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                            <!-- Email Address -->
                                            <div>
                                                <x-label for="email" :value="__('Email')" />

                                                <x-input id="email" class="block mt-1 w-full" type="email"
                                                    name="email" :value="old('email', $request->email)" required autofocus />
                                            </div>

                                            <!-- Password -->
                                            <div class="mt-4">
                                                <x-label for="password" :value="__('Password')" />

                                                <x-input id="password" class="block mt-1 w-full" type="password"
                                                    name="password" required />
                                            </div>

                                            <!-- Confirm Password -->
                                            <div class="mt-4">
                                                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                                                <x-input id="password_confirmation" class="block mt-1 w-full"
                                                    type="password" name="password_confirmation" required />
                                            </div>

                                            <div class="flex items-center justify-end mt-4">
                                                <x-button>
                                                    {{ __('Reset Password') }}
                                                </x-button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
