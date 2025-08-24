@php
$attributes = $changes['attributes'] ?? [];
$old = $changes['old'] ?? [];
@endphp

@if (count($attributes))
<div class="text-sm space-y-3">
    @foreach ($attributes as $key => $value)
    <div class="border-b pb-1">
        <div class="text-xs text-gray-500 uppercase tracking-wide font-medium">
            {{ ucfirst(str_replace('_', ' ', $key)) }}
        </div>
        <div class="flex justify-between gap-4 text-sm">
            <div class="text-red-600 font-medium w-1/2 truncate">Old: {{ $old[$key] ?? '-' }}</div>
            <div class="text-green-600 font-medium w-1/2 truncate text-right">New: {{ $value }}</div>
        </div>
    </div>
    @endforeach
</div>
@else
<span class="text-gray-500 italic">No changes recorded</span>
@endif