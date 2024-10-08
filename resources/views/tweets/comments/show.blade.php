<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('コメント詳細') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          
          {{-- ツイートに戻るリンク --}}
          <a href="{{ route('tweets.show', $tweet) }}" class="text-blue-500 hover:text-blue-700 mr-2">Tweetに戻る</a>

          {{-- ツイート情報 --}}
          <p class="text-gray-600 dark:text-gray-400 text-sm mt-4">{{ $tweet->user->name }}: {{ $tweet->tweet }}</p>

          {{-- コメント内容 --}}
          <div class="mt-4 bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
            <p class="text-gray-800 dark:text-gray-300 text-lg">{{ $comment->comment }}</p>
            <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $comment->user->name }}</p>
            <div class="text-gray-600 dark:text-gray-400 text-sm mt-2">
              <p>コメント作成日時: {{ $comment->created_at->format('Y-m-d H:i') }}</p>
              <p>コメント更新日時: {{ $comment->updated_at->format('Y-m-d H:i') }}</p>
            </div>
          </div>

          {{-- 編集/削除リンク (ログインユーザーが投稿者の場合のみ表示) --}}
          @if (auth()->id() === $comment->user_id)
          <div class="flex mt-4 space-x-4">
            <a href="{{ route('tweets.comments.edit', [$tweet, $comment]) }}" class="text-blue-500 hover:text-blue-700">編集</a>
            <form action="{{ route('tweets.comments.destroy', [$tweet, $comment]) }}" method="POST" onsubmit="return confirm('このコメントを本当に削除しますか？ この操作は取り消せません。');">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 hover:text-red-700">削除</button>
            </form>
          </div>
          @endif
          
          <div class="mt-4">
                        @if (auth()->user()->preserves->contains($tweet->id))
                            {{-- 既に保存されている場合 --}}
                            <form action="{{ route('preserve.toggle', ['tweet' => $tweet->id]) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    保存解除
                                </button>
                            </form>
                        @else
                            {{-- まだ保存されていない場合 --}}
                            <form action="{{ route('preserve.toggle', ['tweet' => $tweet->id]) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="text-blue-500 hover:text-blue-700">
                                    保存
                                </button>
                            </form>
                        @endif
                    </div>
                    
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
