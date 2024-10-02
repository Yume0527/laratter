<?php

namespace App\Http\Controllers;


use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetTestController extends Controller
{
    public function createTestTweet()
    {
        Tweet::create(['tweet' => 'これはテストツイートです。', 'user_id' => 11]);
        return 'Tweet created successfully!';
    }
}
