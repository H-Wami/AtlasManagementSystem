<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Auth;

class PostsController extends Controller
{
    // 投稿一覧画面表示
    public function show(Request $request){
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::get();
        $like = new Like;
        $post_comment = new Post;
        if(!empty($request->keyword)){
            $posts = Post::with('user', 'postComments')
            ->where('post_title', 'like', '%'.$request->keyword.'%')
            ->orWhere('post', 'like', '%'.$request->keyword.'%')->get();
        }else if($request->category_word){
            $sub_category = $request->category_word;
            $posts = Post::with('user', 'postComments')->get();
        }else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
            ->whereIn('id', $likes)->get();
        }else if($request->my_posts){
            $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }
    // 投稿詳細画面表示
    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    // 投稿画面表示
    public function postInput(){
        $main_categories = MainCategory::get();
        $sub_categories = SubCategory::get(); //追加
        return view('authenticated.bulletinboard.post_create', compact('main_categories','sub_categories'));
    }

    // 新規投稿作成機能
    public function postCreate(PostFormRequest $request){
        $post = Post::create([ // postsテーブルに入力された値を保存する
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);

        $sub_categories = $request->post_category_id; // 入力されたname属性(post_category_id)を取得
        $sub_category = Post::findOrFail($post->id); // 新規投稿のIDを探して見つからなかったらエラー文を出す
        $sub_category->subCategories()->attach($sub_categories); // 保存された$postからリレーションした中間テーブルに$sub_categoriesを保存する
        return redirect()->route('post.show',compact('post')); // compact('post')追加
    }

    // 投稿編集機能
    public function postEdit(Request $request){

        // バリデーション定義・メッセージ
        $request->validate(
            [
                'post_title' => 'required|string|max:100',
                'post_body' => 'required|string|max:5000'
            ],
            [
                'post_title.required' => 'タイトルは入力必須です。',
                'post_title.max' => 'タイトルは100文字以下で入力して下さい。',

                'post_body.required' => '内容は入力必須です。',
                'post_body.max' => '内容は5000文字以下で入力して下さい。',
            ]
        );

        Post::where('id', $request->post_id)->update([ //(カラム名,$requestのpost_id)と一致している投稿を探す
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]); // 入力された値に編集して保存する。
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    // 投稿削除機能
    public function postDelete($id){ //$id=投稿IDのみ取得。
        $post = Post::findOrFail($id); //削除したい投稿(postsテーブル)を取得する。なければエラー文を出す。
        $post->subCategories()->detach(); // 削除したい投稿の中間テーブルの値を削除する。
        $post->delete(); // 投稿削除する。
        return redirect()->route('post.show');
    }

    // メインカテゴリー作成機能
    public function mainCategoryCreate(Request $request){
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    public function commentCreate(Request $request){
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }
}
