@extends('Layouts.app')
@section('title', 'رأی‌گیری')

@section('content')
    <div class="bg-white p-6 rounded shadow max-w-2xl mx-auto">
        <h2 class="text-xl font-bold mb-4">{{ $poll->title }}</h2>

        {{-- پیام موفقیت --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- پیام خطاها --}}
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

        {{-- فرم رأی‌گیری یا نتایج --}}
        @if( ! $hasVoted )
            <form id="vote-form" method="POST" action="{{ route('polls.vote', $poll) }}" class="space-y-4">
                @csrf
                @foreach ($poll->options as $option)
                    <div class="flex items-center">
                        <input type="radio" name="option_id" value="{{ $option->id }}" required>
                        <label class="ml-2">{{ $option->text }}</label>
                    </div>
                @endforeach

                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    ثبت رأی
                </button>
            </form>
        @endif

        {{-- نمایش نتایج --}}
        <div id="poll-results" class="space-y-2 {{ $hasVoted ? '' : 'hidden' }}">
            <h3 class="text-md font-semibold mb-2">نتایج:</h3>
            @foreach ($poll->options as $option)
                @php $percent = $results[$option->id] ?? 0; @endphp
                <div data-option-id="{{ $option->id }}">
                    <div class="flex justify-between text-sm">
                        <span>{{ $option->text }}</span>
                        <span class="percent">{{$percent}}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded h-2">
                        <div class="bg-indigo-600 h-2 rounded bar" style="width: {{$percent}}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const voteForm = document.getElementById('vote-form');
        const pollResults = document.getElementById('poll-results');
        voteForm?.addEventListener('submit', function (e) {
            e.preventDefault();
            const selected = voteForm.querySelector('input[name="option_id"]:checked');
            if (!selected) return alert('لطفاً یک گزینه انتخاب کنید');
            console.log(selected.value)
            fetch(voteForm.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ option_id: selected.value })
            })
                .then(res => {
                    console.log(res)
                    if (!res.ok) throw new Error('خطا در ثبت رأی');
                    return fetch(`{{ route('polls.show', $poll->id) }}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                })
                .then(res => res.json())
                .then(data => {
                    voteForm.remove();
                    pollResults.classList.remove('hidden');
                    console.log(data)
                    const results = data.results;
                    pollResults.querySelectorAll('[data-option-id]').forEach(el => {
                        const id = el.getAttribute('data-option-id');
                        const percent = results[id] ?? 0;
                        el.querySelector('.percent').textContent = `${percent}%`;
                        el.querySelector('.bar').style.width = `${percent}%`;
                    });
                })
                .catch(err => alert(err.message));
        });
    </script>
@endpush
