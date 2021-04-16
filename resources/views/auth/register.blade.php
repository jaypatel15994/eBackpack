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
                <form method="POST" action="{{ route('register') }}">
                @csrf
                <h1>Register</h1>
                
                <div>
                    <input id="name" class="block mt-1 w-full form-control" type="text" name="name" value="{{old('name')}}" placeholder="Name" required autofocus />
                </div>
                <div>
                    <input id="email" class="block mt-1 w-full form-control" type="email" name="email" value="{{old('email')}}" placeholder="Email" required autofocus />
                </div>
                <div>
                    <input id="password" class="block mt-1 w-full form-control"
                                    type="password"
                                    name="password"
                                    placeholder="Password"
                                    required autocomplete="current-password" />
                </div>

                <div>
                    <input id="password_confirmation" class="block mt-1 w-full form-control"
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Confirm password"
                                    required/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    

                    <button class="form-control">
                        {{ __('Register') }}
                    </button>
                </div>
                <div class="clearfix"></div>
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                
                </form>
            </section>
            </div>
        </div>
    </div>
</body>