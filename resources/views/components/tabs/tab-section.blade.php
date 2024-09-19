@props(['id' , 'tab'])
<div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="{{$id}}" role="tabpanel"
aria-labelledby="{{$tab}}">
{{
    $slot
}}
</div>
