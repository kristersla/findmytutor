<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FindMyTutor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
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
    </style>
</head>
<body class="flex">
    <!-- LEFT: Landing Message -->
    <div class="half left-side">
        <h1>Welcome to FindMyTutor</h1>
        <p>Discover expert tutors across subjects. Log in or sign up to book your first session and start learning today.</p>
    </div>

    <!-- RIGHT: Auth Forms -->
    <div class="half right-side">
        <div id="auth-container" class="auth-box">
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Auth Toggle Buttons -->
            <div class="mb-4 flex justify-center gap-4">
                <button onclick="toggleAuth('login')" id="login-btn" class="text-blue-600 font-semibold">Login</button>
                <button onclick="toggleAuth('register')" id="register-btn" class="text-gray-500">Register</button>
            </div>

            <!-- Login Form -->
            <div id="login-form">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                    <x-input-label for="password" :value="__('Password')" class="mt-4" />
                    <x-text-input id="password" type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    <div class="mt-4">
                        <x-primary-button class="w-full">{{ __('Log in') }}</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Register Form -->
            <div id="register-form" style="display: none">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />

                    <x-input-label for="email" :value="__('Email')" class="mt-4" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                    <x-input-label for="password" :value="__('Password')" class="mt-4" />
                    <x-text-input id="password" type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="mt-4" />
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" required />

                    <div class="mt-4">
                        <x-primary-button class="w-full">{{ __('Register') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleAuth(form) {
            document.getElementById('login-form').style.display = form === 'login' ? 'block' : 'none';
            document.getElementById('register-form').style.display = form === 'register' ? 'block' : 'none';
            document.getElementById('login-btn').classList.toggle('text-blue-600', form === 'login');
            document.getElementById('login-btn').classList.toggle('text-gray-500', form !== 'login');
            document.getElementById('register-btn').classList.toggle('text-blue-600', form === 'register');
            document.getElementById('register-btn').classList.toggle('text-gray-500', form !== 'register');
        }
    </script>
</body>
</html>
