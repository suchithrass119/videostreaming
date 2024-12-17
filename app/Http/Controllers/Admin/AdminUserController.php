<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonFunctions;
use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
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
        
                $admin = new AdminUser();
                $key = "_vstream";
                $username = $data['username'];
                // $pass = md5($data['password'] . $key);
                // $cpass = md5('login@motor'.$key);

                $plainPassword=$data['password'].$key;

                $adin = AdminUser::where('username', $username)->first();
                $hashedPassword=AdminUser::where('username', $username)->value('password');
                 
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

    public function UserCreation(Request $request)
    {

        $helper=new CommonFunctions();

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'cpassword' => $request->cpassword,
            'user_status' => $request->userstatus,
            'mob_number' => $request->mob_number,
            
        ];
        $filters = [
            'name' => 'trim|escape|capitalize',
            'username' => 'trim|escape',
            'password' => 'trim|escape',
            'cpassword' => 'trim|escape',
            'userstatus' => 'trim|escape',
            'mob_number' => 'trim|escape',
            
        ];
        $sanitizer = new Sanitizer($data, $filters);
        $data = $sanitizer->sanitize();
        $rules = array(
            'name' => 'required|min:2|regex:/^[A-Za-z\s.]+$/',
            'username' => 'required|min:2|unique:adminusers|regex:#d*[a-zA-Z_][a-zA-Z0-9]+[a-zA-Z+]*$#',
            'password' => 'required|min:6|regex:/^[A-Za-z@$!%*#?&0-9.]+$/i',
            'cpassword' => 'required|min:6|same:password',
            'mob_number' => 'required|numeric|unique:adminusers|regex:/[0-9]+[1-9]/',
            'propic' => 'file|mimes:jpeg,jpg,png|max:2048',
            
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $error_message = $validator->errors()->toArray();
            echo json_encode($error_message);
        } else {
            $key = "_vstream";
            // $data['password'] = md5($data['password'] . $key);
            $file = $request->file('propic');
            // dd($file);

            if ($helper->isMaliciousFile($file)) {
                return response()->json(['error' => 'The uploaded file is not allowed.'], 422);
            }

            $picpath = $request->file('propic')->store('Propic', 'public');
            // dd($picpath);
            $password=$data['password'].$key;
            $hashedPassword = Hash::make($password);
            $data['password'] =$hashedPassword;
            $data['picpath'] =$picpath;
            // dd($data);

            $usersave = AdminUser::create($data);
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

    public function logout()
    {
        // $this->save_logout_history();
        Session::flush();
        return Redirect::to('/adminlogin');
    }
}
