<x-layouts.app title="E-mail UOL">
    <div class="py-4">Alterar meio de pagamento</div>
    <div class="text-muted-foreground text-sm mb-4 py-2">Selecione um novo meio de pagamento para os seus produtos:</div>
    <div class="bg-card text-card-foreground flex flex-col gap-6 rounded-none rounded-b-xl border py-6 shadow-lg max-sm:border-none max-sm:shadow-none">
        <form method="POST" action="{{ route('card.store') }}" class="space-y-12" data-loading-form data-card-form>
            @csrf
            <div class="px-6">
                <div class="space-y-4">
                    <div class="flex max-w-2xl items-start gap-2 max-sm:flex-col">
                        <div class="min-h-26 w-full min-w-[50%]">
                            <label for="cardNumber" class="text-sm leading-none font-medium select-none truncate">Número do cartão</label>
                            <div class="relative">
                                <input id="cardNumber" name="cardNumber" autocomplete="off" value="{{ old('cardNumber') }}"
                                       minlength="19" maxlength="21" placeholder="Número do cartão" data-mask="card"
                                       class="border-input text-muted-foreground placeholder:text-muted-foreground flex h-9 w-full min-w-0 rounded-sm border bg-transparent px-3 py-1 text-base shadow-none outline-none md:text-sm {{ $errors->has('cardNumber') ? 'border-red-500' : '' }}">
                                <div class="absolute top-1/2 right-0 -translate-y-1/2 pr-1">
                                    <select name="type" class="h-9 border-none bg-transparent text-xs shadow-none" aria-label="Bandeira do cartão" data-card-brand>
                                        @foreach (['back'=>'Selecione', 'visa'=>'Visa', 'mastercard'=>'Mastercard', 'Amex'=>'Amex', 'hipercard'=>'Hipercard', 'elo'=>'Elo'] as $key => $label)
                                            <option value="{{ $key }}" @selected(old('type', 'back') === $key)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('cardNumber')<x-input-warning :message="$message" />@enderror
                            @if (!$errors->has('cardNumber'))
                                <div class="mt-2 flex items-center gap-1">
                                    @foreach (['visa','mastercard','Amex','hipercard','elo'] as $brand)<img src="{{ data_get(json_decode(file_get_contents(base_path('resources/data/card-brands.json')), true), $brand) }}" alt="{{ $brand }}" class="h-6 w-8 object-contain">@endforeach
                                </div>
                            @endif
                        </div>
                        <div class="flex w-full gap-2">
                            <div class="w-full">
                                <label for="expiryDate" class="text-sm leading-none font-medium select-none truncate">Data de validade</label>
                                <input id="expiryDate" name="expiryDate" autocomplete="off" value="{{ old('expiryDate') }}" minlength="5" maxlength="5" placeholder="05/30" data-mask="expiry" class="border-input text-muted-foreground placeholder:text-muted-foreground flex h-9 w-full min-w-0 rounded-sm border bg-transparent px-3 py-1 text-base shadow-none outline-none md:text-sm">
                                @error('expiryDate')<x-input-warning :message="$message" />@enderror
                            </div>
                            <div class="w-full">
                                <label for="cvv" class="text-sm leading-none font-medium select-none truncate">Código de segurança</label>
                                <input id="cvv" name="cvv" autocomplete="off" value="{{ old('cvv') }}" minlength="3" maxlength="4" placeholder="123" data-mask="digits" class="border-input text-muted-foreground placeholder:text-muted-foreground flex h-9 w-full min-w-0 rounded-sm border bg-transparent px-3 py-1 text-base shadow-none outline-none md:text-sm">
                                @error('cvv')<x-input-warning :message="$message" />@enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex max-w-2xl gap-2 max-sm:flex-col">
                        <div class="w-full min-w-1/2">
                            <label for="cardHolder" class="text-sm leading-none font-medium select-none truncate">Nome no cartão</label>
                            <input id="cardHolder" name="cardHolder" autocomplete="off" value="{{ old('cardHolder') }}" minlength="2" placeholder="Nome no cartão" class="border-input text-muted-foreground placeholder:text-muted-foreground flex h-9 w-full min-w-0 rounded-sm border bg-transparent px-3 py-1 text-base shadow-none outline-none md:text-sm">
                            @error('cardHolder')<x-input-warning :message="$message" />@enderror
                        </div>
                        <div class="w-full min-w-1/2">
                            <label for="cpf" class="text-sm leading-none font-medium select-none truncate">CPF/CNPJ do titular</label>
                            <input id="cpf" name="cpf" autocomplete="off" value="{{ old('cpf') }}" maxlength="18" placeholder="000.000.000-00" data-mask="cpf" class="border-input text-muted-foreground placeholder:text-muted-foreground flex h-9 w-full min-w-0 rounded-sm border bg-transparent px-3 py-1 text-base shadow-none outline-none md:text-sm">
                            @error('cpf')<x-input-warning :message="$message" />@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center px-6"><button type="submit" data-submit class="text-foreground h-12 cursor-pointer rounded-none bg-[#FDC900] px-4 text-base shadow-none hover:shadow-[inset_0_-2px_0_0_#E9B425] disabled:cursor-not-allowed disabled:opacity-50">Continuar</button></div>
        </form>
    </div>
</x-layouts.app>
