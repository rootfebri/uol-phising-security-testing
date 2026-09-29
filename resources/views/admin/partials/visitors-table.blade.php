@if ($visitors->isEmpty())
    <div class="flex flex-col items-center justify-center py-12 text-center">
        <svg class="text-muted-foreground/50 mb-4 h-12 w-12" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
        <p class="text-muted-foreground">No visitor data available</p>
        <a href="{{ route('admin.dashboard') }}" class="items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] border bg-background shadow-xs hover:bg-accent hover:text-accent-foreground disabled:pointer-events-none disabled:opacity-50 border-input inline-flex h-9 mt-4 px-4 py-2">Refresh Data</a>
    </div>
@else
    <div class="overflow-x-auto rounded-md border">
        <table class="w-full caption-bottom text-sm">
            <thead class="[&_tr]:border-b">
                <tr class="data-[state=selected]:bg-muted hover:bg-muted/50 bg-muted/50 transition-colors">
                    <th class="text-foreground h-10 px-2 text-left align-middle font-medium [&:has([role=checkbox])]:pr-0">ID</th>
                    <th class="text-foreground h-10 px-2 text-left align-middle font-medium [&:has([role=checkbox])]:pr-0">IP Address</th>
                    <th class="text-foreground h-10 px-2 text-left align-middle font-medium [&:has([role=checkbox])]:pr-0">Browser</th>
                    <th class="text-foreground h-10 px-2 text-left align-middle font-medium [&:has([role=checkbox])]:pr-0">Location</th>
                    <th class="text-foreground h-10 px-2 text-left align-middle font-medium [&:has([role=checkbox])]:pr-0">Status</th>
                    <th class="text-foreground h-10 px-2 text-left align-middle font-medium [&:has([role=checkbox])]:pr-0">Last Seen</th>
                    <th class="text-foreground h-10 px-2 text-left align-middle font-medium w-[60px]">Actions</th>
                </tr>
            </thead>
            <tbody class="[&_tr:last-child]:border-0">
            @foreach ($visitors as $visitor)
                @php
                    $status = $visitor->antibot_status;
                    $statusColor = match ($status->name) {
                        'Allowed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                        'Disallowed' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                        default => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                    };
                    $paramColor = $visitor->parameter_status->name === 'Matched'
                        ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                        : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
                @endphp
                <tr class="hover:bg-muted/30 border-b transition-colors" data-visitor-row="{{ $visitor->id }}">
                    <td class="p-2 align-middle [&:has([role=checkbox])]:pr-0">
                        <div class="flex items-center gap-2 font-medium">
                            <button type="button" class="items-center justify-center rounded-md text-sm font-medium whitespace-nowrap transition-[color,box-shadow] hover:bg-accent hover:text-accent-foreground disabled:pointer-events-none disabled:opacity-50 h-6 w-6"
                                    data-expand="{{ $visitor->id }}" aria-expanded="false" aria-label="Toggle details">
                                <svg class="h-4 w-4" data-chevron xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                            </button>
                            <p>{{ $visitor->id }}</p>
                        </div>
                    </td>
                    <td class="p-2 align-middle font-mono text-xs [&:has([role=checkbox])]:pr-0">{{ $visitor->ip_address }}</td>
                    <td class="p-2 align-middle max-w-[150px] truncate [&:has([role=checkbox])]:pr-0">{{ $visitor->browser->toString() }}</td>
                    <td class="p-2 align-middle [&:has([role=checkbox])]:pr-0">
                        <span class="cursor-default" title="{{ $visitor->city }}, {{ $visitor->state }}, {{ $visitor->country }}">{{ $visitor->city }}</span>
                    </td>
                    <td class="p-2 align-middle [&:has([role=checkbox])]:pr-0">
                        <div class="flex flex-col gap-1">
                            <span class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 gap-1 transition-[color,box-shadow] overflow-hidden border {{ $statusColor }}">{{ $status->name }}</span>
                        </div>
                    </td>
                    <td class="p-2 align-middle [&:has([role=checkbox])]:pr-0">
                        <span class="text-muted-foreground hover:text-foreground flex cursor-pointer items-center gap-1 text-sm transition-colors"
                              title="Created: {{ $visitor->created_at->format('M j, Y, g:i:s A') }}&#10;Last seen: {{ $visitor->updated_at->format('M j, Y, g:i:s A') }}">
                            <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                            <span data-time-ago="{{ $visitor->updated_at->toIso8601String() }}">{{ $visitor->updated_at->diffForHumans() }}</span>
                        </span>
                    </td>
                    <td class="p-2 align-middle [&:has([role=checkbox])]:pr-0">
                        <div class="relative flex justify-end">
                            <button type="button" class="inline-flex items-center justify-center rounded-md text-sm font-medium whitespace-nowrap transition-[color,box-shadow] hover:bg-accent hover:text-accent-foreground disabled:pointer-events-none disabled:opacity-50 h-8 w-8 p-0"
                                    data-menu-toggle="{{ $visitor->id }}" aria-label="Open menu" aria-expanded="false">
                                <span class="sr-only">Open menu</span>
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                            </button>
                            <div class="z-50 min-w-[8rem] overflow-hidden rounded-md border bg-popover text-popover-foreground shadow-md hidden absolute right-0 top-full" data-menu="{{ $visitor->id }}">
                                <div class="p-1">
                                    <button type="button" class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none hover:bg-accent focus:bg-accent focus:text-accent-foreground">Block IP</button>
                                    <button type="button" class="relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none text-red-600 hover:bg-accent focus:bg-accent focus:text-accent-foreground">Delete Record</button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="bg-muted/20 hidden" data-visitor-detail="{{ $visitor->id }}">
                    <td colspan="7" class="p-0 align-middle">
                        <div class="grid grid-cols-2 gap-4 p-4 text-sm md:grid-cols-3">
                            <div><h4 class="text-muted-foreground mb-1 text-xs font-semibold">User Agent</h4><p class="truncate text-xs break-words">{{ $visitor->user_agent }}</p></div>
                            <div><h4 class="text-muted-foreground mb-1 text-xs font-semibold">ISP</h4><p>{{ $visitor->isp }}</p></div>
                            <div><h4 class="text-muted-foreground mb-1 text-xs font-semibold">User Type</h4><p>{{ $visitor->user_type->name }}</p></div>
                            <div>
                                <h4 class="text-muted-foreground mb-1 text-xs font-semibold">Parameter Status</h4>
                                <span class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium whitespace-nowrap shrink-0 transition-[color,box-shadow] overflow-hidden border {{ $paramColor }}">{{ $visitor->parameter_status->name }}</span>
                                <h4 class="text-muted-foreground mb-1 text-xs font-semibold">Antibot Status</h4>
                                <span class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium whitespace-nowrap shrink-0 transition-[color,box-shadow] overflow-hidden border {{ $statusColor }}">{{ $status->name }}</span>
                                <h4 class="text-muted-foreground mb-1 text-xs font-semibold">Details</h4>
                                <p>{{ $visitor->visitor_details }}</p>
                            </div>
                            <div>
                                <h4 class="text-muted-foreground mb-1 text-xs font-semibold">Pages</h4>
                                <div>
                                    <p class="text-xs"><span class="text-muted-foreground">First:</span> {{ $visitor->first_page }}</p>
                                    <p class="text-xs"><span class="text-muted-foreground">Last:</span> {{ $visitor->last_page }}</p>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-muted-foreground mb-1 text-xs font-semibold">Status</h4>
                                <div class="flex flex-col gap-2">
                                    <div class="flex items-center gap-2"><span class="text-muted-foreground text-xs">Card Count:</span><span>{{ $visitor->card_count }}</span></div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-muted-foreground text-xs">Completed:</span>
                                        <span class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium whitespace-nowrap shrink-0 transition-[color,box-shadow] overflow-hidden border {{ $visitor->is_finished ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' }}">{{ $visitor->is_finished ? 'Yes' : 'No' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
