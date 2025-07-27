<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ورود کاربر</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<form method="POST" action="{{ route('login.attempt') }}"
      class="bg-white p-8 rounded shadow-md w-full max-w-sm space-y-4">
    @csrf

    <h2 class="text-xl font-bold text-center mb-4">ورود به سیستم</h2>

    @if ($errors->any())
        <div class="text-red-500 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <div>
        <label class="block text-sm">ایمیل</label>
        <input type="email" name="email" required autofocus
               class="mt-1 w-full border px-3 py-2 rounded">
    </div>

    <div>
        <label class="block text-sm">رمز عبور</label>
        <input type="password" name="password" required
               class="mt-1 w-full border px-3 py-2 rounded">
    </div>

    <button type="submit"
            class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
        ورود
    </button>
</form>

</body>
</html>
