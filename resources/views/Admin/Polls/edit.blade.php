@extends('Layouts.app')
@section('title', 'ویرایش نظرسنجی')
@section('content')
    <div class="bg-white p-6 rounded shadow max-w-2xl mx-auto">
        <h2 class="text-xl font-bold mb-4">ویرایش نظرسنجی</h2>
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
        <form action="{{ route('admin.polls.update', $poll->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium">عنوان</label>
                <input type="text" name="title" value="{{ old('title', $poll->title) }}"
                       class="mt-1 block w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
                @error('title')
                <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            {{-- تاریخ‌ها --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">تاریخ شروع</label>
                    <input type="text" id="start_at_picker" class="mt-1 block w-full border rounded px-3 py-2" value="{{ $poll->start_at }}">
                    <input type="hidden" name="start_at" id="start_at" value="{{ $poll->start_at }}">
                    @error('start_at')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">تاریخ پایان</label>
                    <input type="text" id="end_at_picker" class="mt-1 block w-full border rounded px-3 py-2" value="{{ $poll->end_at }}">

                    <input type="hidden" name="end_at" id="end_at" value="{{ $poll->end_at }}">

                    @error('end_at')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- گزینه‌ها --}}
            <div>
                <label class="block text-sm font-medium mb-2">گزینه‌ها</label>
                <div id="options-wrapper" class="space-y-2 mt-2">
                    @foreach ($poll->options as $i => $option)
                        <div class="flex items-center gap-2 option-row">
                            <input type="hidden" name="options[{{ $i }}][id]" value="{{ $option->id }}">
                            <input type="text" name="options[{{ $i }}][text]"
                                   value="{{ old("options.$i.text", $option->text) }}"
                                   class="mt-1 mb-2 block w-full border rounded px-3 py-2 @error("options.$i") border-red-500 @enderror"
                                   placeholder="گزینه {{ $i + 1 }}">
                            <button type="button" onclick="this.parentElement.remove()"
                                    class="text-red-600 hover:text-red-800 font-bold text-xl leading-none mt-1">×</button>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <button type="button" onclick="addNewOption()"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        افزودن گزینه جدید
                    </button>
                </div>
            <div class="flex justify-end">
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    بروزرسانی
                </button>
            </div>
        </form>
    </div>
    @push('scripts')
        <script>
            function addNewOption() {
                const wrapper = document.getElementById('options-wrapper');
                const div = document.createElement('div');
                div.classList.add('flex', 'items-center', 'gap-2', 'option-row');

                div.innerHTML = `
            <input type="text" name="new_options[]" class="mt-1 mb-2 block w-full border rounded px-3 py-2"
                   placeholder="گزینه جدید">
            <button type="button" onclick="this.parentElement.remove()"
                    class="text-red-600 hover:text-red-800 font-bold text-xl leading-none mt-1">×</button>
        `;

                wrapper.appendChild(div);
            }
            function toGregorian(str) {
                const [date, time] = str.split(' ');
                const [y, m, d] = date.split('/').map(Number);
                const [h = 0, min = 0] = time ? time.split(':').map(Number) : [0, 0];
                return new persianDate({
                    year: y,
                    month: m,
                    day: d,
                    hour: h,
                    minute: min
                }).toCalendar('gregorian').format('YYYY-MM-DD HH:mm:ss');
            }

            document.addEventListener('DOMContentLoaded', function () {
                $('#start_at_picker, #end_at_picker').persianDatepicker({
                    format: 'YYYY/MM/DD HH:mm',
                    autoClose: true,
                    timePicker: { enabled: true },
                    onSelect: function (unix) {
                        const field = this.model.inputElement.attr('id');
                        const target = field === 'start_at_picker' ? '#start_at' : '#end_at';
                        const gDate = new persianDate(unix).toCalendar('gregorian').format("YYYY-MM-DD HH:mm:ss");
                        $(target).val(gDate);
                    }
                });

                document.getElementById('poll-form').addEventListener('submit', function (e) {
                    const startText = document.getElementById('start_at_picker').value;
                    const endText = document.getElementById('end_at_picker').value;

                    if (!document.getElementById('start_at').value && startText) {
                        document.getElementById('start_at').value = toGregorian(startText);
                    }
                    if (!document.getElementById('end_at').value && endText) {
                        document.getElementById('end_at').value = toGregorian(endText);
                    }
                });
            });
        </script>
    @endpush

@endsection
