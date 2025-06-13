<x-app-layout>
    <x-slot name="header"></x-slot>

    <style>
        .profile-wrapper {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
        }

        @media (max-width: 768px) {
            .profile-wrapper {
                margin: 20px 8px;
                padding: 7px;
            }
        }

        .profile-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 24px;
        }

        @media (max-width: 768px) {
            .profile-card {
                padding: 20px;
            }
        }
    </style>

    <div class="profile-wrapper">
        <!-- Profile Information -->
        <div class="profile-card">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Tutor Profile -->
        @auth
            @if (Auth::user()->tutorProfile)
                <div class="profile-card">
                    <div class="max-w-xl">
                        @include('profile.partials.update-tutor-info-form')
                    </div>
                </div>
            @endif
        @endauth

        <!-- Update Password -->
        <div class="profile-card">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete User -->
        <div class="profile-card">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
