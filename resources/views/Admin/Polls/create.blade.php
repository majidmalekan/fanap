@extends('Layouts.app')
@section('title', 'ایجاد نظرسنجی')
@section('content')
    <div class="bg-white p-6 rounded shadow max-w-2xl mx-auto">
        <h2 class="text-xl font-bold mb-4">ایجاد نظرسنجی</h2>
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
        <form action="{{ route('admin.polls.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium">عنوان</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="mt-1 block w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
                @error('title')
                <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            {{-- تاریخ‌ها --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">تاریخ شروع</label>
                    <input type="text" id="start_at_picker" class="mt-1 block w-full border rounded px-3 py-2"
                           placeholder="انتخاب تاریخ شروع">
                    <input type="hidden" name="start_at" id="start_at">
                    @error('start_at')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">تاریخ پایان</label>
                    <input type="text" id="end_at_picker" class="mt-1 block w-full border rounded px-3 py-2"
                           placeholder="انتخاب تاریخ پایان">
                    <input type="hidden" name="end_at" id="end_at">

                    @error('end_at')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- گزینه‌ها --}}
            <div>
                <label class="block text-sm font-medium mb-2">گزینه‌ها</label>

                <div id="options-wrapper" class="space-y-2">
                    {{-- اینجا اول خالیه – گزینه‌ها بعداً با جاوااسکریپت اضافه می‌شن --}}
                </div>

                <div class="mt-2">
                    <button type="button" onclick="addNewOption()"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        افزودن گزینه جدید
                    </button>
                </div>

                @error('options.*')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- دکمه --}}
            <div class="flex justify-end">
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    ذخیره
                </button>
            </div>
        </form>
    </div>
    @push('scripts')
        <script>
            function addNewOption() {
                const wrapper = document.getElementById('options-wrapper');
                const div = document.createElement('div');
                div.classList.add('flex', 'items-center', 'gap-2');

                div.innerHTML = `
            <input type="text" name="options[]" class="mt-1 mb-2 block w-full border rounded px-3 py-2"
                   placeholder="گزینه جدید">
            <button type="button" onclick="this.parentElement.remove()"
                    class="text-red-600 hover:text-red-800 font-bold text-xl leading-none mt-1">×</button>
        `;

                wrapper.appendChild(div);
            }
            // تبدیل اعداد فارسی به انگلیسی
            function fixPersianDigits(str) {
                const persianNumbers = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
                const englishNumbers = ['0','1','2','3','4','5','6','7','8','9'];
                return str.replace(/[۰-۹]/g, function (w) {
                    return englishNumbers[persianNumbers.indexOf(w)];
                });
            }

            document.addEventListener('DOMContentLoaded', function () {
                $('#start_at_picker').persianDatepicker({
                    format: 'YYYY/MM/DD',
                    observer: true,
                    autoClose: true,
                    timePicker: {
                        enabled: true,
                        meridiem: { enabled: false }
                    },
                    onSelect: function (unix) {
                        const gDate = new persianDate(unix).toCalendar('gregorian').format("YYYY-MM-DD HH:mm:ss");
                        document.getElementById('start_at').value = fixPersianDigits(gDate);
                    }
                });

                $('#end_at_picker').persianDatepicker({
                    format: 'YYYY/MM/DD',
                    observer: true,
                    autoClose: true,
                    timePicker: {
                        enabled: true,
                        meridiem: { enabled: false }
                    },
                    onSelect: function (unix) {
                        const gDate = new persianDate(unix).toCalendar('gregorian').format("YYYY-MM-DD HH:mm:ss");
                        document.getElementById('end_at').value = fixPersianDigits(gDate);
                    }
                });
            });
        </script>
    @endpush

@endsection
