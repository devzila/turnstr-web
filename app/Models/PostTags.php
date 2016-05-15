<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTags extends Model
{
    protected $fillable = ['post_id', 'tag_name'];


    static function tag($post_id, $sentance)
    {
        // find all #tag
        preg_match_all('/#([^\s]+)/', $sentance, $matches);

        if(!array_key_exists(1, $matches)){
            return;
        }

        foreach($matches[1] as $tag){
            try{
                $result = PostTags::create([
                    'post_id' => $post_id,
                    'tag_name' => trim($tag)
                ]);

            } catch (\Illuminate\Database\QueryException $e) {
                // do Nothing, Issue might be because of duplicate
            } catch (PDOException $e) {
                // do Nothing
            }

        }

    }

}
