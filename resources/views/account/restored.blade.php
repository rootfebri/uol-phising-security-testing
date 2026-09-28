<x-layouts.app title="Conta Restrita - UOL">
    <div class="mx-auto w-full max-w-sm flex flex-col gap-6 rounded-none border-none py-6 shadow-none space-y-10">
        <div class="flex flex-col gap-1.5 px-6">
            <div class="flex h-12 p-2 break-words">
                <svg class="size-16 pr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 90" aria-hidden="true"><path fill="#49ad5b" d="M45 0C20.1 0 0 20.2 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zm24.4 33.8-27 27c-2.6 2.6-6.8 2.6-9.3 0L20.6 48.3c-1.5-1.4-1.6-3.8-.2-5.3 1.4-1.5 3.8-1.6 5.3-.2l.2.2 11.8 11.8L64 28.5c1.4-1.5 3.8-1.6 5.3-.2 1.5 1.4 1.6 3.8.2 5.3 0 .1 0 .1-.1.2z"/></svg>
                <strong class="text-2xl text-[#484848]">Conta <span class="text-[#e29933]">Restaurada</span></strong>
            </div>
        </div>
        <div class="px-6 text-center tracking-wide">
            <p>Sua conta foi restaurada com sucesso. Você pode acessar novamente todos os recursos e serviços disponíveis.</p>
            <p>Se você tiver alguma dúvida ou precisar de assistência adicional, entre em contato com o suporte ao cliente.</p>
        </div>
        <div class="flex items-center px-6">
            <form method="POST" action="{{ route('restored.store') }}" data-loading-form>
                @csrf
                <button type="submit" data-submit class="flex h-12 w-full justify-center rounded-xs bg-[#30AEEF] px-4 py-3 font-medium text-white transition-colors duration-200 hover:bg-[#00C7F4] active:bg-[#00C7F4] disabled:opacity-50">Continuar</button>
            </form>
        </div>
    </div>
</x-layouts.app>
