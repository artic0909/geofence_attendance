@if ($paginator->hasPages())
    <div class="flex items-center justify-center gap-4 mt-6 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button disabled class="px-4 py-2 text-sm font-medium text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-not-allowed">
                &laquo; Prev
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                &laquo; Prev
            </a>
        @endif

        {{-- Page Inputs --}}
        <div class="flex items-center space-x-2">
            <input type="number" 
                   value="{{ $paginator->currentPage() }}" 
                   min="1" 
                   max="{{ $paginator->lastPage() }}"
                   onkeydown="if(event.key === 'Enter') { 
                        let val = parseInt(this.value); 
                        let max = parseInt(this.getAttribute('max'));
                        if(val >= 1 && val <= max) {
                            let url = new URL('{{ $paginator->url(1) }}', window.location.origin);
                            url.searchParams.set('page', val);
                            window.location.href = url.toString();
                        }
                   }"
                   class="w-16 text-center px-2 py-1 text-sm font-medium text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400"
            >
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">/</span>
            <input type="number" 
                   value="{{ $paginator->lastPage() }}" 
                   disabled 
                   class="w-16 text-center px-2 py-1 text-sm font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md cursor-not-allowed"
            >
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                Next &raquo;
            </a>
        @else
            <button disabled class="px-4 py-2 text-sm font-medium text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-not-allowed">
                Next &raquo;
            </button>
        @endif
    </div>
@endif
