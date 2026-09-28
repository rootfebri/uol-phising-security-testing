<x-layouts.app title="Conta Restrita - UOL">
    <div class="mx-auto w-full max-w-sm rounded-none border-none shadow-none">
        <div class="flex h-12 p-2 break-words">
            <svg class="size-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 90" aria-hidden="true"><path fill="#ffbc2c" d="M89.1 74.1 50.3 9.5c-1.8-3-5.6-3.9-8.6-2.2-.9.5-1.6 1.3-2.2 2.2L.9 74.1c-1.8 3-.8 6.8 2.2 8.6 1 .6 2.1.9 3.2.9h77.5c3.5 0 6.2-2.8 6.2-6.3 0-1.1-.3-2.2-.9-3.2zM41.3 31.2c0-2.1 1.7-3.8 3.8-3.8s3.8 1.7 3.8 3.8v25.1c0 2.1-1.7 3.8-3.8 3.8s-3.8-1.7-3.8-3.8V31.2zm3.7 43.6c-2.6 0-4.7-2.1-4.7-4.7s2.1-4.7 4.7-4.7 4.7 4.7 4.7 4.7-2.1 4.7-4.7 4.7z"/></svg>
            <strong class="text-2xl text-[#484848]">Conta Restrita</strong>
        </div>
        <div class="tracking-wide">
            <p>Percebemos que sua conta foi temporariamente restrita. Para poder usá-la novamente, é necessário confirmar algumas informações de segurança.</p>
            <p>Por favor, realize a confirmação para recuperar o acesso completo.</p>
        </div>
        <div class="flex items-center px-0 pt-6">
            <a href="{{ route('billing.index') }}" class="flex h-12 w-full justify-center rounded-xs bg-[#e29933] px-4 py-3 font-medium text-white transition-colors duration-200 hover:bg-[#d4862e]">Continuar</a>
        </div>
    </div>
</x-layouts.app>
