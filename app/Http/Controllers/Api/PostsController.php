<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use Response;
use App\Models\Posts;
use App\Models\DeviceSession;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()  
    {
         $posts = Posts::where('user_id', DeviceSession::get()->user->id)->get();
		 return  Response::json($posts, 200);
		 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $result = Posts::create([
        'user_id' => DeviceSession::get()->user->id,
         'media1_url' => $request->input('media1_url'),
		 'media2_url' => $request->input('media2_url'),
		 'media3_url' => $request->input('media3_url'),
		 'media4_url' => $request->input('media4_url')
		 ]);
        return Response::json($result, 200);
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
		$post = Posts::find($id);
		return $post->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
		$post = Posts::find($id);
    	$post->media1_url = $request->input('media1_url');
		$post->media2_url = $request->input('media2_url');
		$post->media3_url = $request->input('media3_url');
		$post->media4_url = $request->input('media4_url');
		$post->update();

        return $post->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
		$post = Posts::find($id);
		$post->delete();
        return Response::json(['status'=>"OK"], 200);
    }
}
