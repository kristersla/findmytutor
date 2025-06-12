{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FindMyTutor') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        html, body {
            font-family: -apple-system, BlinkMacSystemFont, "San Francisco", "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
    </style>



    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        {{-- If the view extends this layout with @extends --}}
        @hasSection('content')
            @hasSection('header')
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </header>
            @endif

            <main>
                @yield('content')
            </main>

        {{-- If the view uses <x-app-layout> and expects $slot --}}
        @else
            {{ $header ?? '' }}
            <main>
                {{ $slot ?? '' }}
            </main>
        @endif
    </div>
</body>
</html>
