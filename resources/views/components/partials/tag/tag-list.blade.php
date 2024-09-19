<ul class="space-y-4 text-left text-gray-500 dark:text-gray-400">
    @forelse ($tags as $tag)
        <x-partials.tag.tag-item-list :tag="$tag" />
    @empty
        <li class="flex items-center space-x-3 rtl:space-x-reverse">
            <span>
                {{ __("Don't Have any tags yet") }}
            </span>
        </li>
    @endforelse
</ul>
