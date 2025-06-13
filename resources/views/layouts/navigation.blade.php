<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="w-full">
        <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8 relative">
            <!-- Left side: Logo -->
            <div class="flex items-center ms-4">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/find mytutor.svg') }}" alt="FindMyTutor Logo" class="h-7 w-auto">
                </a>
            </div>

            <!-- Center: Navigation Links -->
            <div class="hidden md:flex items-center space-x-8 absolute left-1/2 transform -translate-x-1/2">
                
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-nav-link :href="route('tutors.index')" :active="request()->routeIs('tutors.index')">
                    {{ __('Tutors') }}
                </x-nav-link>
                <x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.index')">
                    {{ __('My Messages') }}
                </x-nav-link>
                @auth
                    @if (Auth::user()->tutorProfile)
                        <x-nav-link :href="route('availability.index')" :active="request()->routeIs('availability.index')">
                            {{ __('My Availability') }}
                        </x-nav-link>
                    @endif
                @endauth
                @auth
                    @if (!Auth::user()->tutorProfile)
                        <x-nav-link :href="route('tutor.become')">
                            {{ __('Become a Tutor') }}
                        </x-nav-link>
                    @endif
                @endauth
                <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    {{ __('My Profile') }}
                </x-nav-link>
            </div>

            <!-- Right side: Profile dropdown -->
            <div class="hidden sm:flex sm:items-center me-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">
                            <img src="{{ asset('images/user-icon.webp') }}" alt="Profile" class="h-8 w-auto object-cover">
                            <span>{{ optional(Auth::user())->name }}</span>
                            <svg class="ms-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger for mobile -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Nav Menu (Mobile) -->
    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tutors.index')" :active="request()->routeIs('tutors.index')">
                {{ __('Tutors') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.index')">
                {{ __('My Messages') }}
            </x-responsive-nav-link>
            @auth
                @if (Auth::user()->tutorProfile)
                        <x-responsive-nav-link :href="route('availability.index')" :active="request()->routeIs('availability.index')">
                            {{ __('My Availability') }}
                        </x-responsive-nav-link>
                    @endif
                @endauth
            @auth
            @if (!Auth::user()->tutorProfile)
                <x-responsive-nav-link :href="route('tutor.become')">
                    {{ __('Become a Tutor') }}
                </x-responsive-nav-link>
            @endif
            @endauth
            <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                {{ __('My Profile') }}
            </x-responsive-nav-link>
        </div>

        <!-- Mobile Profile Settings -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
