<form action="{{ route('tag.update') }}" method="POST">
    <x-auth-session-status class="mb-4" :status="session('update_tag')" />
    @csrf
    <div>
        <x-input-label for="old_name" :value="__('Tag old name')" />
        <x-text-input id="old_name" class="block mt-1 w-full" type="text"
            name="old_name" :value="old('old_name')" required />
        <x-input-error :messages="$errors->get('old_name')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="new_name" :value="__('Tag new name')" />
        <x-text-input id="new_name" class="block mt-1 w-full" type="text"
            name="new_name" :value="old('new_name')" required />
        <x-input-error :messages="$errors->get('new_name')" class="mt-2" />
    </div>
    <x-primary-button class=" mt-3 p-3">
        {{ __('Update') }}
    </x-primary-button>
</form>
