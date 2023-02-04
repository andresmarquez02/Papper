<?php

namespace App\Http\Controllers;

use App\Models\Denunciation;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Commentary;
use App\Models\Notification;
use App\Models\Post;
use App\Models\PostsDenunciation;
use App\Models\Reaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function posts(){
        return response()->json([ "posts" => $this->postsDB()], 200);
    }

    public function profileUser($username){

        $posts = $this->postsDB()->where("username", $username);
        $user = User::where("username",$username)->select("username","created_at")->firstOrFail();

        $user = collect([
            "username" => $user->username,
            "created_at" => Carbon::parse($user->created_at)->format("d/m/Y"),
        ]);

        return response()->json([ "posts" => $posts, "user" => $user, "countPosts" =>  $posts->count()], 200);
    }

    public function postsPopulars(){
        $posts = $this->postsDB()
        ->sortByDesc("reactions")
        ->sortByDesc('commentaries')
        ->values()
        ->all();

        return response()->json([ "posts" => $posts]);
    }

    public function postsRecommends(){
        $posts = $this->postsDB()
        ->whereIn('category', ["Lexachange", "Lexa","change"])
        ->sortByDesc('reactions')
        ->sortByDesc('commentaries')
        ->values()
        ->all();

        return response()->json([ "posts" => $posts]);
    }

    public function postsByCategory($category){
        $posts = $this->postsDB()
        ->where('category_id', $category);

        return response()->json([ "posts" => $posts]);
    }

    public function searchPosts($category,$query){
        $posts = $this->postsDB();

        if(!empty($category)){
            $posts = $posts->where('category_id',$category);
        }

        $posts = $posts->filter(function($post) use($query) {
            if(Str::contains($post->title, $query)){
                return $post;
            }
            else if(Str::contains($post->description, $query)){
                return $post;
            }
        });

        return response()->json([
            "category" => Category::where("id",$category)->value("category"),
            "posts" => $posts
        ],200);
    }

    public function postsDenuncied(){

        $posts = DB::table('posts_denunciations')
        ->join('posts','posts.id','=','posts_denunciations.post_id')
        ->join('users','users.id','=','posts.user_id')
        ->join('categories','categories.id','posts.category_id')
        ->orderByDesc("posts.created_at")
        ->select('username','categories.category','posts.*')
        ->distinct()
        ->get()
        ->each(function($post){
            $denunciations = DB::table('posts_denunciations')->where("post_id",$post->id)->count();
            $post->created_at = Carbon::parse($post->created_at)->diffForHumans();
            $post->denunciations = $denunciations;
        });

        return response()->json([ "posts" => $this->reacted($posts)]);
    }

    public function denunciationsPost($id){

        $denunciations = DB::table('posts_denunciations')
        ->join('denunciations','denunciations.id','=','posts_denunciations.denunciation_id')
        ->where("post_id",$id)
        ->select('denunciations.*','posts_denunciations.post_id')
        ->distinct()
        ->get();

        return response()->json([ "denunciations" => $denunciations]);
    }

    public function denunciations(){
        return response()->json(["denunciations" => Denunciation::whereStatus(1)->get()],200);
    }

    public function denunciedPost(Request $request, $id){

        $this->validate($request,[
            "denunciations" => "required|array",
            "denunciations.*" => "required|exists:denunciations,id"
        ]);

        $denuncied = PostsDenunciation::where("post_id",$id)->where("user_id",auth()->user()->id)->count();

        if($denuncied > 0){
            return response()->json([],425);
        }

        DB::transaction(function () use($request, $id) {
            foreach($request->denunciations as $denunciation){
                PostsDenunciation::create([
                    "denunciation_id" => $denunciation,
                    "post_id" => $id,
                    "user_id" => auth()->user()->id
                ]);
            }
        });

        return response()->json([],200);
    }

    public function closePost($id){
        Post::where("id",$id)->update(["status" => 0]);
        return response()->json([],200);
    }

    public function createPost(PostRequest $request){
        DB::transaction(function () use ($request){
            Post::create([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category,
                'user_id' => auth()->user()->id,
            ]);
        });
        return response()->json(["success" => "Publicacion creada con exito"], 200);
    }

    public function updatePost(PostRequest $request,$id){
        DB::beginTransaction();
        try {
            Post::where('id',$id)->where('user_id', auth()->user()->id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category,
            ]);
            DB::commit();
            return response()->json(["success" => "Publicacion editada con exito"], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
            DB::rollback();
            return response()->json(["error" => "Ha ocurrido un error inesperado"],500);
        }
    }

    public function deletePost($id){
        DB::beginTransaction();
        try {

            Post::where('id',$id)->where('user_id', auth()->user()->id)->delete();
            Notification::where("content_id",$id)->where("table","posts")->delete();

            Reaction::where("content_id",$id)->where("table","posts")->delete();
            Reaction::join("commentaries","commentaries.id","reactions.content_id")
            ->where("table","commentaries")
            ->where("post_id",$id)
            ->delete();

            Commentary::where("post_id",$id)->delete();

            DB::commit();
            return response()->json([], 200);;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([], 500);
        }
    }

    public function reactedPost($postId){
        DB::beginTransaction();
        try {
            $reactions = Reaction::where("user_id",auth()->user()->id)->where('content_id', $postId)
            ->where("table","posts")
            ->get();

            if($reactions->count() > 0){

                Reaction::where('content_id', $postId)->where('user_id', auth()->user()->id)->delete();
                Post::where('id', $postId)->decrement('reactions', 1);
                Notification::where('content_id',$postId)
                ->where('user_id',auth()->user()->id)
                ->where("table","posts")
                ->delete();

            } else {

                Post::where('id', $postId)->increment('reactions', 1);
                $post = Post::where('id', $postId)->first();

                Reaction::create([
                    "content_id" => $postId,
                    "user_id" => auth()->user()->id,
                    "table" => "posts",
                ]);
                Notification::where("content_id",$postId)->where('user_id',Auth::user()->id)->where('table','posts')->delete();

                if(Auth::user()->id != $post->user_id){
                    Notification::create([
                        'content_id' => $postId,
                        'user_id' => Auth::user()->id,
                        'description' => 'Le ha dado like a tu publicación',
                        'table' => 'posts',
                    ]);
                }
            }

            $reactions = Post::where('id',$postId)->value('reactions');

            DB::commit();
            return response()->json(["reactions" => $reactions], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["error" => "Error recargue el sitio", "errror2" => $th], 500);
        }

    }

    private function postsDB(){
        $posts = DB::table('posts')->join('users','users.id','=','posts.user_id')
        ->join('categories','categories.id','posts.category_id')
        ->select('posts.*','username','categories.category')
        ->orderByDesc("created_at")
        ->where("posts.status",1)
        ->get()
        ->each(function($post){
            $denunciations = DB::table('posts_denunciations')->where("post_id",$post->id)->count();
            $post->created_at = Carbon::parse($post->created_at)->diffForHumans();
            $post->denunciations = $denunciations;
        });

        return $this->reacted($posts);
    }

    public function reacted($posts){
        $reactionsPosts = Reaction::where("table","posts")->get();

        foreach ($posts as $key => $value) {
            foreach ($reactionsPosts as $valueReaction) {
                if(auth()->user()){
                    if($valueReaction->content_id == $value->id && $valueReaction->user_id  == auth()->user()->id){
                        $posts[$key]->my_like = 1;
                    }
                    else {
                        if(empty($posts[$key]->my_like))
                            $posts[$key]->my_like = 0;
                    }
                } else {
                    $posts[$key]->my_like = 0;
                }
            }
        }

        return $posts;
    }
}
