<?php

namespace App\Http\Controllers;

use App\Models\User;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return view('users_create');
    }

    public function login()
    {
        return view('login') ;
    }

    // Store the user in the database
    public function UserAdd(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->Password,
            'cpassword' => $request->cPassword,
            'mobile_number' => $request->Mobile,
        ];
        $filters = [
            'name' => 'trim|escape|capitalize',
            'email' => 'trim|escape',
            'password' => 'trim|escape',
            'cpassword' => 'trim|escape',
            'mobile_number' => 'trim|escape',
        ];
        $sanitizer = new Sanitizer($data, $filters);
        $data = $sanitizer->sanitize();
        $rules = array(
            'name' => 'required|min:2|regex:/^[A-Za-z\s.]+$/',
            'email' => 'required|min:2|unique:users|regex:#d*[a-zA-Z_][a-zA-Z0-9]+[a-zA-Z+]*$#',
            'password' => 'required|min:6|regex:/^[A-Za-z@$!%*#?&0-9.]+$/i',
            'cpassword' => 'required|min:6|same:password',
            'mobile_number' => 'required|numeric|unique:users|regex:/[0-9]+[1-9]/',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $error_message = $validator->errors()->toArray();
            echo json_encode($error_message);
        } else {
            $key = "_vstream";

            $password=$data['password'].$key;
            $hashedPassword = Hash::make($password);
            $data['password'] =$hashedPassword;

            $usersave = User::create($data);
            if ($usersave->id) {
                $msg = 1;
            } else {
                $msg = 0;
                Log::error('Error in Saving New User: ' . $msg);
            }

            return json_encode([
                'success'=>true
            ]);
        }
    }

    public function UserLogin(Request $request) 
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
                // 'captcha' => 'required|captcha',
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
        
                $admin = new User();
                $key = "_vstream";
                $username = $data['username'];
                // $pass = md5($data['password'] . $key);
                // $cpass = md5('login@motor'.$key);

                $plainPassword=$data['password'].$key;

                $adin = User::where('username', $username)->first();
                $hashedPassword=User::where('username', $username)->value('password');
                 
                if (Hash::check($plainPassword, $hashedPassword)==true) 
                {                      
                    Session::put('userid', $adin['id']);
                   
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
