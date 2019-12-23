<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Post;
use App\Tag;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('VerifyCategoriesCount')->only(['create','store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')
        ->with('categories', Category::all())
        ->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {

        // Upload the image
        $image =$request->image->store('posts');
        //create the post
        $post = Post::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'content'=>$request->content,
            'image'=>$image,
            'published_at'=>$request->published_at,
            'category_id'=>$request->category,
            'user_id' =>auth()->user()->id, 
        ]);
        // for many to many relationships
        if($request->tags){
            $post->tags()->attach($request->tags);
        }
     
        
        //flash a msg
        session()->flash('success', 'Post has been successfully created');
        //redirect the user
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')
        ->with('post', $post)
        ->with('categories', Category::all())
        ->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data=$request->only(['title', 'description', 'published_at','content']);
        //check if new image
        if($request->hasFile('image')){
            //upload it
         $image =  $request->image->store('posts');
            //delete old one
       $post->deleteImage();
        $data['image']=$image;
        }

        if($request->tags){
            $post->tags()->sync($request->tags);
        }

        //update attributes
       
        $post->update($data);

        //flash message
        session()->flash('success', 'The Post is updated successfully');
        //redirect user
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post= Post::withTrashed()->where('id', $id)->firstOrFail();
         if($post->trashed()){
            $post->deleteImage();
            $post->forceDelete();
        }else{
            $post->delete();    
        }
        session()->flash('success', 'The post is deleted successfully');    
        return redirect(route('posts.index'));
    }

    // Display all trashed posts
    public function trashed(){
        // $trashed= Post::withTrashed()->get();
        $trashed= Post::onlyTrashed()->get();
        return view('posts.index')->with('posts', $trashed);
    }

    public function restore($id){
        $post= Post::withTrashed()->where('id', $id)->firstOrFail();
        $post->restore();
        session()->flash('success', 'Post restored successfully');
        return redirect()->back();
    }
}
