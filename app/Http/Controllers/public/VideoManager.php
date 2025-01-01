<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Models\Videos;
use Illuminate\Http\Request;

class VideoManager extends Controller
{
    public function index(Request $request)
    {
    //     $videos = videos::paginate(8); // Fetch 12 items per page
    //    return view('list',compact('videos')) ;
        $videos = Videos::with('category')->orderBy('created_at', 'desc')->paginate(3); // 10 videos per page

        if ($request->ajax()) {
            $data=response()->json([
                'videos' => $videos->items(),
                'next_page_url' => $videos->nextPageUrl(),
            ]);

            return $data;
        }
        else
        {
            return view('list',compact('videos')) ;
        }
    }
    public function  VideoDetails(string $id,Request $request) 
    {
        $video = Videos::find($id); // Fetch 12 items per page

        $videos = Videos::with('category')->where('id',"!=",$id)->orderBy('created_at', 'desc')->paginate(2); // 10 videos per page
        $videoscat = Videos::with('category')->where('category_id',$video->category_id)->where('id',"!=",$id)->orderBy('created_at', 'desc')->paginate(2); // 10 videos per page

        if ($request->ajax()) {

            $data=response()->json([
                'videos' => $videos->items(),
                'next_page_url' => $videos->nextPageUrl(),
                'videoscat' => $videoscat->items(),
                'next_page_url_cat' => $videoscat->nextPageUrl(),
            ]);

            return $data;
        }
        else
        {
            return view('single-video-details',compact('video','videos','videoscat')) ;
        }

    }
    // VideoController.php
    


}
