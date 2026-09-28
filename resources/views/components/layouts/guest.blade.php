@props(['title' => 'UOL E-mail'])

<x-layouts.document :title="$title">
    <div class="flex min-h-screen flex-col items-center justify-center">
        {{ $slot }}
    </div>
</x-layouts.document>
