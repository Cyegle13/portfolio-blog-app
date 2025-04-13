<x-app-layout>
    <div class="py-12 flex min-h-screen gap-1">
        {{-- left side content component --}}
        <x-left-column />
        {{-- left side content component --}}

        {{-- main content component --}}
        <div class="basis-0 grow-[3] w-full">
            <div class="mx-auto p-6 bg-white rounded-2xl shadow-md mt-8">
                {{-- 記事内容詳細セクション --}}
                <section>
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">
                        {{ $post->title }}
                    </h1>

                    <div class="prose mb-6">
                        {!! nl2br(e($post->body)) !!}
                    </div>
                    

                    @if ($post->user_id == Auth::id())
                    <div class="mt-8 text-right">
                        <a href="{{ route('posts.edit', $post->id) }}"
                            class="inline-block px-5 py-2 bg-blue-600 text-white font-semibold rounded-xl shadow hover:bg-blue-700 transition">
                            編集する
                        </a>
                    </div>
                    @endif


                </section>

                {{-- 記事コメントセクション --}}
                <section>
                    <div class="mt-8">
                        <h2 class="text-2xl font-semibold text-gray-700 mb-4">コメント</h2>

                        @if($post->comments->isEmpty())
                            <p class="text-gray-500">まだコメントはありません。</p>
                        @else
                            <ul class="space-y-4">
                                @foreach($post->comments as $comment)
                                    <li class="p-3 bg-gray-50 border rounded-lg flex justify-between items-start">
                                        <div class="flex-1">
                                            <p class="text-gray-700">{!! nl2br(e($comment->comment)) !!}</p>
                                            <p class="text-xs text-gray-500 mt-2 text-right">
                                                <span class="">投稿者: {{ $comment->user->name ?? '名無し' }}</span>
                                                <span class="ml-5">投稿日時: {{ $comment->created_at->format('Y-m-d H:i') }}</span>
                                            </p>
                                        </div>

                                        <div class="flex space-x-2 justify-end w-[100px]" x-data="{ open: false }">
                                            @auth
                                                @if ($comment->user_id == Auth::id())
                                                    <button @click="open = true" class="text-blue-500 hover:underline">
                                                        編集
                                                    </button>
                                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="ml-4 text-sm text-red-600 hover:underline">削除</button>
                                                    </form>

                                                    <div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                                                        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg relative">
                                                            <h2 class="text-xl font-semibold mb-4">コメント編集</h2>

                                                            <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="space-y-4">
                                                                @csrf
                                                                @method('PUT')

                                                                <textarea name="comment" rows="4" class="w-full border p-2 rounded">{{ old('comment', $comment->comment) }}</textarea>

                                                                <div class="flex justify-end space-x-2">
                                                                    <button type="button" @click="open = false"
                                                                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                                                        キャンセル
                                                                    </button>
                                                                    <button type="submit"
                                                                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                                                        更新する
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endauth
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    @auth
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">コメントを書く</h3>
                        <x-error-messages :errors="$errors" />
                        <form action="{{ route('comments.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">

                            <textarea name="comment" rows="3"
                                class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-300"
                                placeholder="コメントを入力してください..."></textarea>

                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                コメントを投稿
                            </button>
                        </form>
                    </div>
                    @endauth

                </section>

            </div>

        </div>
        {{-- main content component --}}

        {{-- right side content component --}}
        <x-right-column />

        {{-- right side content component --}}
    </div>
</x-app-layout>