<div class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border py-6 shadow-sm">
    <div class="flex flex-col gap-1.5 px-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="leading-none font-semibold flex items-center gap-2">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                    Visitor Analytics
                </div>
                <div class="text-muted-foreground text-sm">View and analyze visitor data and activity</div>
            </div>
            <div class="flex items-center gap-2">
                <div class="text-muted-foreground text-sm"><span>Auto Reload: </span></div>
                <label class="peer focus-visible:ring-ring focus-visible:ring-offset-background inline-flex h-11 w-20 shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent bg-slate-700/90 transition-colors focus-within:ring-2 focus-within:ring-offset-2 focus-within:outline-none disabled:cursor-not-allowed disabled:opacity-50">
                    <input type="checkbox" id="auto-reload" data-auto-reload checked class="sr-only">
                    <span class="bg-background/60 border-background/20 pointer-events-none flex h-9 w-9 translate-x-0 items-center justify-center rounded-full border shadow-lg ring-0 backdrop-blur-sm transition-transform" data-auto-reload-thumb>
                        <span id="auto-reload-label" class="bg-red-100 text-red-800 text-xs font-medium" aria-label="Toggle polling">On</span>
                    </span>
                </label>
            </div>
        </div>
    </div>
    <div class="px-6">
        <div id="visitors-region">
            @include('admin.partials.visitors-table')
        </div>
    </div>
</div>
