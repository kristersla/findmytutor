<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FindMyTutor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        html, body {
            font-family: -apple-system, BlinkMacSystemFont, "San Francisco", "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        .half {
            width: 50%;
            min-height: 100vh;
        }
        .left-side {
            background: linear-gradient(to bottom right, #1d4ed8, #2563eb);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem;
            text-align: center;
        }
        .left-side h1 {
            font-size: 3rem;
            font-weight: 800;
        }
        .left-side p {
            font-size: 1.125rem;
            margin-top: 1rem;
            max-width: 400px;
        }
        .right-side {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }
        .auth-box {
            width: 100%;
            max-width: 400px;
        }
        .auth-hero-text{
            font-weight: 600;
            font-size: 20px;
        }
    </style>
</head>
<body class="flex">
    <!-- LEFT: Landing Message -->
    <div class="w-full lg:w-1/2 flex flex-col justify-center items-center text-center px-6 lg:px-16 py-12 bg-gradient-to-br from-blue-100 to-blue-200">
        <h1 class="text-4xl font-extrabold text-blue-900 mb-4 leading-tight">Welcome to <span class="text-blue-700">FindMyTutor</span></h1>
        <p class="text-lg text-blue-800 mb-6 max-w-lg">Empower your learning journey. Connect with top tutors, unlock new skills, and take the first step toward your goals today.</p>
        <!-- <img src="{{ asset('images/hero-img.svg') }}" alt="Hero Image" class="w-full max-w-md"> -->
    </div>


    <!-- RIGHT: Auth Forms -->
    <div class="half right-side flex justify-center items-center bg-white px-6 py-12">
        <div id="auth-container" class="w-full max-w-md space-y-8">
            {{-- Session Status --}}
            @if (session('status'))
                <div class="text-sm text-green-600 font-medium text-center">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Login Form --}}
            
            <div id="login-form" class="space-y-4">
                <h1 class="auth-hero-text">Log in</h1>
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus class="w-full" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" type="password" name="password" required class="w-full" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <x-primary-button class="w-full justify-center mt-4">
                        {{ __('Log in') }}
                    </x-primary-button>
                </form>

                <p class="text-center text-sm text-gray-500">
                    Not registered yet?
                    <button onclick="toggleAuth('register')" class="text-blue-600 hover:underline font-medium">
                        Create an account
                    </button>
                </p>
            </div>

            {{-- Register Form --}}
            <div id="register-form" class="space-y-4 hidden">
                <h1 class="auth-hero-text">Register account</h1>
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus class="w-full" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" type="email" name="email" :value="old('email')" required class="w-full" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" type="password" name="password" required class="w-full" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" type="password" name="password_confirmation" required class="w-full" />
                    </div>

                    <x-primary-button class="w-full justify-center mt-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </form>

                <p class="text-center text-sm text-gray-500">
                    Already have an account?
                    <button onclick="toggleAuth('login')" class="text-blue-600 hover:underline font-medium">
                        Log in here
                    </button>
                </p>
            </div>
        </div>
    </div>

    <script>
        function toggleAuth(form) {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const loginBtn = document.getElementById('login-btn');
            const registerBtn = document.getElementById('register-btn');

            const active = 'bg-blue-600 text-white';
            const inactive = 'bg-gray-200 text-gray-700';

            if (form === 'login') {
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
                loginBtn.className = loginBtn.className.replace(inactive, active);
                registerBtn.className = registerBtn.className.replace(active, inactive);
            } else {
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                registerBtn.className = registerBtn.className.replace(inactive, active);
                loginBtn.className = loginBtn.className.replace(active, inactive);
            }
        }
    </script>


</body>
</html>
