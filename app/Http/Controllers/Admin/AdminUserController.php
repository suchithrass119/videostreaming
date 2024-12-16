<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('admin.admin-user-create') ;
    }

    public function LoginAdmin() 
    {
        return view('adminlogin') ;
    }

    public function getLogin(Request $request) 
    {
        try {
            //code...
            
            // dd(Session::get('captcha'));
            $data = [
                "username" => $request->get('username'),
                "password" => $request->get('password'),
                // "captcha" => $request->captcha,
            ];
        
            
            $filters = [
                'username' => 'trim|escape',
                'password' => 'trim|escape',
                // 'captcha' => 'trim|escape',
            ];
            $sanitizer = new Sanitizer($data, $filters);
            $data = $sanitizer->sanitize();
            $rules = array(
                'username' => 'Required',
                'password' => 'Required|Between:6,20',
                'captcha' => 'required|captcha',
            );
            $messages = [
                'captcha' => 'Incorrect entry of captcha.Try again.',
                'password' => 'Wrong password .Try again.',
            ];
            $v = Validator::make($data, $rules, $messages);
            // dd($v->errors()->toArray());
            if ($v->fails()) {
                $errors = $v->errors()->toArray();
                $data = array('status' => false,
                    'message' => 'invalid',
                    'error' => $errors);
                echo json_encode($data);
            } else {
        
                $admin = new UserModel();
                $key = "_vstream";
                $username = $data['username'];
                // $pass = md5($data['password'] . $key);
                // $cpass = md5('login@motor'.$key);

                $plainPassword=$data['password'].$key;

                $adin = UserModel::where('username', $username)->first();
                $hashedPassword=UserModel::where('username', $username)->value('password');
                 
                if (Hash::check($plainPassword, $hashedPassword)==true) 
                {                      
                    Session::put('userid', $adin['user_id']);
                    $data = array('status' => true,
                    'message' => 'valid',
                    'status' => $adin['user_status']);
                    echo json_encode($data);

                } else {
                    $errors = array("msg" => "Invalid Username Or Password");
                    $data = array('status' => false,
                        'message' => 'invalid',
                        'error' => $errors);
                    echo json_encode($data);
                }
            }
        } catch (\Throwable $th) {
            $errors = array("msg" => "Something went wrong.");
            $data = array('status' => false,
                'message' => 'invalid',
                'error' => $errors);
            echo json_encode($data);
            //echo "Something went wrong";
        }
    }
}
