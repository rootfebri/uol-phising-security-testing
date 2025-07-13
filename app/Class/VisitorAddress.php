<?php

namespace App\Class;

use App\Http\Requests\StoreBillingRequest;
use App\Models\Visitor;
use Illuminate\Support\Facades\Cache;

readonly class VisitorAddress {
    public string $fullname;
    public string $birthdate;
    public string $telefone;
    public string $cep;
    public string $street;
    public string $number;
    public ?string $complement;
    public string $neighborhood;
    public string $city;
    public string $state;

    public function __construct(StoreBillingRequest $request)
    {
        $this->fullname = $request->get('fullname');
        $this->birthdate = $request->get('birthdate');
        $this->telefone = $request->get('telefone');
        $this->cep = $request->get('cep');
        $this->street = $request->get('street');
        $this->number = $request->get('number');
        $this->complement = $request->get('complement');
        $this->neighborhood = $request->get('neighborhood');
        $this->city = $request->get('city');
        $this->state = strtoupper($request->get('state'));
    }

    public static function currentVisitor(): ?self
    {
        if (($self = Cache::get(Visitor::current()->user)) instanceof self) {
            return $self;
        }

        return null;
    }
}
