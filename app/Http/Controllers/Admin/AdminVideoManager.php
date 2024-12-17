<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonFunctions;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Videos;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminVideoManager extends Controller
{
    public function index()
    {
        $category=Category::pluck('title','id');
        return view('admin.video-upload',compact('category')) ;
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
            'category_id' => $request->category_id,
            'description' => $request->Description,
        ]);

       return json_encode([
        'success'=>true
       ]);
    }

    public function VideoCat() 
    {
        return view('admin.video-category') ;
    }

    public function CatCreation(Request $request)
    {

        $helper=new CommonFunctions();

        $data = [
            'title' => $request->Title,
            'status' => $request->status,
          
            
        ];
        $filters = [
            'title' => 'trim|escape|capitalize',
            'status' => 'trim|escape',
           
            
        ];
        $sanitizer = new Sanitizer($data, $filters);
        $data = $sanitizer->sanitize();
        $rules = array(
            'title' => 'required|min:2',
            'status' => 'required',
            'cateImg' => 'file|mimes:jpeg,jpg,png|max:2048',
            
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $error_message = $validator->errors()->toArray();
            echo json_encode($error_message);
        } else {
            $file = $request->file('cateImg');

            if ($helper->isMaliciousFile($file)) {
                return response()->json(['error' => 'The uploaded file is not allowed.'], 422);
            }

            $cateImg = $request->file('cateImg')->store('cateImg', 'public');
            
            $data['picpath'] =$cateImg;

            $usersave = Category::create($data);
            if ($usersave->id) {
                $msg = 1;
            } else {
                $msg = 0;
                Log::error('Error in Saving : ' . $msg);
            }

                

            return json_encode([
                'success'=>true
            ]);
        }
    }
}
