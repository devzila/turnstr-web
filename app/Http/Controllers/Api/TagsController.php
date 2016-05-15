<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Helpers\ResponseClass;
use Response;
use App\Models\PostTags;
use App\Models\Posts;
use App\Models\Api;
use DB;

class TagsController extends Controller
{

    const POSTS_PER_PAGE = 10;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $page = $request->input('page', 0);

        $posts = DB::table('posts')
            ->join('post_tags', 'posts.id', '=', 'post_tags.post_id')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where('post_tags.tag_name', '=', $id)
            ->select('posts.*', 'users.name', 'users.profile_image', 'users.username')
            ->skip($page * self::POSTS_PER_PAGE)->take(self::POSTS_PER_PAGE)
            ->get();

        // add additional field
        $posts = Posts::addExtraAttributes($posts);

        return ResponseClass::Prepare_Response($posts,"Post Listing tagged for $id",true, Api::STATUS_CODE_SUCCESS_OK);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_id)
    {
        $slugs = explode(',', $request->input('tag_names'));

        foreach($slugs as $slug){
            try{
                $result = PostTags::create([
                    'post_id' => $post_id,
                    'tag_name' => trim($slug)
                ]);

            } catch (\Illuminate\Database\QueryException $e) {
                // do Nothing, Issue might be because of duplicate
            } catch (PDOException $e) {
                // do Nothing
            }
        }

        return ResponseClass::Prepare_Response(['post_id' => $post_id],'Tags created successfuly',true,200);
    }

}