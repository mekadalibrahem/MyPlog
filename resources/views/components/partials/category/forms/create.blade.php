<form action="{{ route('category.create') }}" method="POST">
    <x-auth-session-status class="mb-4" :status="session('insert_category')" />
    @csrf

    <div>
        <x-input-label for="name" :value="__('Category  name')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
            required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>
    <x-primary-button class=" mt-3 p-3">
        {{ __('Save') }}
    </x-primary-button>
</form>
