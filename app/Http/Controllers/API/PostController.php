<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    use GeneralTrait;

    public function index(){

        $posts = Post::selector();

        return $this->returnData( 'data', $posts ,'all posts send');
    }// end of index

    function getPstById(Request $request){

        $post = Post::selector()->find($request->id);

        if (!$post) {
            
            return $this->returnError('001' , 'Not found');

        }
        return response()->json($post);
    }// end of getPstById
}
