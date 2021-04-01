<?php
namespace App\Helpers;

class VerifyLike{

    public static function verify($likes,$id)
    {
        $is_like=false;
        foreach ($likes as $like) {

            if($like->user_id==$id){
                $is_like=true;
                
            }
        }

        return $is_like;
    }
}