<?php

namespace App\Http\Controllers;

class WebSenderController extends Controller {

    public function index()
    {
        return view('websender.index');
    }

    public function getList()
    {
        //我的信息
        $mine = array(
            'id' => '100000',   //我的ID
            'username' => '纸飞机',    //我的昵称
            'status' => 'online',   //在线状态 online：在线、hide：隐身
            'sign' => '在深邃的编码世界，做一枚轻盈的纸飞机', //我的签名
            'avatar' => '//res.layui.com/images/fly/avatar/00.jpg'
        );

        //好友列表
        $friend = array(
            array(
                'id' => '0',    //分组ID
                'groupname' => '知名人物',  //好友分组名
                'list' => array(    //分组下的好友列表
                    array(
                        'id' => '100001',   //好友ID
                        'username' => '贤心', //好友昵称
                        'status' => 'offline',   //若值为offline代表离线，online或者不填为在线
                        'sign' => '这些都是测试数据，实际使用请严格按照该格式返回',    //好友签名
                        'avatar' => '//tva1.sinaimg.cn/crop.0.0.118.118.180/5db11ff4gw1e77d3nqrv8j203b03cweg.jpg'   //好友头像
                    ),
                    array(
                        'id' => '100001222',
                        'username' => '刘小涛',
                        'status' => 'online',
                        'sign' => '如约而至，不负姊妹欢乐颂',
                        'avatar' => '//tva4.sinaimg.cn/crop.0.1.1125.1125.180/475bb144jw8f9nwebnuhkj20v90vbwh9.jpg'
                    ),
                    array(
                        'id' => '10034001',
                        'username' => '谢小楠',
                        'sign' => '',
                        'avatar' => '//tva2.sinaimg.cn/crop.1.0.747.747.180/633f068fjw8f9h040n951j20ku0kr74t.jpg'
                    ),
                    array(
                        'id' => '168168',
                        'username' => '马小云',
                        'sign' => '让天下没有难写的代码',
                        'avatar' => '//tva1.sinaimg.cn/crop.0.0.180.180.180/7fde8b93jw1e8qgp5bmzyj2050050aa8.jpg'
                    ),
                    array(
                        'id' => '666666',
                        'username' => '徐小峥',
                        'sign' => '代码在囧途，也要写到底',
                        'avatar' => '//tva1.sinaimg.cn/crop.0.0.512.512.180/6a4acad5jw8eqi6yaholjj20e80e8t9f.jpg'
                    ),
                )
            ),
            array(
                'id' => '1',
                'groupname' => '网红声优',
                'list' => array(
                    array(
                        'id' => '121286',
                        'username' => '罗小凤',
                        'sign' => '在自己实力不济的时候，不要去相信什么媒体和记者。他们不是善良的人，有时候候他们的采访对当事人而言就是陷阱',
                        'avatar' => '//tva4.sinaimg.cn/crop.0.0.640.640.180/4a02849cjw8fc8vn18vktj20hs0hs75v.jpg'
                    ),
                    array(
                        'id' => '108101',
                        'username' => 'Z_子晴',
                        'sign' => '微电商达人',
                        'avatar' => '//tva1.sinaimg.cn/crop.0.23.1242.1242.180/8693225ajw8fbimjimpjwj20yi0zs77l.jpg'
                    ),
                    array(
                        'id' => '12123454',
                        'username' => '大鱼_MsYuyu',
                        'sign' => '我瘋了！這也太準了吧  超級笑點低',
                        'avatar' => '//tva2.sinaimg.cn/crop.0.0.512.512.180/005LMAegjw8f2bp9qg4mrj30e80e8dg5.jpg'
                    ),
                    array(
                        'id' => '102101',
                        'username' => '醋醋cucu',
                        'sign' => '',
                        'avatar' => '//tva2.sinaimg.cn/crop.0.0.640.640.180/648fbe5ejw8ethmg0u9egj20hs0ht0tn.jpg'
                    ),
                    array(
                        'id' => '3435343',
                        'username' => '柏雪近在它香',
                        'sign' => '',
                        'avatar' => '//tva2.sinaimg.cn/crop.0.8.751.751.180/961a9be5jw8fczq7q98i7j20kv0lcwfn.jpg'
                    ),
                )
            ),
            array(
                'id' => '2',
                'groupname' => '女神艺人',
                'list' => array(
                    array(
                        'id' => '76543',
                        'username' => '王小贤',
                        'sign' => '我爱贤心',
                        'avatar' => '//wx2.sinaimg.cn/mw690/5db11ff4gy1flxmew7edlj203d03wt8n.jpg'
                    ),
                    array(
                        'id' => '4803920',
                        'username' => '佟小娅',
                        'sign' => '微电商达人',
                        'avatar' => '//tva3.sinaimg.cn/crop.0.0.750.750.180/5033b6dbjw8etqysyifpkj20ku0kuwfw.jpg'
                    ),
                )
            ),
        );

        //群组列表
        $group = array(
            array(
                'id' => '101',  //群组ID
                'groupname' => '前端群',   //群组名
                'avatar' => '//tva1.sinaimg.cn/crop.0.0.200.200.50/006q8Q6bjw8f20zsdem2mj305k05kdfw.jpg',   //群组头像
            ),
            array(
                'id' => '102',
                'groupname' => 'Fly社区官方群',
                'avatar' => '//tva2.sinaimg.cn/crop.0.0.199.199.180/005Zseqhjw1eplix1brxxj305k05kjrf.jpg',
            ),
        );

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
}