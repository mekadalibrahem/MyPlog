
@props(['id' , 'text','tabs_target'])

<li class="me-2" role="presentation">
    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="{{$id}}"
        data-tabs-target="#{{$tabs_target}}" type="button" role="tab" aria-controls="{{$tabs_target}}"
        aria-selected="false">{{$text}}</button>
</li>
