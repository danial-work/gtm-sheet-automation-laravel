<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GTM_call extends Controller
{
    function list(Request $request)
    {
        return Http::get('https://jsonplaceholder.typicode.com/posts')->json();
    }

    function account(Request $request, $account_id = "")
    {
        $header_auth = $request->header('Authorization');

        if(!isset($header_auth))
        {
            $json_obj = array('error' => "authorization token not passed");
            
            header("Content-Type: application/json");
            echo json_encode($json_obj);
            exit();
        }
        else
        {
            if(strlen($account_id) > 0)
            {
                return Http::withHeaders([
                    'Authorization' => 'Bearer '.$header_auth
                ])->get('https://www.googleapis.com/tagmanager/v2/accounts/'.$account_id)->json();
            }
            else
            {
                return Http::withHeaders([
                    'Authorization' => 'Bearer '.$header_auth
                ])->get('https://www.googleapis.com/tagmanager/v2/accounts/')->json();
            }
        }
    }

    function container(Request $request, $account_id, $container_id ="")
    {
        $header_auth = $request->header('Authorization');

        if(!isset($header_auth))
        {
            $json_obj = array('error' => "authorization token not passed");

            header("Content-Type: application/json");
            echo json_encode($json_obj);
            exit();
        }
        else
        {
            return Http::withHeaders([
                'Authorization' => 'Bearer '.$header_auth
            ])->get('https://www.googleapis.com/tagmanager/v2/accounts/'.$account_id.'/containers')->json();
        }
        
        // $data = Http::get('https://jsonplaceholder.typicode.com/posts')->json();

        // return view('GTM_call',['data'=>$data]);
    }

    function workspace(Request $request, $account_id, $container_id, $workspace_id = "")
    {
        $header_auth = $request->header('Authorization');

        if(!isset($header_auth))
        {
            $json_obj = array('error' => "authorization token not passed");

            header("Content-Type: application/json");
            echo json_encode($json_obj);
            exit();
        }
        else
        {
            return Http::withHeaders([
                'Authorization' => 'Bearer '.$header_auth
            ])->get('https://www.googleapis.com/tagmanager/v2/accounts/'.$account_id.'/containers/'.$container_id.'/workspaces')->json();
        }
        
        // $data = Http::get('https://jsonplaceholder.typicode.com/posts')->json();

        // return view('GTM_call',['data'=>$data]);
    }

    function generate_sheet(Request $request)
    {
        $header_auth = $request->header('Authorization');
        $JSON_payload = $request->header('Data');
        
        // echo($header_auth);
        echo($JSON_payload);
        
    }
}
