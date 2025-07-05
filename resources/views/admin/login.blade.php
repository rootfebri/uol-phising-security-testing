<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">
<div class="w-full max-w-sm p-6 bg-white rounded-xl shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-center">Admin Login</h1>

    <!-- Tampilkan error -->
    @if ($errors->any())
        <div class="mb-4 text-red-600 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.login.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700">Usuário</label>
            <input type="text" name="username" id="username" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
            <input type="password" name="password" id="password" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
        </div>

        <div>
            <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">
                Entrar
            </button>
        </div>
    </form>
</div>
</body>
</html>
