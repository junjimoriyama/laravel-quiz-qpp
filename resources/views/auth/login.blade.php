<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <p class="mb-5 text-center text-blue-900 font-bold">ログイン</p>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 mb-2 w-full" type="email" name="email" :value="old('email', 'user@example.com')" required
                autofocus autocomplete="username" />
                <div class="flex gap-8 text-gray-400">
                    <p class="text-xs">ユーザー：user@example.com</p>
                    <p class="text-xs">管理者：test@example.com</p>
                </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 mb-2 w-full" type="password" name="password" :value="old('password', '111')" required
                autocomplete="current-password"/>
                <div class="flex gap-8 text-gray-400">
                    <p class="text-xs">ユーザー：111</p>
                    <p class="text-xs">管理者：123</p>
                </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- 管理者チェックボックス -->
        <div class="mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="admin_login" value="1"
                    class="rounded border-gray-300 text-blue-900 shadow-sm focus:ring-text-blue-900">
                <span class="ml-2 text-sm text-blue-900">管理者としてログインする</span>
            </label>
        </div>


        <div class="flex items-center justify-end gap-3 mt-4">

            {{-- <button type="button" onclick="location.href='/'"
                class="p-2 border border-blue-900 rounded-md bg-white text-blue-900 transition duration-300 cursor-pointer hover:opacity-50">戻る
            </button> --}}
            <p class="text-sm text-red-300 underline">このままログインできます</p>
            <button
                class="p-2 rounded-md bg-blue-900 text-white transition duration-300 cursor-pointer hover:opacity-50">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</x-guest-layout>

<!-- Remember Me -->
{{-- <div class="block mt-4">
    <label for="remember_me" class="inline-flex items-center">
        <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
    </label>
</div> --}}
{{-- @if (Route::has('password.request'))
<a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
    {{ __('Forgot your password?') }}
</a>
@endif --}}
