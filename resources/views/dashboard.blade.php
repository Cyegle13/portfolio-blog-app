<x-app-layout>
    <div class="py-12 flex min-h-screen gap-1">
        {{-- left side content component --}}
        <x-left-column />

        {{-- left side content component --}}

        {{-- main content component --}}
        <div class="basis-0 grow-[3] w-full">
            {{-- 記事タイトル検索バー --}}
            <div class="w-1/2 mx-auto">
            <form method="GET" action="{{ route('dashboard') }}" class="mb-6 flex">
                <input 
                    type="text" 
                    name="keyword" 
                    placeholder="タイトル・本文・ユーザー名を検索" 
                    value="{{ request('keyword') }}"
                    class="flex-grow border rounded-l px-4 py-2"
                >
                <button 
                    type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-r hover:bg-blue-600"
                >
                    検索
                </button>
            </form>
            </div>
            {{-- 記事タイトル検索バー --}}

            {{-- 記事一覧一覧エリア --}}
            <div class="container mx-auto px-4">
                @foreach ($posts as $post)
                <div class="p-4 mb-2 flex justify-between bg-white rounded shadow">
                    <div class="flex-1">
                        <h2 class="text-lg font-bold"><a href="{{ route('posts.show', $post) }}" class="hover:bg-gray-100">{{ $post->title }}</a></h2>
                        <p>{{ Str::limit($post->body, 100) }}</p>
                    </div>
                    <div class="text-left">
                        <p class="">投稿者: {{ $post->user->name ?? '名無し' }}</p>
                        <p class="">投稿日時: {{ $post->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
                @endforeach
                
                {{-- ページネーション component --}}
                {{ $posts->appends(['keyword' => request('keyword')])->links() }}
                {{-- ページネーション component --}}
            </div>
            
            
            {{-- 記事一覧一覧エリア --}}
            

        </div>
        {{-- main content component --}}

        {{-- right side content component --}}
        <x-right-column />

        {{-- right side content component --}}
    </div>
</x-app-layout>