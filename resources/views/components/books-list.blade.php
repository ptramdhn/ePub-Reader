@if($books->count() > 0)
    
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach($books as $book)
        <a href="{{ route('books.read', $book->id) }}" class="group flex flex-col bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 h-full">
            
            <div class="relative aspect-[3/4] bg-gray-100 dark:bg-gray-700 overflow-hidden">
                @if($book->cover_path)
                    <img src="{{ asset('storage/' . $book->cover_path) }}" 
                         alt="{{ $book->title }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                        <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-xs font-bold uppercase tracking-widest">{{ __('messages.library.no_cover') }}</span>
                    </div>
                @endif
                
                <div class="absolute top-2 right-2">
                    <span class="bg-white/90 dark:bg-gray-900/90 backdrop-blur px-2 py-1 rounded text-[10px] font-bold text-uin-blue dark:text-uin-yellow shadow-sm border border-gray-100 dark:border-gray-700">
                        {{ $book->category }}
                    </span>
                </div>
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
            </div>

            <div class="p-4 flex-1 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white text-base leading-tight line-clamp-2 mb-1 group-hover:text-uin-blue dark:group-hover:text-uin-yellow transition-colors" title="{{ $book->title }}">
                        {{ $book->title }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $book->author }}</p>
                </div>
                
                <div class="mt-4 pt-3 border-t border-gray-50 dark:border-gray-700 flex items-center text-xs font-medium text-uin-green">
                    <span>{{ __('messages.library.read_now') }}</span>
                    <svg class="w-3 h-3 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    
    <div class="mt-10">
        {{ $books->withQueryString()->links() }}
    </div>

@else

    <div class="flex flex-col items-center justify-center py-20 bg-white dark:bg-gray-800 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700 text-center">
        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 text-gray-400 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.library.empty_title') }}</h3>
        <p class="text-gray-500 dark:text-gray-400 max-w-sm mx-auto mt-1">{{ __('messages.library.empty_desc') }}</p>
    </div>

@endif