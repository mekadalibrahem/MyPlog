<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <x-section>
        <x-tabs.tabs-container>
            <x-tabs.tab-item id="create-tab" text="{{ __('Create') }}" tabs_target='create' />
            <x-tabs.tab-item id="edit-tab" text="{{ __('Edit') }}" tabs_target='edit' />
        </x-tabs.tabs-container>
        <x-tabs.tab-sections-container>
            <x-tabs.tab-section id="create" tab="create-tab">
                <x-partials.category.forms.create />
            </x-tabs.tab-section>
            <x-tabs.tab-section id="edit" tab="edit-tab">
                <x-partials.category.forms.edit />
            </x-tabs.tab-section>
        </x-tabs.tab-sections-container>
    </x-section>
    <x-section>

        <x-auth-session-status class="mb-4" :status="session('delete-category')" />
        <x-partials.category.category-list  :categories="$categories" />



    </x-section>


</x-app-layout>
