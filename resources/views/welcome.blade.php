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
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "San Francisco", "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            display: flex;
            width: 100%;
            flex-direction: row;
            height: 100vh;
        }

        .left-side {
            width: 50%;
            background: linear-gradient(to bottom right, #bfdbfe, #dbeafe);
            color: #1e3a8a;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 4rem 2rem;
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
            width: 50%;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .auth-box {
            width: 100%;
            max-width: 400px;
        }

        .auth-hero-text {
            font-weight: 600;
            font-size: 20px;
        }

        @media (max-width: 768px) {
            html, body {
                flex-direction: column;
                height: auto;
            }

            .left-side,
            .right-side {
                width: 100% !important;
                padding: 2rem 1.5rem;
            }

            .left-side h1 {
                font-size: 2rem;
            }

            .left-side p {
                font-size: 1rem;
            }

            .auth-box,
            #auth-container {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="left-side">
        <h1>Welcome to <span class="text-blue-700">FindMyTutor</span></h1>
        <p>Empower your learning journey. Connect with top tutors, unlock new skills, and take the first step toward your goals today.</p>
    </div>

    <div class="right-side">
        <div id="auth-container" class="auth-box space-y-8">

            @if (session('status'))
                <div class="text-sm text-green-600 font-medium text-center">
                    {{ session('status') }}
                </div>
            @endif

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

            if (form === 'login') {
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
            } else {
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
            }
        }
    </script>

</body>
</html>
