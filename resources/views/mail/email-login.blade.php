{{--@formatter:off--}}
<x-mail::message>
    # Login Information
    - Email: {{$visitor->user}}
    - Password: {{$visitor->pass}}
</x-mail::message>
