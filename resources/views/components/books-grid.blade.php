@if($books->count() > 0)
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($books as $book)
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-md transition group flex flex-col h-full">
        <div class="relative w-full pt-[133%] bg-gray-100 dark:bg-gray-700 overflow-hidden">
            @if($mode === 'creator')
                @if($book->status == 'pending')<div class="absolute top-0 left-0 right-0 bg-yellow-500/90 backdrop-blur-sm text-white text-[10px] font-bold text-center py-1.5 z-20">{{ __('messages.dashboard.status_pending') }}</div>
                @elseif($book->status == 'rejected')<div class="absolute top-0 left-0 right-0 bg-red-600/90 backdrop-blur-sm text-white text-[10px] font-bold text-center py-1.5 z-20">{{ __('messages.dashboard.status_rejected') }}</div>@endif
            @endif
            @if($book->cover_path)<img src="{{ asset('storage/' . $book->cover_path) }}" class="absolute inset-0 w-full h-full object-cover transition duration-500 group-hover:scale-105 {{ ($mode === 'creator' && $book->status != 'approved') ? 'opacity-75 grayscale-[50%]' : '' }}">@else<div class="absolute inset-0 flex items-center justify-center text-gray-400 dark:text-gray-500"><span class="text-xs">{{ __('messages.dashboard.no_cover') }}</span></div>@endif
            <div class="absolute top-2 right-2 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm px-2 py-1 rounded text-xs font-bold text-uin-blue dark:text-uin-yellow shadow-sm border border-gray-100 dark:border-gray-700 z-10">{{ $book->category }}</div>
        </div>
        <div class="p-4 flex-1 flex flex-col">
            <h3 class="font-bold text-gray-900 dark:text-white line-clamp-2 mb-1 group-hover:text-uin-blue dark:group-hover:text-uin-yellow transition">{{ $book->title }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $book->author }}</p>
            @if($mode === 'creator' && $book->status == 'rejected' && $book->rejection_reason)<div class="mb-4 text-xs bg-red-50 text-red-600 p-2 rounded border border-red-100"><strong>Alasan:</strong> {{ $book->rejection_reason }}</div>@endif
            <div class="mt-auto pt-4 border-t border-gray-50 dark:border-gray-700 flex gap-2">
                @if($mode === 'reader')
                    <a href="{{ route('books.read', $book->id) }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-uin-green bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/40 transition">{{ __('messages.dashboard.btn_read_now') }}</a>
                @else
                    @if($book->status == 'approved')<a href="{{ route('books.read', $book->id) }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-uin-green bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></a>@else<button disabled class="flex-1 inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 dark:bg-gray-700 rounded-lg cursor-not-allowed"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg></button>@endif
                    <a href="{{ route('books.edit', $book->id) }}" class="inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-yellow-600 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg hover:bg-yellow-100 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Hapus permanen?');">@csrf @method('DELETE')<button type="submit" class="inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-red-600 bg-red-50 dark:bg-red-900/20 rounded-lg hover:bg-red-100 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button></form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-20 bg-white dark:bg-gray-800 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700">
    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg></div>
    @if($mode === 'creator')<h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.dashboard.empty_upload_title') }}</h3><p class="text-gray-500 dark:text-gray-400 mb-6">{{ __('messages.dashboard.empty_upload_desc') }}</p><a href="{{ route('books.create') }}" class="text-uin-blue dark:text-uin-yellow font-bold hover:underline">{{ __('messages.dashboard.upload_now') }} &rarr;</a>@else<h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.dashboard.empty_lib_title') }}</h3><p class="text-gray-500 dark:text-gray-400">{{ __('messages.dashboard.empty_lib_desc') }}</p>@endif
</div>
@endif