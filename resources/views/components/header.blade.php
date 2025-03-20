<header class="flex justify-between items-center w-full h-[120px] p-5 bg-white">
    <div class="flex justify-between items-center w-full">
        <div>
            {{-- ロゴ --}}
            <x-svg.main-logo class="" />
        </div>
        <div class="flex gap-3">
            {{-- ログアウト中のみ表示 --}}
            @guest
                <x-svg.admin-icon />
            @endguest
            {{-- ログイン中のみ表示 --}}
            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button :href="route('logout')"
                    onclick="event.preventDefault();
                    this.closest('form').submit();"
                    class="p-3 h-[40px] rounded-md text-sm text-white bg-blue-900 transition duration-300 hover:opacity-50">管理者ログアウト
                </button>
            </form>
            @endauth
        </div>
    </div>
</header>
