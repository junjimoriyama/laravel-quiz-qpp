<header class="flex justify-between items-center w-full  h-[var(--header-height)] p-5 bg-white">
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
                <button onclick="document.getElementById('LogoutModal').classList.remove('hidden')"
                    class="p-3 h-[40px] rounded-md text-sm text-white bg-blue-900 transition duration-300 hover:opacity-50">
                    {{-- 管理者とユーザーで文字の出しわけ --}}
                    {{ Auth::user()->is_admin ? '管理者ログアウト' : 'ログアウト'}}
                </button>
                {{-- モーダル --}}
                <x-modal id="LogoutModal" message="本当にログアウトしますか？" :onConfirm="'document.getElementById(\'logoutForm\').submit();'" />
                <form  id="logoutForm" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
            @endauth
        </div>
    </div>
</header>


{{-- <header class="flex justify-between items-center w-full  h-[var(--header-height)] p-5 bg-white">
    <div class="flex justify-between items-center w-full">
        <div>
<x-svg.main-logo class="" />
</div>
<div class="flex gap-3">
    @guest
        <x-svg.admin-icon />
    @endguest
    @auth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button onclick="document.getElementById('LogoutModal').classList.remove('hidden')"
                class="p-3 h-[40px] rounded-md text-sm text-white bg-blue-900 transition duration-300 hover:opacity-50">管理者ログアウト
            </button>

            <x-modal id="LogoutModal" message="本当にログアウトしますか？"
                onConfirm="document.getElementById('LogoutModal').classList.remove('hidden')" />

            <form action="">

            </form>
        </form>
        @endauth
    </div>
</div>
</header> --}}
{{-- <button :href="route('logout')"
    onclick="event.preventDefault();
    this.closest('form').submit();"
    class="p-3 h-[40px] rounded-md text-sm text-white bg-blue-900 transition duration-300 hover:opacity-50">管理者ログアウト
</button> --}}
