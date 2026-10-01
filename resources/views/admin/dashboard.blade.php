<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/blade.js'])
    <style>
        [data-tab-panel] { display: none; }
        [data-tab-panel].active { display: block; }
    </style>
</head>
<body class="font-sans antialiased">
<main class="flex min-h-screen justify-center">
    <div class="container max-w-6xl py-6">
        <h1 class="mb-6 text-2xl font-bold">Admin Settings</h1>

        <div class="flex flex-col gap-2">
            <div class="bg-muted text-muted-foreground mb-6 inline-flex h-9 w-fit items-center justify-center rounded-lg p-[3px] grid grid-cols-6" role="tablist">
                <button type="button" class="tab-trigger data-[state=active]:bg-background text-foreground inline-flex h-[calc(100%-1px)] flex-1 items-center justify-center gap-1.5 rounded-md border border-transparent px-2 py-1 text-sm font-medium whitespace-nowrap transition-[color,box-shadow] data-[state=active]:shadow-sm" data-tab="access" data-state="active">Access</button>
                <button type="button" class="tab-trigger data-[state=active]:bg-background text-foreground inline-flex h-[calc(100%-1px)] flex-1 items-center justify-center gap-1.5 rounded-md border border-transparent px-2 py-1 text-sm font-medium whitespace-nowrap transition-[color,box-shadow] data-[state=active]:shadow-sm" data-tab="stopbot" data-state="inactive">
                    <img src="{{ asset('stopbot-logo.png') }}" alt="Stopbot" class="h-4 w-4"> Stopbot
                </button>
                <button type="button" class="tab-trigger data-[state=active]:bg-background text-foreground inline-flex h-[calc(100%-1px)] flex-1 items-center justify-center gap-1.5 rounded-md border border-transparent px-2 py-1 text-sm font-medium whitespace-nowrap transition-[color,box-shadow] data-[state=active]:shadow-sm" data-tab="behavior" data-state="inactive">Behavior</button>
                <button type="button" class="tab-trigger data-[state=active]:bg-background text-foreground inline-flex h-[calc(100%-1px)] flex-1 items-center justify-center gap-1.5 rounded-md border border-transparent px-2 py-1 text-sm font-medium whitespace-nowrap transition-[color,box-shadow] data-[state=active]:shadow-sm" data-tab="redirects" data-state="inactive">Redirects</button>
                <button type="button" class="tab-trigger data-[state=active]:bg-background text-foreground inline-flex h-[calc(100%-1px)] flex-1 items-center justify-center gap-1.5 rounded-md border border-transparent px-2 py-1 text-sm font-medium whitespace-nowrap transition-[color,box-shadow] data-[state=active]:shadow-sm" data-tab="geo" data-state="inactive"><x-icon name="globe" />Geo</button>
                <button type="button" class="tab-trigger data-[state=active]:bg-background text-foreground inline-flex h-[calc(100%-1px)] flex-1 items-center justify-center gap-1.5 rounded-md border border-transparent px-2 py-1 text-sm font-medium whitespace-nowrap transition-[color,box-shadow] data-[state=active]:shadow-sm" data-tab="visitors" data-state="inactive"><x-icon name="users" />Visitors</button>
            </div>

            @session('settings-updated')
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700"><p>{{ $value }}</p></div>
            @endsession

            <form method="POST" action="{{ route('admin.settings.patch') }}" data-loading-form data-settings-form>
                @csrf
                @method('PATCH')

                @if ($errors->any())
                    <div class="rounded-md bg-red-50 p-4 text-sm text-red-700">
                        @foreach ($errors->all() as $message)<p>{{ $message }}</p>@endforeach
                    </div>
                @endif

                <div data-tab-panel="access" data-settings-tab="access" class="flex-1 outline-none active">
                    <div class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border py-6 shadow-sm">
                        <div class="flex flex-col gap-1.5 px-6">
                            <div class="leading-none font-semibold flex items-center gap-2"><x-icon name="shield" class="h-5 w-5" />Access Settings</div>
                            <div class="text-muted-foreground text-sm">Configure authentication and security settings</div>
                        </div>
                        <div class="px-6 space-y-4">
                            <div class="space-y-2">
                                <label for="admin_panel" class="text-sm leading-none font-medium select-none">Admin Panel URL</label>
                                <div class="flex items-center space-x-2">
                                    <input id="admin_panel" name="admin_panel" value="{{ old('admin_panel', $settings['admin_panel']) }}" placeholder="admin/hidden"
                                           class="border-input text-muted-foreground placeholder:text-muted-foreground flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs outline-none md:text-sm">
                                </div>
                                @error('admin_panel')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label for="username" class="text-sm leading-none font-medium select-none flex items-center gap-1"><x-icon name="user" /> Username</label>
                                    <input id="username" name="username" value="{{ old('username', $settings['username']) }}"
                                           class="border-input text-muted-foreground flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs outline-none md:text-sm">
                                    @error('username')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                                </div>
                                <div class="space-y-2">
                                    <label for="password" class="text-sm leading-none font-medium select-none flex items-center gap-1"><x-icon name="key" /> Password</label>
                                    <input id="password" name="password" type="password" autocomplete="new-password"
                                           class="border-input text-muted-foreground flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs outline-none md:text-sm">
                                    @error('password')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label for="email_result" class="text-sm leading-none font-medium select-none flex items-center gap-1"><x-icon name="mail" /> Email Result</label>
                                <input id="email_result" name="email_result" type="email" value="{{ old('email_result', $settings['email_result']) }}"
                                       class="border-input text-muted-foreground flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs outline-none md:text-sm">
                                @error('email_result')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div data-tab-panel="stopbot" data-settings-tab="stopbot" class="flex-1 outline-none">
                    <div class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border py-6 shadow-sm">
                        <div class="flex flex-col gap-1.5 px-6">
                            <div class="flex items-center justify-between">
                                <span class="text-foreground/90 transform text-sm font-bold transition-all duration-300 disabled:opacity-100">V{{ $stopbot ? 2 : 1 }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <label for="stopbot_toggle" class="text-sm leading-none font-medium select-none">Enable Stopbot.net?
                                    <p class="text-muted-foreground text-sm">Integrate antibot with Stopbot</p>
                                </label>
                                <input type="checkbox" role="switch" id="stopbot_toggle" data-toggle-stopbot data-stopbot-panel="stopbot" @checked(!empty($stopbot))
                                       class="peer inline-flex h-5 w-9 shrink-0 cursor-pointer items-center rounded-full border border-transparent bg-input shadow-xs transition-all focus-visible:outline-none">
                            </div>
                        </div>
                        <div class="px-6 space-y-4" data-stopbot-fields @disabled(empty($stopbot))>
                            <div class="space-y-2">
                                <label for="stopbot_key" class="text-sm leading-none font-medium select-none">Apikey</label>
                                <input id="stopbot_key" name="stopbot[key]" value="{{ old('stopbot.key', $stopbot?->key ?? '') }}" placeholder="Stopbot Apikey"
                                       class="border-input text-muted-foreground placeholder:text-muted-foreground flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs outline-none md:text-sm">
                                @error('stopbot.key')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                            </div>
                            <div class="space-y-2">
                                <label for="stopbot_confname" class="text-sm leading-none font-medium select-none">Config Name</label>
                                <input id="stopbot_confname" name="stopbot[confname]" value="{{ old('stopbot.confname', $stopbot?->confname ?? '') }}" placeholder="Config Name"
                                       class="border-input text-muted-foreground placeholder:text-muted-foreground flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs outline-none md:text-sm">
                                @error('stopbot')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div data-tab-panel="behavior" data-settings-tab="behavior" class="flex-1 outline-none">
                    <div class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border py-6 shadow-sm">
                        <div class="flex flex-col gap-1.5 px-6">
                            <div class="leading-none font-semibold">Behavior Settings</div>
                            <div class="text-muted-foreground text-sm">Configure how the application behaves</div>
                        </div>
                        <div class="px-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <label for="redirect_on_finish" class="text-sm leading-none font-medium select-none">Redirect on Finish</label>
                                    <p class="text-muted-foreground text-sm">Automatically redirect users when process completes</p>
                                </div>
                                <span class="flex items-center gap-2">
                                    <input type="hidden" name="redirect_on_finish" value="0">
                                    <input type="checkbox" role="switch" id="redirect_on_finish" name="redirect_on_finish" value="1" @checked(old('redirect_on_finish', $settings['redirect_on_finish']))
                                           class="peer inline-flex h-5 w-9 shrink-0 cursor-pointer items-center rounded-full border border-transparent bg-input shadow-xs transition-all">
                                </span>
                            </div>
                            @error('redirect_on_finish')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror

                            <div data-separator class="bg-border h-px w-full shrink-0"></div>

                            <div class="flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <label for="double_cards" class="text-sm leading-none font-medium select-none">Double Cards</label>
                                    <p class="text-muted-foreground text-sm">Enable double card verification process</p>
                                </div>
                                <span class="flex items-center gap-2">
                                    <input type="hidden" name="double_cards" value="0">
                                    <input type="checkbox" role="switch" id="double_cards" name="double_cards" value="1" @checked(old('double_cards', $settings['double_cards']))
                                           class="peer inline-flex h-5 w-9 shrink-0 cursor-pointer items-center rounded-full border border-transparent bg-input shadow-xs transition-all">
                                </span>
                            </div>
                            @error('double_cards')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror

                            <div data-separator class="bg-border h-px w-full shrink-0"></div>

                            <div class="flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <label for="lock_brazil" class="text-sm leading-none font-medium select-none">Lock Country</label>
                                    <p class="text-muted-foreground text-sm">Disable outside brazil</p>
                                </div>
                                <span class="flex items-center gap-2">
                                    <input type="hidden" name="lock_brazil" value="0">
                                    <input type="checkbox" role="switch" id="lock_brazil" name="lock_brazil" value="1" @checked(old('lock_brazil', $settings['lock_brazil']))
                                           class="peer inline-flex h-5 w-9 shrink-0 cursor-pointer items-center rounded-full border border-transparent bg-input shadow-xs transition-all">
                                </span>
                            </div>
                            @error('lock_brazil')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror

                            <div data-separator class="bg-border h-px w-full shrink-0"></div>

                            <div class="space-y-2">
                                <label for="parameter" class="text-sm leading-none font-medium select-none">Parameter (Optional)</label>
                                <input id="parameter" name="parameter" value="{{ old('parameter', $settings['parameter']) }}" placeholder="Optional parameter"
                                       class="border-input text-muted-foreground placeholder:text-muted-foreground flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs outline-none md:text-sm">
                                @error('parameter')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div data-tab-panel="redirects" data-settings-tab="redirects" class="flex-1 outline-none">
                    <div class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border py-6 shadow-sm">
                        <div class="flex flex-col gap-1.5 px-6">
                            <div class="leading-none font-semibold flex items-center gap-2"><x-icon name="link" class="h-5 w-5" />Redirect Settings</div>
                            <div class="text-muted-foreground text-sm">Configure redirection URLs and behavior</div>
                        </div>
                        <div class="px-6">
                            <div class="space-y-2">
                                <label for="external_redirect" class="text-sm leading-none font-medium select-none">External Redirect URL</label>
                                <input id="external_redirect" name="external_redirect" type="url" value="{{ old('external_redirect', $settings['external_redirect']) }}" placeholder="https://example.com"
                                       class="border-input text-muted-foreground placeholder:text-muted-foreground flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs outline-none md:text-sm">
                                <p class="text-muted-foreground text-sm">The URL where users will be redirected when the process completes</p>
                                @error('external_redirect')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div data-tab-panel="geo" data-settings-tab="geo" class="flex-1 outline-none">
                    <div class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border py-6 shadow-sm">
                        <div class="flex flex-col gap-1.5 px-6">
                            <div class="leading-none font-semibold flex items-center gap-2"><x-icon name="globe" class="h-5 w-5" />Geo Lookup Settings</div>
                            <div class="text-muted-foreground text-sm">Configure the IP geolocation provider</div>
                        </div>
                        <div class="px-6 space-y-4">
                            <div class="space-y-2">
                                <label for="ipify_key" class="text-sm leading-none font-medium select-none flex items-center gap-1"><x-icon name="key" /> Ipify API Key</label>
                                <input id="ipify_key" name="ipify_key" value="{{ old('ipify_key', $settings['ipify_key'] ?? '') }}" placeholder="..." autocomplete="off"
                                       class="border-input text-muted-foreground flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs outline-none md:text-sm">
                                <p class="text-muted-foreground text-sm">Fallback geolocation source used when FindIP cannot resolve an address. Leave blank to use the built-in key.</p>
                                @error('ipify_key')<p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end" data-settings-actions>
                    <button type="submit" data-submit class="items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground shadow-xs hover:bg-primary/90 inline-flex h-9 px-4 py-2"><x-icon name="save" />Save Settings</button>
                </div>
            </form>

            <div data-visitors-url="{{ route('admin.visitors') }}" data-tab-panel="visitors" class="flex-1 outline-none">
                @include('admin.partials.visitor-analytics')
            </div>

            <div class="mt-6 flex justify-between">
                <a href="{{ route('admin.logout') }}" class="items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 bg-destructive text-white shadow-xs hover:bg-destructive/90 inline-flex h-9 px-4 py-2">Logout</a>
            </div>
        </div>
    </div>
</main>
</body>
</html>
