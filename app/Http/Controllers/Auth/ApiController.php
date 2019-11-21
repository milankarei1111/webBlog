<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('login', 'register');
    }

    protected function username()
    {
        return 'name';
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $status = 'E00002';
            $value = $validator->errors();
        } else {
            $api_token = Str::random(80);
            $data = array_merge($request->all(), compact('api_token'));
            $result = $this->create($data);

            if ($result) {
                $status = '000000';
                $value = $api_token;
            } else {
                $status = 'E00001';
                $value = '註冊失敗';
            }
        }
        return $this->responseMessage($status, $value);
    }

    public function login()
    {
        $inputName = request($this->username());
        $user = User::where($this->username(), $inputName)->get()->first();
        if($user){
            if(password_verify(request('password'), $user->password)){
                $api_token = Str::random(80);
                $result = $user->update(['api_token'=>hash('sha256', $api_token)]);
                if ($result) {
                    $status = '000000';
                    $value = $api_token;
                } else {
                    $status = 'E00001';
                    $value = '登入失敗';
                }
            } else {
                $status = 'E00002';
                $value = '輸入錯誤!';
            }
        } else {
            $status = 'E00002';
            $value = '輸入錯誤!';
        }
        return $this->responseMessage($status, $value);
    }

    protected function create(array $data)
    {
        return User::forceCreate([
            'name' => $data['name'],
            // 'email'=>$data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'api_token' => hash('sha256', $data['api_token'])
        ]);
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
    }

    protected function responseMessage($status, $value=null)
    {
        return response()->json([
            'status' => $status,
            'value' => $value
        ]);
    }
}
