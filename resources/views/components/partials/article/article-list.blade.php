<ul class=" space-y-4 text-left text-gray-500 dark:text-gray-400">
    {{-- @dd($articles) --}}
    @forelse ($articles as $article)
        <x-partials.article.article-item-list :article="$article" :edit="$edit" />
    @empty
        <li class="flex items-center space-x-3 rtl:space-x-reverse">
            <span>
                {{ __("Don't Have any article yet") }}
            </span>
        </li>
    @endforelse
</ul>
