<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Models\Videos;
use Illuminate\Http\Request;

class VideoManager extends Controller
{
    public function index()
    {
    //     $videos = videos::paginate(8); // Fetch 12 items per page
    //    return view('list',compact('videos')) ;
        $videos = videos::orderBy('created_at', 'desc')->paginate(10); // 10 videos per page
        return view('list',compact('videos')) ;
    }
    public function  VideoDetails(string $id) 
    {
        $video = videos::find($id); // Fetch 12 items per page
        return view('single-video-details',compact('video')) ;
    }
}
