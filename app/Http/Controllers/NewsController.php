<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
class NewsController extends Controller
{
     public function index(Request $request)
    {   //News::all()はEloquentを使った、すべてのnewsテーブルを取得するというメソッド
        //sortByDesc()はカッコの中の値（キー）でソート並び替えするためのメソッド
        //つまり、News::all()->sortByDesc('updated_at')は、「投稿日時順に新しい方から並べる」という並べ換えをしていることを意味
        //$postsは代入された最新の記事以外の記事が格納されている
        $posts = News::all()->sortByDesc('updated_at');

        if (count($posts) > 0) {
            //shift()は配列の最初のデータを削除し、その値を返すメソッド
            //$headline = $posts->shift();では、最新の記事を変数$headlineに代入
            $headline = $posts->shift();
        } else {
            $headline = null;
        }
//dd($posts);
        // news/index.blade.php ファイルを渡している
        // また View テンプレートに headline、 posts、という変数を渡している
        return view('news.index', ['headline' => $headline, 'posts' => $posts]);
    }
}
