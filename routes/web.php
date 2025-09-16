<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FavoriteListArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/', fn () => redirect()->route('articles.index'));

Route::get('/search', [SearchController::class, 'index'])->name('search.index');

// Route resource會註冊7個RestFul常見route
/*
HTTP method URI                         route name          Controller  功能
GET         /articles                   articles.index	    index()	    顯示所有文章列表
GET         /articles/create            articles.create	    create()	顯示建立新文章表單
POST	    /articles                   articles.store	    store()	    儲存新建立的文章
GET         /articles/{article}         articles.show	    show()	    顯示單一文章
GET         /articles/{article}/edit	articles.edit	    edit()	    顯示編輯文章表單
PUT/PATCH	/articles/{article}         articles.update	    update()	更新文章資料
DELETE	    /articles/{article}         articles.destroy	destroy()	刪除文章
*/
// Laravel 從上到下比對routes，如把 articles/{article} 放在上面，articles/create 就會被當作是 articles/{article}

//參數傳入user或者slug
Route::get('/users/{user:slug}', [UserController::class, 'show'])->name('users.show');

// auth:必須已登入，verified:email必須已驗證
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    Route::resource('articles', ArticleController::class)->except(['index', 'show']);
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('favoriteLists', FavoriteController::class)->except(['show']);
    Route::post('favoriteLists/{article}/sync', [FavoriteListArticleController::class, 'sync'])->name('favoriteLists.articles.sync');
});

// 驗證 email 的路由
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // 標記為已驗證
    return redirect('/home'); // 驗證完成後導向
})->middleware(['auth', 'signed'])->name('verification.verify');

// 重新寄送驗證信
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::resource('articles', ArticleController::class)->only(['index', 'show']);
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
//Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/categories/{category}', [ArticleController::class, 'byCategory'])->name('articles.byCategory');

Route::get('/tags/{tag}', [ArticleController::class, 'byTag'])->name('articles.byTag');
//Route::get('/tags/{tag}', [CategoryController::class, 'show'])->name('tags.show');

//Route::get('/search', [SearchController::class, 'index'])->name('search');