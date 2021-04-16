@extends('layouts.guest')
@section('content')
<body class="login">
    <div>

        <div class="login_wrapper">
            <div class="animate form login_form">
            <section class="login_content">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1>Login Form</h1>
                <div>
                    <input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" placeholder="Email" required autofocus />
                </div>
                <div>
                    <input id="password" class="block mt-1 w-full form-control"
                                    type="password"
                                    name="password"
                                    placeholder="Password"
                                    required autocomplete="current-password" />
                </div>
                
                <!-- Remember Me -->
                <div class="block mt-4">
                    <!-- <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label> -->
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <!-- <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a> -->
                    @endif

                    <button class="form-control">
                        {{ __('Log in') }}
                    </button>
                </div>
                <div class="clearfix"></div>
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                    New to site? Register here!
                </a>
                
                </form>
            </section>
            </div>
        </div>
    </div>
</body>