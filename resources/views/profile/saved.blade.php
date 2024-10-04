<div class="saved-tweets-section">
    <h3 class="text-xl font-bold mb-4">保存したツイート</h3>
    @forelse($savedTweets as $tweet)
        <div class="tweet-card mb-4">
            <div class="p-4">
                <div class="tweet-header mb-2">
                    <span class="font-bold text-lg">{{ $tweet->user->name }}</span>
                    <span class="text-gray-500 text-sm">{{ $tweet->created_at->format('Y-m-d H:i') }}</span>
                </div>
                <div class="tweet-content mb-2">
                    <p class="text-gray-800">{{ $tweet->tweet }}</p>
                </div>
                <div class="tweet-footer flex justify-between items-center">
                    <form action="{{ route('tweets.preserve.toggle', $tweet) }}" method="POST">
                        @csrf
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
            </div>
        </div>
    @empty
        <p>保存したツイートはまだありません。</p>
    @endforelse
</div>
