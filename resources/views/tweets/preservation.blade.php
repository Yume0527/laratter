<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Tweet保存') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          @if($tweets->isEmpty()) 
            <p>保存されたツイートはありません。</p>
          @else
            @foreach ($tweets as $tweet)
              <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                <p class="text-gray-800 dark:text-gray-300">{{ $tweet->tweet }}</p>
                <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $tweet->user->name }}</p>
                <a href="{{ route('tweets.show', $tweet) }}" class="text-blue-500 hover:text-blue-700">詳細を見る</a>
              @csrf
                <form action="/tweets/preserve" method="POST">
  
                  <input type="hidden" name="tweet_id" value="{{ $tweetid }}">
                  @if ($tweet->isPreservedBy(auth()->user()))
                    <button type="submit" class="text-red-500 hover:text-red-700">
                      保存解除
                    </button>
                  @else
                    <button type="submit" class="text-blue-500 hover:text-blue-700">
                      保存
                    </button>
                  @endif
                </form>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const forms = document.querySelectorAll('.save-tweet-form');
      forms.forEach(form => {
        form.addEventListener('submit', (e) => {
          e.preventDefault(); // フォームのデフォルト送信を防止
          const tweetId = form.querySelector('input[name="tweet_id"]').value;
          const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
          fetch(`/tweets/preserve`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-Token': csrfToken,
            },
            body: JSON.stringify({ tweet_id: tweetId })
          })
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then(data => {
            console.log(data);
          })
          .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
          });
        });
      });
    });
  </script>
</x-app-layout>
