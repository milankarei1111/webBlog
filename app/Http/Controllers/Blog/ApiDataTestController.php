<?php

namespace App\Http\Controllers\Blog;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class ApiDataTestController extends Controller
{
    private $methods = [];
    //
    public function __construct()
    {
        $this->methods = ['GET', 'POST', 'PATCH', 'DELETE'];
    }

    public function index()
    {
        $methods = $this->methods;
        return view('test.api', compact('methods'));
    }

    public function apiTest()
    {
        $formData = [];
        $params = [];
        $url = request('url');
        if (request('param')) {
            if (! (request('method') == 'GET')) {
                foreach (request('param') as $data) {
                    $params[$data['key']] = $data['value'];
                }
                $formData['form_params'] = $params;
            }
        }

        // 偽造一個http請求服務器
        $client  =  new Client;
        $response = $client->request(request('method'), $url, $formData);
        $data = $response->getBody()->getContents();
        $methods = $this->methods;
        return view('test.api', compact('data', 'methods'));
    }
}
