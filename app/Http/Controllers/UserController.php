<?php

namespace App\Http\Controllers;

use App\Category;
use App\Notification;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user(){
        return response()->json(["user" => auth()->user()], 200);
    }

    public function notifications(){

        $notificationsPosts = Notification::join("posts","posts.id","notifications.content_id")
        ->where('posts.user_id', auth()->user()->id)
        ->join("users","users.id","notifications.user_id")
        ->where("table","posts")
        ->select("notifications.*","posts.id as post_id","users.username")
        ->orderBy('id','desc')
        ->get();

        $notificationsCommentaries = Notification::join("commentaries","commentaries.id","notifications.content_id")
        ->join("users","users.id","notifications.user_id")
        ->where('commentaries.user_id', auth()->user()->id)
        ->where("table","commentaries")
        ->select("notifications.*","commentaries.post_id","users.username")
        ->orderBy('id','desc')
        ->get();

        $notifications = $notificationsCommentaries->concat($notificationsPosts);

        return response()->json(["notifications" => $notifications], 200);
    }

    public function users(){
        return response()->json(["users" => User::all()],200);
    }

    public function changeStatusAccount($id){
        $user = User::find($id);
        $user->status = !$user->status;
        $user->save();
        return response()->json([],200);
    }
}
