<nav class="bg-white shadow">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
    <!-- 左側：タイトル -->
     <div class="">
       <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800">
         サイトタイトル
       </a>
     </div>

    <!-- 右側：ナビ -->
    <div class="flex items-center space-x-4 gap-6">
      <div>
        @guest
        <!-- 未ログイン時：ログインボタン -->
        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-500 font-medium">
          ログイン
        </a>
        @endguest
  
        @auth
        <!-- 記事登録リンク -->
        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-500 font-medium">
          記事登録
        </a>
        @endauth
      </div>

      <!-- アカウントドロップダウン -->
      @auth
      <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-blue-500 focus:outline-none">
          <span>アカウント</span>
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.08 1.04l-4.25 4.65a.75.75 0 01-1.08 0l-4.25-4.65a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
          </svg>
        </button>

        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg z-50">
          <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">アカウント情報</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
              ログアウト
            </button>
          </form>
        </div>
      </div>
      @endauth
    </div>
  </div>
</nav>