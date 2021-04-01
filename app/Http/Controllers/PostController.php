<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    //

    public function show($id) {
        $post = Post::find($id);
        $user = Post::find($id)->user->name;
        return view('blog-post',['post'=>$post, 'user'=>$user]);
    }

    public function showUserPosts(User $user) {
        $posts = Post::where('user_id',$user->id)->paginate(5);
        return view('user-posts',['posts'=>$posts, 'user'=>$user]);
    }

    public function create() {
        return view('admin.posts.create');
    }

    public function store(){
        $inputs = request()->validate([
            'title'=>'required|min:6|max:200',
            'body'=>'required|min:20',
            'post_image'=>'file'
            ]);

        if($file = request('post_image')){
            $inputs['post_image'] = $file->storeAs('images', $file->getClientOriginalName());
        } else $inputs['post_image'] = "images/noimage.jpg";

        auth()->user()->posts()->create($inputs);
        Session::flash('createmessage','Post was sucessfully created!');
        return redirect()->route('posts.index');
    }

    public function index(){
        $posts = Post::all();
        return view('admin.posts.index',['posts'=>$posts]);
    }

    public function destroy(Post $post) {
        $this->authorize('delete',$post);
        $post->delete();
        Session::flash('deletemessage','Post was sucessfully deleted!');
        return back();
    }

    public function edit(Post $post) {
        $this->authorize('view', $post);
        return view('admin.posts.edit',['post'=>$post]);
    }

    public function update(Post $post){
        $inputs = request()->validate([
            'title'=>'required|min:6|max:200',
            'body'=>'required|min:20',
            'post_image'=>'file'
            ]);
        
            $this->authorize('update',$post);

        //Post image Check and Set
        //Checking to see if the current image file is in use by other Posts
        $allposts = Post::all();
        $fileusers = 0;
        foreach($allposts as $apost){
            if($apost->post_image == $post->post_image) $fileusers++ ;
        }
        ($fileusers < 2) ? $fileinuse = false : $fileinuse = true;

        //checking to see if there is a file in the post update request 
        //then set the new file and delete the old one if its not in use
        if($file = request('post_image')){
            $newfile = 'storage/images/' . $file->getClientOriginalName();
            if(!file_exists('$newfile')){
                $inputs['post_image'] = $file->storeAs('images',$file->getClientOriginalName());
                if(!$fileinuse) Storage::delete($post->getAttributes()['post_image']);
            }
            $inputs['post_image'] = 'images/' . $file->getClientOriginalName();
        } else {
            $inputs['post_image'] = 'images/noimage.jpg';
            if(!$fileinuse) Storage::delete($post->getAttributes()['post_image']);       
        }
        
        // $post->title = $inputs['title'];
        // $post->body = $inputs['body'];

        $post->update($inputs);
        session()->flash('updatemessage','Post was successfully updated!');
        return redirect()->route('posts.index');
    }
    
    public function deleteviews(Post $post) {
        $this->authorize('view', $post);
        $post->views = 0;
        $post->save();
        return redirect()->route('posts.index');
    }

}
