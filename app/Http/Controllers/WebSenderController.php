<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class WebSenderController extends Controller {

    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $user_info = array();
        if($user_id)
        {
            $user_info = DB::table('chat_users')->where('id', '=', $user_id)->first();
            $request->session()->put('chat_user_info', $user_info);
        }

        return view('websender.index', array('user_id'=>$user_id));
    }

    public function getList(Request $request)
    {
        $user_info = $request->session()->get('chat_user_info');
        $user_id = $user_info->id;
        $friend = array();  //好友列表

        $user = DB::select('select * from chat_users where id = :id', ['id' => $user_id]);
        if($user)
        {
            $mine = (array)$user[0];    //我的信息

            $friend_group = DB::select('select * from chat_friend_group where user_id = :user_id', ['user_id' => $user_id]);

            if($friend_group)
            {
                foreach ($friend_group as $fg)
                {
                    $_g_info = array(
                        'id' => $fg->id,
                        'groupname' => $fg->groupname,
                        'list' => array()
                    );

                    $_friend_ids = DB::select('select user_id from chat_friend_group_rel where group_id = :group_id', ['group_id' => $fg->id]);
                    if($_friend_ids)
                    {
                        $_friend_ids = implode(',', array_column($_friend_ids, 'user_id'));
                        $_friends = DB::select('select * from chat_users where id IN ('.$_friend_ids.')', []);
                        foreach ($_friends as &$f)
                        {
                            $f = (array)$f;
                        }
                        unset($f);
                        $_g_info['list'] = $_friends;
                    }
                    $friend[] = $_g_info;
                }
            }
        }
        else
        {
            $mine = array(
                'username' => '<b><a href="/web-sender/login">点击登录</a></b>',
                'sign' => '未登录用户，请登录发言',
                'login' => false,
            );
        }

        $group = DB::select('select * from chat_group', []);    //群组列表
        if($group)
        {
            foreach ($group as &$g)
            {
                $g = (array)$g;
            }
            unset($g);
        }

        $datas = array(
            'code' => 0,
            'msg' => '',
            'data' => array(
                'mine' => $mine,
                'friend' => $friend,
                'group' => $group,
            )
        );

        echo json_encode($datas);
    }

    public function getMembers(Request $request)
    {
        $list = DB::select('select * from chat_users', []);
        
        $datas = array(
            'code' => 0,
            'msg' => '',
            'data' => array(
                'list' => $list,
            )
        );

        echo json_encode($datas);
    }
}