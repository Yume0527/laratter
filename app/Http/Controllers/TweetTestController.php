<?php

namespace App\Http\Controllers;


use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetTestController extends Controller
{
    public function index()
    {
        // テスト用の処理をここに記述
        return view('test.index');
    }
    public function createTestTweet()
    {
        Tweet::create(['tweet' => 'これはテストツイートです。', 'user_id' => 11]);
        return 'Tweet created successfully!';
    }
}
