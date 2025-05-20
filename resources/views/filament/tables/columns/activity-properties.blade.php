@php
$changes = $getState ?? [];
@endphp

@if (!empty($changes))
<ul class="text-sm text-gray-600 space-y-1">
    @foreach ($changes as $key => $value)
    <li>
        <strong>{{ ucfirst($key) }}:</strong>
        @if(is_array($value))
        <ul class="ml-4 list-disc">
            @foreach ($value as $subKey => $subValue)
            <li><strong>{{ ucfirst($subKey) }}:</strong> {{ json_encode($subValue) }}</li>
            @endforeach
        </ul>
        @else
        {{ json_encode($value) }}
        @endif
    </li>
    @endforeach
</ul>
@else
<span class="text-gray-400 italic">No changes recorded.</span>
@endif
