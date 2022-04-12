@extends('layouts.front')

@section('content')
    <div class="container">
         <p>
    <h1>ニュース一覧</h1>
    <p/>
    <br>
        <hr color="#c0c0c0">
        {{-- @if !is_null($headline)は、$headlineが空なら飛ばして（実行しない）、データがあれば実行するという意味 --}}
        @if (!is_null($headline))
            <div class="row">
                <div class="headline col-md-10 mx-auto">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="caption mx-auto">
                                <div class="image">
                                    @if ($headline->image_path)
                                         {{--assetは、「publicディレクトリ」のパスを返すヘルパとなっています。ヘルパとはviewファイルで使えるメソッドのこと
                                         現在のURLのスキーマ（httpかhttps）を使い、アセットへのURLを生成するメソッド
                                        $headline->image_pathは、保存した画像のファイル名が入ってる。--}}
                                        <img src="{{ asset('storage/image/' . $headline->image_path) }}">
                                    @endif
                                </div>
                                <div class="title p-2">
                                    <h1>{{ \Str::limit($headline->title, 70) }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="body mx-auto">{{ \Str::limit($headline->body, 650) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <hr color="#c0c0c0">
        <div class="row">
            <div class="posts col-md-8 mx-auto mt-3">
                @foreach($posts as $post)
                    <div class="post">
                        <div class="row">
                            <div class="text col-md-6">
                                <div class="date">
                                    {{--formatメソッドを使えば、簡単に日付のフォーマットを変更することができる--}}
                                    {{ $post->updated_at->format('Y年m月d日') }}
                                </div>
                                <div class="title">
                                    {{ \Str::limit($post->title, 150) }}
                                </div>
                                <div class="body mt-3">
                                    {{ \Str::limit($post->body, 1500) }}
                                </div>
                            </div>
                            <div class="image col-md-6 text-right mt-4">
                                @if ($post->image_path)
                                    <img src="{{ asset('storage/image/' . $post->image_path) }}">
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr color="#c0c0c0">
                @endforeach
            </div>
        </div>
    </div>
    </div>
@endsection