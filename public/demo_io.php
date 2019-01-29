<?php
/**
 * SocketIO服务端
 */
require __DIR__.'/../vendor/autoload.php';

use Workerman\Worker;
use PHPSocketIO\SocketIO;

header('Access-Control-Allow-Origin:*');

// 创建socket.io服务端，监听3120端口
$io = new SocketIO(3120);

// 当有客户端连接时
$io->on('connection', function($socket){
    // 自定义login事件回调函数 当客户端发来登录事件时触发
    $socket->on('login', function ($uid)use($socket){
        // 已经登录过了
        if(isset($socket->uid)){
            return;
        }

        // 将这个连接加入到uid分组，方便针对uid推送数据
        $socket->join($uid);
        $socket->uid = $uid;

        echo $uid.'login';
    });
});

// 监听一个http端口，通过http协议访问这个端口可以向所有客户端推送数据(url类似http://ip:9191?msg=xxxx)
$io->on('workerStart', function()use($io) {
    // 监听一个http端口
    $inner_http_worker = new Worker('http://0.0.0.0:3121');
    // 当http客户端发来数据时触发
    $inner_http_worker->onMessage = function($http_connection, $data)use($io){
        $mine = $data['post']['mine'];
        $to = $data['post']['to'];

        $toid = $to['id'] ? $to['id'] : 0;
        $mine['content'] = htmlspecialchars($mine['content']);

        $msg = array(
            'emit' => 'chatMessage',
            'data' => array(
                'username' => $mine['username'],//消息来源用户名
                'avatar' => $mine['avatar'],//消息来源用户头像
                'id' => $mine['id'],//消息的来源ID（如果是私聊，则是用户id，如果是群聊，则是群组id）
                'type' => $to['type'],//聊天窗口来源类型，从发送消息传递的to里面获取
                'content' => $mine['content'],//消息内容
                'cid' => 0,//消息id，可不传。除非你要对消息进行一些操作（如撤回）
                'mine' => $mine['mine'],//是否我发送的消息，如果为true，则会显示在右方
                'fromid' => $mine['id'],//消息的发送者id（比如群组中的某个消息发送者），可用于自动解决浏览器多窗口时的一些问题
                'timestamp' => strtotime('now')*'1000',
            ),
        );

        // 有指定uid则向uid所在socket组发送数据
        if($toid){
            // 触发所有客户端定义的new_msg事件
            echo 'toid'.$toid;
            $io->to($toid)->emit('new_msg', json_encode($msg));
            // 否则向所有uid推送数据
        }else{
            $io->emit('new_msg', json_encode($msg));
        }

        // http接口返回，如果用户离线socket返回fail
        if(!$toid && !isset($uidConnectionMap[$to])){
            return $http_connection->send('offline');
        }else{
            return $http_connection->send('ok');
        }
    };
    $inner_http_worker->listen();
});


Worker::runAll();