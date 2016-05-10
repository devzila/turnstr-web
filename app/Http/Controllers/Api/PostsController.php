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
use App\Helpers\UniversalClass;
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
        $posts = Posts::getPostsUserFollowing(DeviceSession::get()->user->id);

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
        $result['shareUrl'] = UniversalClass::shareUrl($result['id']);
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

        foreach ($imagesToExplore as $key => $value) {
            $arr1 = explode('.',$value->media1_url);
            $arr2 = explode('.',$value->media2_url);
            $arr3 = explode('.',$value->media3_url);
            $arr4 = explode('.',$value->media4_url);
            $imagesToExplore[$key]->media1_type = end($arr1);
            $imagesToExplore[$key]->media2_type = end($arr2);
            $imagesToExplore[$key]->media3_type = end($arr3);
            $imagesToExplore[$key]->media4_type = end($arr4);
        }

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
        $postCount = Posts::where('user_id',$userId)->count();
        $posts = Posts::selfPosts($userId);

        foreach ($posts as $key => $value) {
            $arr1 = explode('.',$value->media1_url);
            $arr2 = explode('.',$value->media2_url);
            $arr3 = explode('.',$value->media3_url);
            $arr4 = explode('.',$value->media4_url);
            $posts[$key]->media1_type = end($arr1);
            $posts[$key]->media2_type = end($arr2);
            $posts[$key]->media3_type = end($arr3);
            $posts[$key]->media4_type = end($arr4);
        }
        return ResponseClass::Prepare_Response(['postDetails'=>$posts,'post_count'=>$postCount],'List of posts',true,200);
    }
    /**
     * posts
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function shareUrl()
    {
        $postId = Input::get('id');
        
        $postUrl = UniversalClass::shareUrl($postId);
        
        return ResponseClass::Prepare_Response($postUrl,'share url',true,200);
    }

    public function upload(Request $request)
    {
        $files = [
            'image1' => $request->file('image1'),
            'image2' => $request->file('image2'),
            'image3' => $request->file('image3'),
            'image4' => $request->file('image4')
        ];

        $rules = [
            'image1' => 'required',
            'image2' => 'required',
            'image3' => 'required',
            'image4' => 'required'
        ];


        $validator = Validator::make($files, $rules);
        if ($validator->fails()) {
            return ResponseClass::Prepare_Response('','validation fails',false, 200);
        }

        $destinationPath = public_path() . '/media'; // upload path

        if(!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, $mode = 0777, true, true);
        }

        $fileNames =[];
        $thumbNames = [];
        $extensionArr = array();
        for($i = 1; $i<=4; $i++){
            $extension = $request->file("image$i")->getClientOriginalExtension();
            $extensionArr["media".$i."_type"] = $extension;
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

        for($i = 1; $i<=4; $i++){
            $newProp = "media".$i."_type";
            if (isset($extensionArr[$newProp])) {
                $result->$newProp = $extensionArr[$newProp];
            }
        }

        $result->liked = null;
        $result->follow = null;
        $result->shareUrl = UniversalClass::shareUrl($result->id);
        return ResponseClass::Prepare_Response($result,'uploaded successfuly',true,200);


    }

}