<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Profile;
use App\ProfileHistory;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function add()
    {
        return view('admin.profile.create');
    }

    public function create(Request $request)
    {
        // 以下を追記
      // Varidationを行う
      $this->validate($request, Profile::$rules);

      $profile = new Profile;
      $form = $request->all();


      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
     
      // データベースに保存する
      $profile->fill($form);
      $profile->save();

        return redirect('admin/profile/create');
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
        $posts = Profile::where('name', $cond_title)->get();
          
          //それ以外はすべてのニュースを取得する
        } else {
            //News Modelを使って、データベースに保存されている、newsテーブルのレコードをすべて取得し、変数$postsに代入しているという意味
            $posts = Profile::all();
        }
        //Requestにcond_titleを送っている
        //index.blade.phpのファイルに取得したレコード（$posts）とユーザーが入力した文字列（$cond_title）を渡し、ページを開く。
        return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
      }

    public function edit(Request $request)
  {
      // News Modelからデータを取得する
      $profile = Profile::find($request->id);
      if (empty($profile)) {
        abort(404);    
      }
      return view('admin.profile.edit', ['profile_form' => $profile]);
  }

    public function update(Request $request)
    {
        // Validationをかける
      $this->validate($request, Profile::$rules);
      // Profile Modelからデータを取得する
      $profile = Profile::find($request->id);
      // 送信されてきたフォームデータを格納する
      $profile_form = $request->all();
      if ($request->remove == 'true') {
          $profile_form['image_path'] = null;
      } elseif ($request->file('image')) {
          $path = $request->file('image')->store('public/image');
          $profile_form['image_path'] = basename($path);
      } else {
          $profile_form['image_path'] = $profile->image_path;
      }
      
      
      unset($profile_form['image']);
      unset($profile_form['remove']);
      unset($profile_form['_token']);

      // 該当するデータを上書きして保存する
      $profile->fill($profile_form)->save();
      
      // 以下を追記
        $history = new ProfileHistory();
        $history->profile_id = $profile->id;
        //時刻を扱うための日付操作ライブラリ
        //Carbonを使って取得した現在時刻を、History Modelの edited_at として記録
        $history->edited_at = Carbon::now();
        $history->save();
        return redirect('admin/profile/');
    }
    public function delete(Request $request)
    {
      //該当するProfile Modelを取得
      $profile = Profile::find($request->id);
      //削除する
      $profile->delete();
      return redirect('admin/profile/');
  }  
}