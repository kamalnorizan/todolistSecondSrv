<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Task;
use App\Models\User;
use Auth;

class ApiController extends Controller
{
    public function getTasks()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    public function register(Request $request)
    {
        $this->validate($request,[
            'name'=> 'required',
            'email'=> 'required|email',
            'password'=> 'required|min:8',
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        return response()->json(['status'=>'successful'], 200);
    }

    public function login(Request $request)
    {
        $data = [
            'email'=>$request->email,
            'password'=>$request->password
        ];

        if(auth()->attempt($data)){
            foreach (auth()->user()->tokens as $key => $token) {
                $token->revoke();
            }
            $token = auth()->user()->createToken('Client Mobile Apps');
            return response()->json(['token'=>$token], 200);
        }else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json(['status'=>'successful'], 200);
    }

    public function getUser()
    {
        $user = Auth::user();
        return response()->json($user, 200);
    }

    public function callback(Request $request)
    {
        $response = Http::post('http://todolist.test/oauth/token',[
            'grant_type'=> 'authorization_code',
            'client_id'=>7,
            'client_secret'=>'xo9o1bYStxEl3OXFCMJTcQ6SL7WQcAwHg5NYiIPi',
            'redirect_uri'=>'http://todolist2.test/callback',
            'code'=>$request->code
        ]);

        $user = $response->body();
        dd($response->body());
        $user = User::find('email',$user['email']);
        if(!$user){
            $user = new User;

        }

    }
}
