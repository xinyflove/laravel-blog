<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;

class WebSenderController extends Controller {

    /**
     * 首页
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function index(Request $request)
    {
        $user_id = $request->input('user_id', 0);

        if($user_id)
        {
            // 查询自己的信息
            $mine = DB::table('chat_users')->where('id', '=', $user_id)->first();
            $request->session()->put('chat_mine', $mine);
        }

        return view('websender.index', array('user_id'=>$user_id));
    }

    /**
     * 获取主面板列表信息
     * @param Request $request
     */
    public function getList(Request $request)
    {
        $mine = $request->session()->get('chat_mine');//自己的信息
        $groupArr = array();//查询当前用户的所处的群组

        if($mine)
        {
            //全部用户(排除自己)
            $other = DB::table('chat_users')
                ->where('id', '<>', $mine->id)
                ->orderBy('status', 'DESC')
                ->get();

            $group_ids = DB::table('chat_group_rel')
                ->where('user_id', '=', $mine->id)
                ->pluck('group_id');
            if(!empty($group_ids))
            {
                foreach( $group_ids as $gid ){
                    $ret = DB::table('chat_group')->where('id', '=', $gid)->first();
                    if( !empty( $ret ) ){
                        $groupArr[] = (array)$ret;
                    }
                }
            }
            unset( $ret, $group_ids );
        }
        else
        {
            $mine = array(
                'username' => '<b><a href="/web-sender/login">点击登录</a></b>',
                'sign' => '未登录用户，请登录发言',
                'login' => false,
            );

            //全部用户
            $other = DB::table('chat_users')
                ->orderBy('status', 'DESC')
                ->get();
        }

        $group = array();//记录分组信息
        $userGroup = DB::table('chat_user_group')->get();//用户分组
        foreach( $userGroup as $ugv ){
            $group[] = array(
                'id' => $ugv->id,
                'groupname' => $ugv->groupname,
                'list' => array()
            );
        }
        unset($ugv, $userGroup);

        foreach( $group as &$gv ){

            foreach( $other as $ov ) {

                if ($gv['id'] == $ov->groupid) {

                    $_list['username'] = $ov->username;
                    $_list['id'] = $ov->id;
                    $_list['avatar'] = $ov->avatar;
                    $_list['sign'] = $ov->sign;
                    $_list['status'] = $ov->status;

                    $gv['list'][] = $_list;
                }
            }
            unset($_list, $ov);
        }
        unset($gv, $other);

        $datas = array(
            'code' => 0,
            'msg' => '',
            'data' => array(
                'mine' => $mine,
                'friend' => $group,
                'group' => $groupArr,
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

    /**
     * 聊天记录
     * @param Request $request
     */
    public function chatLogIndex(Request $request)
    {
        $id = $request->input('id', 0);
        $type = $request->input('type');

        return view('websender.chatlog', array('id'=>$id, 'type'=>$type));
    }

    /**
     * 聊天记录数据
     * @param Request $request
     * @return string
     */
    public function chatLogDetail(Request $request)
    {
        $id = $request->input('id', 0);
        $type = $request->input('type');
        $mine = $request->session()->get('chat_mine');//自己的信息

        if($type == 'friend')
        {
            $result = DB::table('chat_log')
                ->where('type', 'friend')
                ->where(function($query)use($mine,$id){
                    $query->where(array(
                        array('fromid', '=', $mine->id),
                        array('toid', '=', $id)
                    ))->orWhere(function ($query)use($mine,$id){
                        $query->where(array(
                            array('fromid', '=', $id),
                            array('toid', '=', $mine->id)
                        ));
                    });
                })
                ->orderBy('timeline', 'DESC')
                ->get();

            if(!count($result)){
                return json_encode(array('code' => -1, 'data' => '', 'msg' => '没有记录'));
            }

            return json_encode(array('code' => 1, 'data' => $result, 'msg' => 'success'));
        }
        else if('group' == $type)
        {
            $result = DB::table('chat_log')
                ->where(array(
                    array('toid', '=', $id),
                    array('type', '=', 'group')
                ))
                ->orderBy('timeline', 'DESC')
                ->get();

            if(!count($result)){
                return json_encode(array('code' => -1, 'data' => '', 'msg' => '没有记录'));
            }

            return json_encode(array('code' => 1, 'data' => $result, 'msg' => 'success'));
        }
    }
}