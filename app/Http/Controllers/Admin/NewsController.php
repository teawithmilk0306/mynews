<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//以下を追記することでNews Modelが扱えるようになる
use App\News;
//History Modelの使用を宣言
use App\History;
use Carbon\Carbon;
class NewsController extends Controller
{
    //以下を追記
    public function add()
    {
        return view('admin.news.create');
    }
    
    // 以下を追記
    public function create(Request $request)
     //Requestクラスは、ブラウザを通してユーザーから送られる情報をすべて含んでいるオブジェクトを取得することができる
     //これらの情報を$requestに代入して使用
    {
        
      //Varidationを行う
      $this->validate($request, News::$rules);
        //validate()の第一引数にリクエストのオブジェクトを渡し、$request->all()を判定して、問題があるなら、エラーメッセージと入力値とともに直前のページに戻る
      $news = new News;
      $form = $request->all();
      //ユーザーが入力したデータを取得できる
      
      //フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
        //isset引数の中にデータがあるかないかを判断するメソッド      
        if (isset($form['image'])) {
            //file('image')画像をアップロードするメソッド  
            $path = $request->file('image')->store('public/image');
            //$pathの中は「public/image/ハッシュ化されたファイル名」が入っている。
            //basenameパスではなくファイル名だけ取得するメソッド
            $news->image_path = basename($path);
        
        } else {
            //Newsテーブルのimage_pathカラムにnullを代入するという意味
            $news->image_path = null;
          
        }

        //フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        //フォームから送信されてきたimageを削除する
        unset($form['image']);
      
        //フォームから送信されてきたデータを$newsに代入する
        $news->fill($form);
        //データベースに保存する
        $news->save();
        //admin/news/createにリダイレクトする
        return redirect('admin/news/create');
    }

  //投稿したニュースの一覧を表示するためにindex Actionを追加
    public function index(Request $request)
    {
         //$requestの中のcond_titleの値を$cond_titleに代入
        $cond_title = $request->cond_title;
        //検索されたら検索結果を取得する
        if ($cond_title != '') {
        
        //whereメソッドを使うとnewsテーブルの中のtitleカラムで$cond_title（ユーザーが入力した文字）に一致するレコードをすべて取得することができる
        //取得したテーブルを$posts変数に代入 
        $posts = News::where('title', $cond_title)->get();
          
          //それ以外はすべてのニュースを取得する
        } else {
            //News Modelを使って、データベースに保存されている、newsテーブルのレコードをすべて取得し、変数$postsに代入しているという意味
            $posts = News::all();
        }
        //Requestにcond_titleを送っている
        //index.blade.phpのファイルに取得したレコード（$posts）とユーザーが入力した文字列（$cond_title）を渡し、ページを開く。
        return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }
    //edit Actionは編集画面を処理する部分
    public function edit(Request $request)
  {
      // News Modelからデータを取得する
      $news = News::find($request->id);
      if (empty($news)) {
        abort(404);    
      }
      return view('admin.news.edit', ['news_form' => $news]);
  }
  //update Actionは編集画面から送信されたフォームデータを処理する部分
  public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, News::$rules);
      // News Modelからデータを取得する
      $news = News::find($request->id);
      // 送信されてきたフォームデータを格納する
      $news_form = $request->all();
      //エラーにならずに画像を変更する
      if ($request->remove == 'true') {
          $news_form['image_path'] = null;
      } elseif ($request->file('image')) {
          $path = $request->file('image')->store('public/image');
          $news_form['image_path'] = basename($path);
      } else {
          $news_form['image_path'] = $news->image_path;
      }
          
      unset($news_form['image']);
      unset($news_form['remove']);
      unset($news_form['_token']);

      // 該当するデータを上書きして保存する
      $news->fill($news_form)->save();
      
      // 以下を追記
        $history = new History();
        $history->news_id = $news->id;
        //時刻を扱うための日付操作ライブラリ
        //Carbonを使って取得した現在時刻を、History Modelの edited_at として記録
        $history->edited_at = Carbon::now();
        $history->save();
      
      return redirect('admin/news');
  }
}
