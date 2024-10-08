<?php

namespace App\Http\Controllers;


use App\Models\Preserve;
use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
  
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // 一覧画面を表示する処理→ツイートを全部取得する→取得したデータをビューのファイルに渡す
 $tweets = Tweet::with(['user', 'liked'])->latest()->paginate(10);
    // dd($tweets);
    return view('tweets.index', compact('tweets'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //作成画面を表示する処理→作成画面のビューファイルを返す
        return view('tweets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        //データを保存する処理
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
        //dd($tweet);
        //詳細画面を表示する処理
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {return view('tweets.edit', compact('tweet'));
        //dd($tweet);
        //編集画面を表示する処理
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tweet $tweet)
    {
        $request->validate([
      'tweet' => 'required|max:255',
    ]);

    $tweet->update($request->only('tweet'));

    return redirect()->route('tweets.show', $tweet);

        //dd($request^>all(), $tweet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        
    $tweet->delete();

    return redirect()->route('tweets.index');
        //
    }
    /**
 * Search for tweets containing the keyword.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\View\View
 */
public function search(Request $request)
{

  $query = Tweet::query();

  // キーワードが指定されている場合のみ検索を実行
  if ($request->filled('keyword')) {
    $keyword = $request->keyword;
    $query->where('tweet', 'like', '%' . $keyword . '%');
  }

  // ページネーションを追加（1ページに10件表示）
  $tweets = $query
    ->latest()
    ->paginate(10);

  return view('tweets.search', compact('tweets'));
}


}
