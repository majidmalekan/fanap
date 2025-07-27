@php use App\Enums\UserRoleEnum; @endphp
<aside class="w-64 bg-gray-800 text-gray-100 p-4">
    <div class="mb-6">
        <img src="{{ asset('Image/fanap-logo.png') }}" alt="Logo" class="w-30 h-30 mx-auto">
    </div>
    <nav>
        <ul>
            <li class="mb-4">
                <a href="{{ route('admin.polls.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700">مشاهده
                    نظرسنجی ها</a>
            </li>
            <li class="mb-4">
                <a href="{{ route('admin.logout') }}" class="block py-2 px-4 rounded hover:bg-gray-700">خروج</a>
            </li>
        </ul>
    </nav>
</aside>
