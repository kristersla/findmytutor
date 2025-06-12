<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Tutor Profile Details') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your tutor bio, subject, location and hourly rate.") }}
        </p>
    </header>

    @if (session('success'))
        <p class="text-sm text-green-600">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('tutor.update-info') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" class="mt-1 block w-full rounded-md shadow-sm">{{ old('bio', $tutor->bio) }}</textarea>
        </div>

        <div>
            <x-input-label for="hourly_rate" :value="__('Hourly Rate (€)')" />
            <x-text-input id="hourly_rate" name="hourly_rate" type="number" min="0" step="1" class="mt-1 block w-full" :value="old('hourly_rate', $tutor->hourly_rate)" />
        </div>

        <div>
            <x-input-label for="location" :value="__('Location')" />
            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $tutor->location)" />
        </div>

        <div>
            <x-input-label for="contact_method" :value="__('Contact Method')" />
            <x-text-input id="contact_method" name="contact_method" type="text" class="mt-1 block w-full" :value="old('contact_method', $tutor->contact_method)" />
        </div>

        <div>
            <x-input-label for="subject_name" :value="__('Subject')" />
            <select name="subject_name" id="subject_name" class="mt-1 block w-full" required>
                <option value="">Select a subject</option>
                <option value="math">Math</option>
                <option value="literature">Literature</option>
                <option value="writing">Writing</option>
                <option value="culinary">Culinary</option>
                <option value="biology">Biology</option>
                <option value="chemistry">Chemistry</option>
                <option value="physics">Physics</option>
                <option value="geography">Geography</option>
            </select>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
