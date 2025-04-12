<x-app-layout>
    <div class="py-12 flex min-h-screen gap-1">
        <!-- left side content component -->
        <div class="basis-0 grow">

        </div>

        <!-- left side content component -->

        <!-- main content component -->
        <div class="basis-0 grow-[3] w-full">
            <!-- 記事タイトル検索バー -->
            <div class="w-1/2 mx-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="text" placeholder="記事タイトルで検索" class="w-4/5">
                    <button type="submit" class="ml-1 border rounded text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                        検索
                    </button>
                </form>
            </div>
            <!-- 記事タイトル検索バー -->

            <!-- 記事一覧一覧エリア -->
            <ul>


            </ul>


            <!-- 記事一覧一覧エリア -->

            <!-- ページネーション component -->
            <!-- ページネーション component -->

        </div>
        <!-- main content component -->

        <!-- right side content component -->
        <div class="basis-0 grow">

        </div>

        <!-- right side content component -->
    </div>
</x-app-layout>