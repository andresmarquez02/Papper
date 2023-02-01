<?php

namespace App\Http\Controllers;

use App\Commentary;
use App\Notification;
use App\Post;
use App\Reaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentaryController extends Controller
{
    public function commentaries($id){
        $commentaries = DB::Table('commentaries')->where('commentaries.post_id',$id)
        ->leftjoin('users','users.id','=','commentaries.user_id')
        ->select('commentaries.*','username')
        ->get();

        $post = DB::table('posts')->leftjoin('users','users.id','=','posts.user_id')
        ->leftjoin('categories','categories.id','posts.category_id')
        ->select('posts.*','username','categories.category')
        ->where("posts.id",$id)
        ->first();

        $post->created_at = Carbon::parse($post->created_at)->diffForHumans();
        $denunciations = DB::table('posts_denunciations')->where("post_id",$post->id)->count();
        $post->denunciations = $denunciations;

        $reacted = 0;

        if(auth()->user()){
            $reacted = Reaction::where("content_id",$id)->where("user_id",auth()->user()->id)->where("table","posts")->count();
            $reactionCommetaries = Reaction::where('reactions.user_id',Auth::user()->id)->where("table","commentaries")
            ->join("commentaries","commentaries.id","reactions.content_id")
            ->where("commentaries.post_id",$id)
            ->select("commentaries.id","commentaries.post_id","reactions.user_id")
            ->get();

            if($reacted > 0){
                $post->my_like = 1;
            } else {
                $post->my_like = 0;
            }

        } else {
            $post->my_like = 0;
            $reactionCommetaries = Reaction::where("table","commentaries")
            ->join("commentaries","commentaries.id","reactions.content_id")
            ->where("commentaries.post_id",$id)
            ->select("commentaries.id","commentaries.post_id","reactions.user_id")
            ->get();
        }

        foreach ($commentaries as $key => $value) {
            foreach ($reactionCommetaries as $valueReaction) {
                if(auth()->user()){
                    if($valueReaction->id == $value->id && $valueReaction->user_id  == auth()->user()->id){
                        $commentaries[$key]->my_like = 1;
                    } else {
                        $commentaries[$key]->my_like = 0;
                    }
                } else {
                    $commentaries[$key]->my_like = 0;
                }
            }
            $commentaries[$key]->created_at = Carbon::parse($commentaries[$key]->created_at)->diffForHumans();
        }

        return response()->json([
            "post"=> $post,
            "commentaries" => $commentaries,
        ],200);
    }

    public function reactionCommentaries($commentaryId){
        $reactionCommentary = Reaction::where('content_id',$commentaryId)->where('user_id',Auth::user()->id)
        ->where("table","commentaries")
        ->first();

        DB::beginTransaction();
        try {
            if(!empty($reactionCommentary)) {

                Reaction::whereId($reactionCommentary->id)->delete();
                Commentary::where('id',$commentaryId)->decrement('reactions', 1);

            } else {

                $commentary = Commentary::where('id',$commentaryId)->first();
                Commentary::where('id',$commentaryId)->increment('reactions', 1);
                Reaction::create([
                    "content_id" => $commentaryId,
                    'user_id' => Auth::user()->id,
                    "table" => "commentaries",
                ]);

                if($commentary->user_id != Auth::user()->id){
                    Notification::create(
                        [
                            'content_id' => $commentary->id,
                            'user_id' => Auth::user()->id,
                            'description' => 'Le ha dado like a tu comentario en una publicación',
                            "table" => "commentaries"
                        ],
                        [
                            'content_id' => $commentary->post_id,
                            'user_id' => Auth::user()->id,
                            'description' => 'Le ha dado like a un comentario en tu publicación',
                            "table" => "posts"
                        ]
                    );
                }

            }
            DB::commit();
            return response()->json([],200);

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([$th],500);

        }
    }

    public function saveCommentary(Request $request,$id){

        $this->validate($request,[
            "commentary" => "required|string|min:2"
        ]);

        DB::beginTransaction();
        try {

            Post::find($id)->increment('commentaries',1);
            $post = Post::find($id);

            Commentary::create([
                'commentary' => $request->commentary,
                'user_id' => Auth::user()->id,
                'post_id' => $id,
            ]);

            $notification = Notification::where("content_id",$id)->where("user_id", auth()->user()->id)->where("description","like", Auth::user()->username." Ha agregado un comentario en tu publicación")->count();

            if($notification == 0 && $post->user_id != Auth::user()->id){
                Notification::create([
                    'content_id' => $id,
                    'user_id' => Auth::user()->id,
                    'description' => 'Ha agregado un comentario en tu publicación',
                    "table" => "posts"
                ]);
            }

            DB::commit();
            return response()->json([],200);

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([],500);
        }
    }

    public function updateCommentary(Request $request,$id){
        $this->validate($request,[
            "commentary" => "required|string|min:2"
        ]);

        DB::beginTransaction();
        try {
            Commentary::where('id',$id)->where('user_id',Auth::user()->id)->update([
                'commentary'=> $request->commentary,
            ]);

            DB::commit();
            return response()->json(["exito" => "Publicacion editada con exito"], 200);

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["error" => "Error inesperado, intenta más tarde."], 500);
        }

    }

    public function deleteCommentary($id){
        DB::beginTransaction();
        try {

            $postId = Commentary::where('id',$id)->value('post_id');
            Post::where('id',$postId)->decrement("commentaries",1);

            Commentary::where('id',$id)->where('id_usuario',Auth::user()->id)->delete();

            Notification::where("content_id",$postId)->where("user_id")->where("description","like", Auth::user()->username." Ha agregado un comentario en tu publicación")->delete();

            DB::commit();
            return response()->json(["exito" => "Comentario eliminado con exito."], 200);

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["errors" => ["err" => ["Error inesperado, intenta mas tarde"]]], 500);
        }
    }
}
