<?php
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\TweetLikeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PreserveController;
use App\Http\Controllers\TweetTestController; 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/test-tweet', [TweetTestController::class, 'createTestTweet']);
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/saved', [PreserveController::class, 'savedTweets'])->name('profile.saved');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/tweets/search', [TweetController::class, 'search'])->name('tweets.search');
    Route::resource('tweets', TweetController::class);
    Route::get('/preserves', [PreserveController::class, 'index'])->name('preserves.index');
    Route::post('/tweets/preserve', [PreserveController::class, 'preserveTweet'])->name('tweets.preserve');
    Route::post('/tweets/{tweet}/preserve-toggle', [PreserveController::class, 'togglePreserve'])->name('tweets.preserve.toggle');
    Route::post('/tweets/{tweet}/like', [TweetLikeController::class, 'store'])->name('tweets.like');
    Route::delete('/tweets/{tweet}/like', [TweetLikeController::class, 'destroy'])->name('tweets.dislike');
    Route::resource('tweets.comments', CommentController::class);   
    
    Route::post('/follow/{user}', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{user}', [FollowController::class, 'destroy'])->name('follow.destroy');
    Route::get('/test', [TweetTestController::class, 'index']); 
});

require __DIR__.'/auth.php';
