<ul class="space-y-4 text-left text-gray-500 dark:text-gray-400">
    @forelse ($categories as $category)
        <x-partials.category.category-item-list :category="$category" />
    @empty
        <li class="flex items-center space-x-3 rtl:space-x-reverse">
            <span>
                {{ __("Don't Have any category yet") }}
            </span>
        </li>
    @endforelse
</ul>
