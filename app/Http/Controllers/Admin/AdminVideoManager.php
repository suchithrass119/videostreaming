<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Videos;

class AdminVideoManager extends Controller
{
    public function index()
    {
        return view('admin.video-upload') ;
    }
    public function uploadVideo(Request $request)
    {
        // dd($request);
        // $request->validate([
        //     'Title' => 'required|string|max:255',
        //     'videoFile' => 'required|mimes:mp4,avi,mov|max:51200', // 50MB limit
        //     'Thumbnail' => 'required|mimes:jpg,png,jpeg|max:5120', // 2MB limit
        //     'Description' => 'required',  
        // ]);
       
        $videoPath = $request->file('videoFile')->store('Videos', 'public');
       
        $thumbpath = $request->file('Thumbnail')->store('Thumbnails', 'public');
        $video = Videos::create([
            'title' => $request->Title,
            'main_url' => $videoPath,
            'url' => $thumbpath,
            'description' => $request->Description,
        ]);

       return json_encode([
        'success'=>true
       ]);
    }
}
