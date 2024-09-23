<x-reader-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Article') }}
        </h2>
    </x-slot>
    <div class="container mx-auto flex flex-wrap py-6">

        <!-- Posts Section -->
        <section class="w-full md:w-2/3 flex flex-col items-center px-3">

            <article class="flex flex-col shadow my-4">
                <!-- Article Image -->
                {{-- <a href="#" class="hover:opacity-75">
                    <img src="https://source.unsplash.com/collection/1346951/1000x500?sig=1">
                </a> --}}
                <div class="bg-white flex flex-col justify-start p-6">
                    <a href="#" class="text-blue-700 text-sm font-bold uppercase pb-4">{{$article->category->name}}</a>
                    <a href="#" class="text-3xl font-bold hover:text-gray-700 pb-4">{{$article->name}}</a>
                    {{-- <p href="#" class="text-sm pb-3">
                        By <a href="#" class="font-semibold hover:text-gray-800">David Grzyb</a>, Published on April 25th, 2020
                    </p> --}}
                    <p  class="pb-6">
                        {{$article->content}}
                    </p>

                </div>
            </article>



        </section>

        <!-- Sidebar Section -->
        <aside class="w-full md:w-1/3 flex flex-col items-center px-3">

            <div class="w-full bg-white shadow flex flex-col my-4 p-6">
                <p class="text-xl font-semibold pb-5">About Us</p>
                <p class="pb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas mattis est eu odio sagittis tristique. Vestibulum ut finibus leo. In hac habitasse platea dictumst.</p>
                <a href="#" class="w-full bg-blue-800 text-white font-bold text-sm uppercase rounded hover:bg-blue-700 flex items-center justify-center px-2 py-3 mt-4">
                    Get to know us
                </a>
            </div>



        </aside>

    </div>

    <div class=" w-full grid grid-cols-1 md:grid-cols-2  lg:grid-cols-3 gap-3  items-center  md:pb-12">
        @foreach ($releted as $item)
            <!--
  Heads up! 👋

  This component comes with some `rtl` classes. Please remove them if they are not needed in your project.
-->

<article
class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm transition hover:shadow-lg sm:p-6"
>
<span class="inline-block rounded bg-blue-600 p-2 text-white">
    {{$item->category->name}}
</span>

<a href="#">
  <h3 class="mt-0.5 text-lg font-medium text-gray-900">
   {{$item->name}}
  </h3>
</a>

<p class="mt-2 line-clamp-3 text-sm/relaxed text-gray-500">
 {{Str::limit($item->content , 25)}}
</p>

<a href="{{ route('article', ['id' => $item->id]) }}"
    class="inline-flex items-center font-medium text-blue-600 hover:text-blue-800 dark:text-blue-500 dark:hover:text-blue-700">

    {{ __('Learn more') }}

    <svg class=" w-2.5 h-2.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 6 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="m1 9 4-4-4-4" />
    </svg>
</a>
</article>

        @endforeach
</div>

    

</x-reader-layout>
