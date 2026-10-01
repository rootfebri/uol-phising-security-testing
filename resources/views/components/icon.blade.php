@props(['name' => 'dot'])
{{-- Lucide-style stroke icons, rendered at the same size the React app used. --}}
@php
    $paths = [
        'users' => ['m16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2', 'm22 21v-2a4 4 0 0 0-3-3.87', 'm16 3.13a4 4 0 0 1 0 7.75', 'circle:9,7,4'],
        'shield' => ['M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z'],
        'user' => ['M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2', 'circle:12,7,4'],
        'key' => ['m15.5 7.5 2.3 2.3a1 1 0 0 0 1.4 0l2.1-2.1a1 1 0 0 0 0-1.4L19 4', 'm21 2-9.6 9.6', 'circle:7.5,15.5,5.5'],
        'mail' => ['rect:2,4,20,16,2', 'm22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7'],
        'link' => ['M9 17H7A5 5 0 0 1 7 7h2', 'M15 7h2a5 5 0 1 1 0 10h-2', 'M8 12h8'],
        'save' => ['M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z', 'M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7', 'M7 3v4a1 1 0 0 0 1 1h7'],
        'globe' => ['circle:12,12,10', 'M2 12h20', 'M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z'],
    ];
    $shape = $paths[$name] ?? [];
@endphp
<svg {{ $attributes->merge(['class' => ''])->class($attributes->has('class') ? null : 'h-4 w-4') }} xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
    @foreach ($shape as $value)
        @php $circle = str_starts_with($value, 'circle:') ? explode(',', substr($value, 7)) : null; @endphp
        @if ($circle)
            <circle cx="{{ $circle[0] }}" cy="{{ $circle[1] }}" r="{{ $circle[2] }}"/>
        @elseif (str_starts_with($value, 'rect:'))
            @php $rect = explode(',', substr($value, 5)); @endphp
            <rect x="{{ $rect[0] }}" y="{{ $rect[1] }}" width="{{ $rect[2] }}" height="{{ $rect[3] }}" rx="{{ $rect[4] }}"/>
        @else
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $value }}"/>
        @endif
    @endforeach
</svg>
