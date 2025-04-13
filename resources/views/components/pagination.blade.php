@if ($paginator && $paginator->hasPages())
    <nav class="flex justify-center mt-6" role="navigation" aria-label="Pagination Navigation">
        <ul class="inline-flex items-center space-x-1">

            {{-- 前のページ --}}
            @if ($paginator->onFirstPage())
                <li class="px-3 py-1 text-gray-400 bg-gray-100 rounded">前へ</li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="px-3 py-1 text-blue-500 bg-white border border-gray-300 rounded hover:bg-blue-100">
                        前へ
                    </a>
                </li>
            @endif

            {{-- ページ番号 --}}
            @foreach ($paginator->items() as $item)
                @if (is_string($item))
                    <li class="px-3 py-1 text-gray-400">…</li>
                @endif
                {{ dd($item) }}

                @if (is_array($item))
                    @foreach ($item as $page => $url)
                        @if ($page == $paginator->currentPage())
                        <li class="px-3 py-1 text-white bg-blue-500 rounded">{{ $page }}</li>
                        @else
                        <li>
                            <a href="{{ $url }}"
                                class="px-3 py-1 text-blue-500 bg-white border border-gray-300 rounded hover:bg-blue-100">
                                {{ $page }}
                            </a>
                        </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- 次のページ --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="px-3 py-1 text-blue-500 bg-white border border-gray-300 rounded hover:bg-blue-100">
                        次へ
                    </a>
                </li>
            @else
                <li class="px-3 py-1 text-gray-400 bg-gray-100 rounded">次へ</li>
            @endif

        </ul>
    </nav>
@endif