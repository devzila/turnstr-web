<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Helpers\ResponseClass;
use Response;
use Validator;
use App\Models\User;
use App\Models\Posts;
use App\Models\DeviceSession;
use Rhumsaa\Uuid\Uuid;
use URL;
use File;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Posts::getPostsByUserId(DeviceSession::get()->user->id);

        return ResponseClass::Prepare_Response($posts,'Post Listing',true,200);
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
     * @param  \Illuminate\Http\Request $request
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
        return ResponseClass::Prepare_Response($result,'Posts created successfuly',true,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Posts::find($id);
        return ResponseClass::Prepare_Response($post,'List of posts',true,200);
        // return $post->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
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

        return ResponseClass::Prepare_Response($post,'Post updated successfuly',true,200);
        // return $post->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Posts::find($id);
        $post->delete();
        return ResponseClass::Prepare_Response('','Deleted successfuly',true,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deletePost()
    {
        $userId = Input::get('userIds');
        $idArr = explode(',', $userId);
        $post = Posts::whereIn('id',$idArr)->delete();
        return ResponseClass::Prepare_Response('','Deleted successfuly',true,200);
    }

    /**
     * Search and return objects thumbnails.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function explorer()
    {
        $searchData = Input::get('searchData');
        $access_token = Input::get('access_token');
        $userId = '';
        $userDevice = User::userDetails($access_token);
        if (isset($userDevice->id)) {
            $userId =  $userDevice->id;
        }

        $imagesToExplore = Posts::getImages($userId,$searchData);
        return ResponseClass::Prepare_Response($imagesToExplore,'List of images to explore',true,200);
    }

    /**
     * myprofile posts
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function profilePosts()
    {
        $userId = DeviceSession::get()->user->id;
        $posts = Posts::followPosts($userId);
        return ResponseClass::Prepare_Response($posts,'List of posts',true,200);
    }


    public function upload(Request $request)
    {
        // $files = [
        //     'image1' => $request->file('image1'),
        //     'image2' => $request->file('image2'),
        //     'image3' => $request->file('image3'),
        //     'image4' => $request->file('image4')
        // ];

        // $rules = [
        //     'image1' => 'required',
        //     'image2' => 'required',
        //     'image3' => 'required',
        //     'image4' => 'required'
        // ];


        // $validator = Validator::make($files, $rules);
        // if ($validator->fails()) {
        //     return ResponseClass::Prepare_Response('','validation fails',false, 200);
        // }

        $destinationPath = public_path() . '/media'; // upload path

        if(!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, $mode = 0777, true, true);
        }

        $fileNames =[];
        $thumbNames = [];
        for($i = 1; $i<=4; $i++){
            $extension = $request->file("image$i")->getClientOriginalExtension();
            $fileNames[$i] = Uuid::uuid1()->toString() . '.' . $extension;
            $request->file("image$i")->move($destinationPath, $fileNames[$i]);

            $thumbNames[$i] = '';
            if($request->file("thumb$i")){
                $extension = $request->file("thumb$i")->getClientOriginalExtension();
                $thumbNames[$i] = Uuid::uuid1()->toString() . '.' . $extension;
                $request->file("thumb$i")->move($destinationPath, $thumbNames[$i]);

            }
        }


        $result = Posts::create([
            'user_id' => DeviceSession::get()->user->id,
            'caption' => $request->get('caption'),
            'media1_url' => URL::to('/') . '/media/' . $fileNames[1],
            'media2_url' => URL::to('/') . '/media/' . $fileNames[2],
            'media3_url' => URL::to('/') . '/media/' . $fileNames[3],
            'media4_url' => URL::to('/') . '/media/' . $fileNames[4],
            'media1_thumb_url' => $thumbNames[1] ? URL::to('/') . '/media/' . $thumbNames[1] : '',
            'media2_thumb_url' => $thumbNames[2] ? URL::to('/') . '/media/' . $thumbNames[2] : '',
            'media3_thumb_url' => $thumbNames[3] ? URL::to('/') . '/media/' . $thumbNames[3] : '',
            'media4_thumb_url' => $thumbNames[4] ? URL::to('/') . '/media/' . $thumbNames[4] : ''
        ]);

        return ResponseClass::Prepare_Response($result,'uploaded successfuly',true,200);


    }

}