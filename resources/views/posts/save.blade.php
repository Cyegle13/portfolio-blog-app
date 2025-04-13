<x-app-layout>
    <div class="py-12 flex min-h-screen gap-1">
        {{-- left side content component --}}
        <x-left-column />
        {{-- left side content component --}}

        {{-- main content component --}}
        <div class="basis-0 grow-[3] w-full">
            <div class="mx-auto p-6 bg-white rounded-2xl shadow-md mt-8">
                {{-- 記事登録・編集セクション --}}
                @php
                    $isEdit = ! is_null($post->id);
                @endphp
                <section>
                    <ul class="flex justify-between items-center">
                        <li>
                            <h1 class="text-2xl font-bold mb-6">記事を{{ $isEdit ? '編集する' : '新規作成する' }}</h1>
                        </li>
                        @if ($isEdit)
                            <li>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-4 text-sm text-red-600 hover:underline">削除</button>
                                </form>
                            </li>
                        @endif

                    </ul>

                    <x-error-messages :errors="$errors" />

                    <form 
                        action="{{ $isEdit ? route('posts.update', $post->id) : route('posts.store') }}" 
                        method="POST" 
                        class="space-y-6 bg-white p-6 rounded shadow"
                    >
                        @csrf
                        @if($isEdit)
                            @method('PUT')
                        @endif

                        <div>
                            <label for="title" class="block text-gray-700 font-semibold mb-1">タイトル</label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title"
                                value="{{ old('title', $post->title ?? '') }}" 
                                class="w-full border p-2 rounded"
                            >
                        </div>

                        <div>
                            <label for="body" class="block text-gray-700 font-semibold mb-1">本文</label>
                            <textarea 
                                name="body" 
                                id="body"
                                rows="6" 
                                class="w-full border p-2 rounded" 
                            >
                                {{ old('body', $post->body ?? '') }}
                            </textarea>
                        </div>

                        <div class="flex justify-between">
                            <div>
                                <a href="{{ $isEdit ? route('posts.show', $post->id) : route('dashboard') }}" class="text-gray-700 hover:text-blue-500 font-medium">
                                    戻る
                                </a>
                            </div>
                            <div>
                                <button 
                                    type="submit"
                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                                >
                                    {{ $isEdit ? '更新する' : '新規作成する' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
        {{-- main content component --}}

        {{-- right side content component --}}
        <x-right-column />

        {{-- right side content component --}}
    </div>
</x-app-layout>