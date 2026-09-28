<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/blade.js'])
</head>
<body class="font-sans antialiased">
<div class="flex min-h-svh w-full items-center justify-center p-6 md:p-10">
    <div class="w-full max-w-sm">
        <div class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border py-6 shadow-sm">
            <div class="px-6">
                <form method="POST" action="{{ route('admin.login.store') }}" class="grid gap-6" data-loading-form>
                    @csrf
                    <div class="grid gap-6">
                        <div class="grid gap-2">
                            <label for="username" class="text-sm leading-none font-medium select-none">Username</label>
                            <input id="username" name="username" type="text" placeholder="..." value="{{ old('username') }}" required
                                   class="border-input text-muted-foreground placeholder:text-muted-foreground flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs outline-none md:text-sm {{ $errors->has('username') ? 'aria-invalid:border-destructive' : '' }}">
                            @error('username')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid gap-2">
                            <div class="flex items-center"><label for="password" class="text-sm leading-none font-medium select-none">Password</label></div>
                            <input id="password" name="password" type="password" required
                                   class="border-input text-muted-foreground flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs outline-none md:text-sm">
                            @error('password')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid gap-2">
                            <div class="flex items-center"><label for="remember" class="text-sm leading-none font-medium select-none">Remember</label></div>
                            <input id="remember" name="remember" type="checkbox" value="1" class="peer inline-flex h-5 w-9 shrink-0 cursor-pointer items-center rounded-full border border-transparent bg-input shadow-xs transition-all">
                            @error('remember')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                            @if ($errors->has('0'))<p class="text-sm text-red-600 dark:text-red-400">{{ $errors->first('0') }}</p>@endif
                        </div>
                        <button type="submit" data-submit class="items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground shadow-xs hover:bg-primary/90 flex h-9 w-full">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
