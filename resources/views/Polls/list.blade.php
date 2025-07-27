@extends('Layouts.app')
@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 mt-4 rounded shadow space-y-6">
        <h1 class="text-xl font-bold mb-4">نظرسنجی‌ها</h1>
        @forelse ($polls as $poll)
            @php
                $userVoted = $poll->votes->where('user_id', auth()->id())->first();
                $isActive = now()->between($poll->start_at, $poll->end_at);
            @endphp

            <div class="border p-4 rounded space-y-2">
                <h2 class="text-lg font-semibold">{{ $poll->title }}</h2>
                <p class="text-sm text-gray-600">
                    مهلت: {{ convertLatinDateToPersian($poll->end_at) }}
                </p>

                @if ($userVoted)
                    <p class="text-green-600 text-sm">شما رأی داده‌اید.</p>
                    <a href="{{ route('polls.show', $poll) }}"
                       class="text-indigo-600 text-sm hover:underline">مشاهده نتیجه</a>
                @elseif (! $isActive)
                    <p class="text-red-600 text-sm">مهلت رأی‌گیری تمام شده.</p>
                @else
                    <a href="{{ route('polls.show', $poll) }}"
                       class="text-indigo-600 text-sm hover:underline">شرکت در نظرسنجی</a>
                @endif
            </div>
        @empty
            <p class="text-gray-500 text-sm">هیچ نظرسنجی‌ای وجود ندارد.</p>
        @endforelse
    </div>
@endsection
