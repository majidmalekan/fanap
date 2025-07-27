@extends('Layouts.app')
@section('title', 'لیست نظرسنجی‌ها')
@section('content')
    <div class="bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">نظرسنجی‌ها</h2>
            @if ($errors->any())
                <div class="fixed top-5 right-5 space-y-2">
                    @foreach ($errors->all() as $error)
                        <div class="bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center">
                            <span class="mr-2">⚠️</span>
                            <span>{{ $error }}</span>
                            <button onclick="this.parentElement.remove()" class="ml-auto text-white font-bold">✖</button>
                        </div>
                    @endforeach
                </div>
            @endif
            <a href="{{ route('admin.polls.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">
                + ایجاد نظرسنجی جدید
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border text-sm text-gray-700">
            <thead>
            <tr class="bg-gray-100">
                <th class="p-2 text-right">#</th>
                <th class="p-2 text-right">عنوان</th>
                <th class="p-2 text-right">تاریخ شروع</th>
                <th class="p-2 text-right">تاریخ پایان</th>
                <th class="p-2 text-right">نتایج</th>
                <th class="p-2 text-right">عملیات</th>
            </tr>
            </thead>
            <tbody>
            @forelse($polls as $poll)
                <tr class="border-t">
                    <td class="p-2">{{ $poll->id }}</td>
                    <td class="p-2">{{ $poll->title }}</td>
                    <td class="p-2">{{ convertLatinDateToPersian($poll->start_at) }}</td>
                    <td class="p-2">{{ convertLatinDateToPersian($poll->end_at) }}</td>
                    <td class="p-2 text-sm space-y-1">
                        @foreach ($poll->options as $option)
                            <div>
                                {{ $option->text }}:
                                {{ $poll->vote_percentages[$option->id] ?? 0 }}%
                            </div>
                        @endforeach
                    </td>
                    <td class="p-2 space-x-2">
                        <a href="{{ route('admin.polls.edit', $poll->id) }}"
                           class="text-blue-600 hover:underline">ویرایش</a>

                        <form action="{{ route('admin.polls.destroy', $poll->id) }}"
                              method="POST" class="inline-block"
                              onsubmit="return confirm('آیا از حذف مطمئن هستید؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">
                                حذف
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">هیچ نظرسنجی‌ای ثبت نشده است.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $polls->links() }}
        </div>
    </div>
@endsection
