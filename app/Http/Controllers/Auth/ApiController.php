<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('login', 'register');
    }

    protected function username()
    {
        return 'name';
    }

    public function register(Request $request)
    {
        $value = '';
        $meassage = '';
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $status = 'E00002';
            $meassage = $validator->errors();
        } else {
            $api_token = Str::random(80);
            $data = array_merge($request->all(), compact('api_token'));
            $result = $this->create($data);

            if ($result) {
                $status = '000000';
                $value = $api_token;
            } else {
                $status = 'E00001';
            }
        }
        return $this->responseMessage($status, $meassage, $value);
    }

    public function login()
    {
        $inputName = request($this->username());
        $user = User::where($this->username(), $inputName)->get()->first();
        $value = '';
        if ($user) {
            if (password_verify(request('password'), $user->password)) {
                $api_token = Str::random(80);
                $result = $user->update(['api_token' => hash('sha256', $api_token)]);
                if ($result) {
                    $status = '000000';
                    $value = $api_token;
                } else {
                    $status = 'E00001';
                }
            } else {
                $status = 'E00002';
            }
        } else {
            $status = 'E00002';
        }
        return $this->responseMessage($status, '', $value);
    }

    public function logout()
    {
        $value = '';
        $user = auth()->user();
        if ($user) {
            $result = $user->update(['api_token' => null]);
            if ($result) {
                $status = '000000';
            } else {
                $status = 'E00001';
            }
        }
        return $this->responseMessage($status, '', $value);
    }

    public function refresh()
    {
        $api_token = Str::random(80);
        $user = auth()->user();
        $value = '';
        if ($user) {
            $result = $user->update(['api_token' => hash('sha256', $api_token)]);
            if ($result) {
                $status = '000000';
                $value = $api_token;
            } else {
                $status = 'E00001';
            }
        } else {
            $status = 'E00002';
        }
        return $this->responseMessage($status, '', $value);
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

    protected function responseMessage($status, $error=null, $value=null)
    {
        $meassage = '';
        switch ($status) {
            case '000000':
                $meassage = '執行成功!';
                break;
            case 'E00001':
                $meassage = '執行失敗!';
                break;
            case 'E00002':
                if ($error) {
                    $meassage = $error;
                } else {
                    $meassage = '資料輸入錯誤!';
                }
                break;
            default:
                $meassage = '未定義錯誤!';
                break;
        }
        return response()->json([
            'status' => $status,
            'meassage' => $meassage,
            'value' => $value
        ]);
    }
}
