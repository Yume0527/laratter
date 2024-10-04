<?php

namespace App\Http\Controllers;

use App\Models\Tweet; 
use App\Models\Preserve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PreserveController extends Controller
{

    public function togglePreserve(Request $request, Tweet $tweet)
    {
        Log::info('Toggle Preserve method called for Tweet ID: ' . $tweet->id);

        $preserve = Preserve::where('user_id', auth()->id())
            ->where('tweet_id', $tweet->id)
            ->first();

        if ($preserve) {
            // 既に保存されている場合は、削除する処理
            $preserve->delete();
            return back()->with('success', 'Tweetが削除されました。');
        } else {
            // 新しく保存する処理
            Preserve::create([
                'user_id' => auth()->id(),
                'tweet_id' => $tweet->id,
            ]);
            return back()->with('success', 'Tweetが保存されました。');
        }
    }

    public function savedTweets()
{
    $user = auth()->user();
    $savedTweets = $user->preservedTweets()->with('user')->get();
    //dd($savedTweets); 
    return view('profile.saved', compact('savedTweets'));
}

    public function preserveTweet(Request $request)
    {
        $request->validate([
            'tweet_id' => 'required|integer|exists:tweets,id', // tweet_idが必須で、tweetsテーブルに存在することを確認
        ]);

        $user_id = auth()->id();
        $tweet_id = $request->input('tweet_id');

        Log::info('PreserveTweet called with tweet_id: ' . $tweet_id);

        Preserve::create([
            'user_id' => $user_id,
            'tweet_id' => $tweet_id,
        ]);

        return redirect()->route('preserves.index')->with('success', 'ツイートを保存しました');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 一覧画面を表示する処理→ツイートを全部取得する→取得したデータをビューのファイルに渡す
        $tweets = Tweet::with(['user', 'liked'])->latest()->paginate(10);
        return view('tweets.index', compact('tweets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tweets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tweet' => 'required|max:255',
        ]);
        $request->user()->tweets()->create($request->only('tweet'));

        return redirect()->route('tweets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {

        $tweet->load('comments');
        return view('tweets.show', compact('tweet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
        return view('tweets.edit', compact('tweet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tweet' => 'required|max:255',
        ]);

        $tweet = Tweet::findOrFail($id);
        $tweet->update($request->only('tweet'));

        return redirect()->route('tweets.show', $tweet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        $tweet = Tweet::findOrFail($id);
        $tweet->delete();

        return redirect()->route('tweets.index');
    }
}
