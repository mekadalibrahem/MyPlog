<x-reader-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('About me') }}
        </h2>
    </x-slot>
    <x-section>
        <x-auth-session-status class="mb-4" :status="session('delete-article')" />
        <form action="{{route('articles')}}" method="POST">
            @csrf
          <div class="flex flex-row me-2 gap-6" >
            <x-widgits.dropdown-checkbox id="fcategory" togleitem="tfcategory" filtername="filterCategory[]" title="category filter" :list="$categories"  :oldf="$oldFCategories" />
            <x-widgits.dropdown-checkbox id="ftag" togleitem="tftag" filtername="filterTags[]" title="tag filter" :list="$tags" :oldf="$oldFTags" />
            <x-primary-button  type="submit" >
               {{__("aplay filters")}}
            </x-primary-button>

          </div>
        </form>

    </x-section>
    <x-section>
        <x-partials.article.article-list  :articles="$articles"  :edit="false"/>
        <div class="mt-2" >
            {{ $articles->links() }}
        </div>
    </x-section>


</x-reader-layout>
