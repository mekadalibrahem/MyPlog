<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Article') }}
        </h2>
    </x-slot>

    <x-section>
        <x-auth-session-status class="mb-4" :status="session('update_article')" />
        <form action="{{ route('article.update', ['id' => $article->id]) }}" method="POST" class="flex flex-col gap-3">
            @csrf
            @method('PATCH')
            <div>
                <x-input-label for="name" :value="__('Article  name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$article->name"
                    required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="content" :value="__('Article  content')" />
                <textarea id="content" class="block mt-1 w-full" type="text" name="content"
                                                    required >{{ $article->content }}</textarea>
                <x-input-error :messages="$errors->get('contetnt')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="category" :value="__('Article  category')" />
                <select name="category" id="category">
                    <option value="{{null}}">{{ __('Nothing') }}</option>
                    @foreach ($categories as $category)
                        @php
                            $selected = $category->id == $article->category_id;
                        @endphp
                        <option value="{{ $category->id }}" {{ $selected ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="tags" :value="__('Article  tag')" />
                @php
                    $selected_tags = $article->tags;
                    $selected_tags_ids = [];
                    foreach ($selected_tags as $t) {
                        $selected_tags_ids[] = $t->id;
                    }
                @endphp
                <x-widgits.dropdown-checkbox id="tags" togleitem="ttags" filtername="tags[]" title="tags"
                    :list="$tags" :oldf="$selected_tags_ids" />
                <x-input-error :messages="$errors->get('tags')" class="mt-2" />
            </div>

            <div>
                <x-primary-button class=" mt-3 p-3">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </form>

    </x-section>



</x-app-layout>
