<header class="bg-customBlue text-white px-6 py-4 flex justify-between items-center shadow-md gap-x-3">
    <div class="w-48">
        <p class="text-lg">
            فناپ
        </p>
    </div>

    {{-- لینک‌ها سمت راست --}}
    <div class="flex items-center gap-x-6 w-full justify-between">
        <div class="flex items-center space-x-4 space-x-reverse">
            @if( auth()->user()?->role == App\Enums\UserRoleEnum::ADMIN->value )
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 rounded-lg font-semibold transition
                   {{ request()->routeIs('dashboard') ? 'text-pumpkin' : 'text-white hover:text-pumpkin' }}">
                    پنل مدیریت
                </a>
            @endif
        </div>

        {{-- لینک خروج سمت چپ --}}
        <div>
            <a href="{{ route('logout') }}"
               class="block px-4 py-2 text-sm text-red-400 hover:text-red-600 transition">
                 خروج
            </a>
        </div>
    </div>
</header>
