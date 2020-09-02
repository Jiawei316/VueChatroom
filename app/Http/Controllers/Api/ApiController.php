<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use App\Friend;
use App\Chat;

class ApiController extends Controller
{
    public function test(){
        return 'Api Is Working!';
    }

    public function login(Request $request){
        $input = $request->all();

        foreach($input as $data){
            if(strlen($data) == 0){
                return [
                    'msg' => '帳號、密碼，不能為空',
                    'status' => false
                ];
            }
        }

        $query = User::where('account',$input['account'])->first();

        if(!is_null($query) && Hash::check($input['password'],$query->password)){
            return [
                'msg' => '登入成功',
                'status' => true,
                'data' => [
                    'id' => $query->id,
                    'username' => $query->username,
                    '_token' => $query->api_token
                ]
            ];
        }else{
            return [
                'msg' => '帳號不存在。',
                'status' => false
            ];
        }
    }

    public function register(Request $request){
        $input = $request->all();

        foreach($input as $data){
            if(strlen($data) == 0){
                return [
                    'msg' => '使用者姓名、帳號、密碼，不能為空',
                    'status' => false
                ];
            }
        }

        $query = User::where('account',$input['account'])->first();

        if(!is_null($query)){
            return [
                'msg' => '此帳號已存在，請使用其他帳號。',
                'status' => false
            ];
        }else{
            $user = User::create([
                'username' => $input['username'],
                'account' => $input['account'],
                'password' => Hash::make($input['password']),
                'api_token' => Str::random(80)
            ]);

            return [
                'msg' => '帳號已建立完成，可以開始登入。',
                'data' => $user->id,
                'status' => true
            ];
        }
    }

    public function logout(Request $request){
        $query = User::where('api_token',$request->token)->first();

        $query->update([
            'api_token' => Str::random(80)
        ]);

        return $query;
    }

    public function getFriendInvitation(Request $request){
        $input = $request->all();
        $query = User::where('api_token',$input['token'])->first();

        $data = Friend::where([
            ['friend_index','=',$query->id],
            ['isAccept','=',0]
        ])->get()->map(function($d){
            return [
                'id' => $d->id,
                'selfName' => User::find($d->self_index)->username
            ];
        });

        return $data;
    }

    public function changeFriendInvitation(Request $request){
        $input = $request->all();

        $data = Friend::where('id',$input['id'])->update(['isAccept' => $input['bool']]);

        return $data;
    }

    public function getFriendsList($id){
        return collect(Friend::where([
            ['self_index','=',$id],
            ['isAccept','=',1]
        ])->orWhere([
            ['friend_index','=',$id],
            ['isAccept','=',1]
        ])->get()->map(function($d) use ($id){
            return $d->self_index === intval($id) ? $d->friend_index : $d->self_index;
        }))->unique()->map(function($d) use($id){
            $chatData = Chat::where([
                ['from_id','=',$d],
                ['for_id','=',$id]
            ])->orWhere([
                ['from_id','=',$id],
                ['for_id','=',$d]
            ])->OrderBy('id','desc')->take(1)->first();

            return [
                'id' => User::find($d)->id,
                'username' => User::find($d)->username,
                'lastMessage' => is_null($chatData) ? '' : $chatData->content
            ];
        });
    }

    public function getChatList($id){
        return Chat::where('from_id',$id)->orWhere('for_id',$id)->get()->map(function($d){
            return [
                'From' => User::find($d->from_id)->username,
                'For' => User::find($d->for_id)->username,
                'content' => $d->content,
                'time' => date('A h:i',strtotime($d->created_at))
            ];
        });
    }

    public function addChat(Request $request){
        $input = $request->all();

        $chat = Chat::create([
            'from_id' => $input['fromId'],
            'for_id' => $input['forId'],
            'content' => $input['content']
        ]);

        return $chat->id;
    }
}
