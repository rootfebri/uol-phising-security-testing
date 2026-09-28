@props(['title' => 'UOL E-mail'])

<x-layouts.document :title="$title">
    <div style="background: none repeat scroll 0 0 #e5e9ec">
        <div class="bg-background mx-auto flex min-h-screen max-w-[94rem] flex-col shadow-xl">
            <header class="flex h-12 w-full items-center justify-around bg-[#262626] px-10 shadow-xl">
                <img src="{{ asset('logo_completo_white.svg') }}" alt="UOL" class="h-6">
                <div class="hidden items-center gap-8 md:flex">
                    <p class="flex flex-wrap items-center justify-center gap-2 text-sm text-white">
                        <a href="#">INGRESSO.COM</a><a href="#">UOL HOST</a><a href="#">PAGBANK</a>
                        <a href="#">CURSOS</a><a href="#">UOL PLAY</a><a href="#">UOL ADS</a>
                    </p>
                    <nav><ul class="flex items-center justify-center gap-4 text-sm text-white">
                        <li><a href="#">BUSCA</a></li><li><a href="#">BATE-PAPO</a></li><li><a href="#">EMAIL</a></li>
                    </ul></nav>
                </div>
            </header>
            <main class="container mx-auto grow py-20"><div class="mx-auto max-w-screen-lg flex-1">{{ $slot }}</div></main>
            <footer class="mt-auto w-full border-t-2 py-4 text-center text-xs text-gray-700">
                <p>Sua senha é secreta. Nenhum funcionário a serviço do UOL está autorizado a solicitá-la.</p>
                <ul class="flex flex-wrap items-center justify-center gap-1">
                    <li><a class="text-blue-500" href="#">Regras de uso</a></li><li>|</li>
                    <li><a class="text-blue-500" href="#">Política anti-spam</a></li><li>|</li>
                    <li><a class="text-blue-500" href="#">Crimes virtuais: denuncie</a></li><li>|</li>
                    <li><a class="text-blue-500" href="#">Normas de Segurança e privacidade</a></li>
                </ul>
                <p>© 1996 - 2025 - UOL - O melhor conteúdo. Todos os direitos reservados.</p>
                <p>UNIVERSO ONLINE S/A - CNPJ/MF 01.109.184/0001-95 - Av. Brigadeiro Faria Lima, 1.384, São Paulo/SP - CEP 01452-002 - uol.com.br/sac</p>
            </footer>
        </div>
    </div>
</x-layouts.document>
