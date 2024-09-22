<div>

    <button id="{{$id}}" data-dropdown-toggle="{{$togleitem}}"
        class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        type="button">{{$title}}<svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
        </svg>
    </button>

    <!-- Dropdown menu -->
    <div id="{{$togleitem}}" class="z-10 hidden bg-white rounded-lg shadow w-60 dark:bg-gray-700">

        <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
            aria-labelledby="{{$id}}">
      
            @forelse ( $list as  $item)
                <x-widgits.dropdown-checkbox-item :filtername="$filtername" :item="$item" :oldf="$oldf"/>
            @empty

            @endforelse
        </ul>

    </div>

</div>
