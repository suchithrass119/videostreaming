<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Models\Videos;
use Illuminate\Http\Request;

class VideoManager extends Controller
{
    public function index()
    {
        $baseurl=asset("/");
        $videos = videos::paginate(8); // Fetch 12 items per page
       return view('list',compact('videos','baseurl')) ;
    }
    public function  VideoDetails(string $id) 
    {
        $video = videos::find($id); // Fetch 12 items per page
        $baseurl=asset("/");
        return view('single-video-details',compact('video','baseurl')) ;
    }
}
