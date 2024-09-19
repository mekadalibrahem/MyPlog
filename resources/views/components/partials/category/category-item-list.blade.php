<li class="flex items-center space-x-3 rtl:space-x-reverse">
    <form action="{{ route('category.delete', ['id' => $category->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        {{-- <input type="hidden" name="id" value="{{$id}}"> --}}
        <button type="submit">
            <x-icons.trash class="text-red-600" />

        </button>
    </form>
    <span>{{ $category->name }}</span>
</li>
