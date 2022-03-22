<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function add()
    {
        return view('admin.profile.create');
    }

    public function create()
    {
        // 以下を追記
      // Varidationを行う
      $this->validate($request, News::$rules);

      $news = new News;
      $form = $request->all();


      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
     
      // データベースに保存する
      $news->fill($form);
      $news->save();

        return redirect('admin/profile/create');
    }

    public function edit()
    {//課題３
        return view('admin.profile.edit');
    }

    public function update()
    {
        return redirect('admin/profile/edit');
    }
}