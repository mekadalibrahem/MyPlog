<li class=" bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div>

        <div class=" p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="about" role="tabpanel"
            aria-labelledby="about-tab">
            <div class="flex flex-row justify-between">
                <h2 class="mb-3 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                    {{ $article->name }}
                </h2>
                <div>
                    @if ($article->category_id > 0)
                        <span
                            class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-1 rounded dark:bg-blue-900 dark:text-blue-300">
                            {{ $article->category->name }}
                        </span>
                    @endif
                </div>

            </div>

            <p class="mb-3 text-gray-500 dark:text-gray-400">
                {{ Str::limit($article->content, 75, '...') }}
            </p>
            @if ($edit)
                <a href="{{ route('article.update', ['id' => $article->id]) }}"
                    class="inline-flex items-center font-medium text-blue-600 hover:text-blue-800 dark:text-blue-500 dark:hover:text-blue-700">

                    {{ __('Learn more') }}

                    <svg class=" w-2.5 h-2.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                </a>
            @else
                <a href="{{ route('article', ['id' => $article->id]) }}"
                    class="inline-flex items-center font-medium text-blue-600 hover:text-blue-800 dark:text-blue-500 dark:hover:text-blue-700">

                    {{ __('Learn more') }}

                    <svg class=" w-2.5 h-2.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                </a>
            @endif
        </div>
    </div>
</li>
