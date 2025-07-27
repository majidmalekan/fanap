<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ورود ادمین</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen  font-IRANSans">

<form method="POST" action="{{ route('admin.login.attempt') }}"
      class="bg-white p-8 rounded shadow-md w-full max-w-sm space-y-4">
    @csrf

    <h2 class="text-xl font-bold text-center mb-4">ورود به پنل ادمین</h2>

    @if ($errors->any())
        <div class="text-red-500 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">ایمیل</label>
        <input type="email" name="email" id="email" required autofocus
               class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">رمز عبور</label>
        <input type="password" name="password" id="password" required
               class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>

    <button type="submit"
            class="w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700">
        ورود
    </button>
</form>

</body>
</html>
