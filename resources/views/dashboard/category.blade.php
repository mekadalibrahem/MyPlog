<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">


                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                            data-tabs-toggle="#default-tab-content" role="tablist">
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="create-tab"
                                    data-tabs-target="#create" type="button" role="tab" aria-controls="create"
                                    aria-selected="false">{{__('Create')}}</button>
                            </li>
                            <li class="me-2" role="presentation">
                                <button
                                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                    id="edit-tab" data-tabs-target="#edit" type="button" role="tab"
                                    aria-controls="edit" aria-selected="false">{{__('Edit')}}</button>
                            </li>

                        </ul>
                    </div>
                    <div id="default-tab-content">
                        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="create" role="tabpanel"
                            aria-labelledby="create-tab">
                            <x-auth-session-status class="mb-4" :status="session('insert_category')" />
                            <form action="{{route('category.create')}}" method="POST"

                            >
                                @csrf

                                <div >
                                    <x-input-label for="name" :value="__('Category  name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <x-primary-button class=" mt-3 p-3">
                                    {{ __('Save') }}
                                </x-primary-button>
                            </form>
                        </div>
                        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="edit" role="tabpanel"
                            aria-labelledby="edit-tab">
                            <form action="{{route('category.update')}}" method="POST"

                            >
                                @csrf
                                <div >
                                    <x-input-label for="old_name" :value="__('Category old name')" />
                                    <x-text-input id="old_name" class="block mt-1 w-full" type="text" name="old_name" :value="old('old_name')" required />
                                    <x-input-error :messages="$errors->get('old_name')" class="mt-2" />
                                </div>
                                <div >
                                    <x-input-label for="new_name" :value="__('Category new name')" />
                                    <x-text-input id="new_name" class="block mt-1 w-full" type="text" name="new_name" :value="old('new_name')" required />
                                    <x-input-error :messages="$errors->get('new_name')" class="mt-2" />
                                </div>
                                <x-primary-button class=" mt-3 p-3">
                                    {{ __('Update') }}
                                </x-primary-button>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
