@php use App\Enums\UserRoleEnum; @endphp
    <!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'صفحه کنسول')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    @stack('styles')
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('vendor/persian-datepicker/persian-datepicker.min.css') }}">
    <script src="{{ asset('vendor/persian-datepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('vendor/persian-datepicker/persian-datepicker.min.js') }}"></script>
</head>
<body
    class="{{ session('current_area') == UserRoleEnum::ADMIN->value ? 'bg-gray-100 flex justify-center min-h-screen font-IRANSans ' : 'bg-white flex flex-col justify-center min-h-screen font-IRANSans' }}">
@if( auth()->check() )
    @if( session('current_area') == UserRoleEnum::ADMIN->value)
        <x-layouts.admin-sidebar/>
    @else
        <x-layouts.user-header/>
    @endif
@endif

<main class="flex-grow bg-white">
    @yield('content')
</main>
@stack('scripts')
</body>
</html>
