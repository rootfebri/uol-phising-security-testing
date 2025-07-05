{{--@formatter:off--}}
<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header url="">
@php
[$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
@endphp
> {{$message}}
> — {{$author}}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
{{App\Models\Visitor::current()->as_markdown_footer()}}
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
