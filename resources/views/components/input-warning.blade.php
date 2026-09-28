@props(['message'])
@if ($message)
<p class="flex items-center gap-2 text-sm"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" aria-hidden="true"><path d="M12.375 3.375a9 9 0 1 0 9 9 9 9 0 0 0-9-9ZM13.2 16.529h-1.656v-6.235H13.2Zm-.826-6.914a.864.864 0 1 1 .9-.865.867.867 0 0 1-.9.865Z" transform="translate(-3.375 -3.375)" fill="#ecbd20"/></svg><span>{{ $message }}</span></p>
@endif
