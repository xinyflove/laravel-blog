<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="{{ config('blog.author') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Web推送消息</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    {{-- Styles --}}
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>

    <div class="alert alert-success alert-dismissible fade in" role="alert" style="display: none;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Tip!</strong> <spna id="content"></spna>
    </div>

    <div class="container">
        <div class="page-header">
            <h2>介绍:</h2>
            <p class="lead"><strong>Web-msg-sender</strong>是一个web消息推送系统，基于<a href="https://github.com/walkor/phpsocket.io">PHPSocket.IO</a>开发。</p>
        </div>

        <h3>支持以下特性：</h3>
        <ul>
            <li>多浏览器支持</li>
            <li>支持针对单个用户推送消息</li>
            <li>支持向所有用户推送消息</li>
            <li>长连接推送（websocket或者comet），消息即时到达</li>
            <li>支持在线用户数实时统计推送（见页脚统计）</li>
            <li>支持在线页面数实时统计推送（见页脚统计）</li>
        </ul>

        <h3>测试:</h3>
        <p>当前用户uid：<strong class="uid"></strong></p>
        <p>
            可以通过url：
            <a id="send_to_one" href="http://www.workerman.net:2121/?type=publish&to=1445590039000&content=%E6%B6%88%E6%81%AF%E5%86%85%E5%AE%B9" target="_blank">
                <span style="color:#91BD09">
                    http://<span class="domain"></span>:2121?type=publish&to=<b class="uid"></b>&content=消息内容</span>
            </a>
            向当前用户发送消息
        </p>
        <p>
            可以通过url：
            <a href="http://www.workerman.net:2121/?type=publish&to=&content=%E6%B6%88%E6%81%AF%E5%86%85%E5%AE%B9" target="_blank"  id="send_to_all" >
                <span style="color:#91BD09"
                >http://<span class="domain"></span>:2121?type=publish&to=&content=消息内容</span>
            </a>
            向所有在线用户推送消息
        </p>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="text-muted text-center" id="online_box"></p>
            <p class="text-muted text-center">
                Powered by
                <a href="http://www.workerman.net/web-sender" target="_blank">
                    <strong>web-msg-sender!</strong>
                </a>
            </p>
        </div>
    </footer>

    <script src='https://cdn.bootcss.com/socket.io/2.0.3/socket.io.js'></script>
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    {{-- Scripts --}}
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
    <script>
        $(document).ready(function(){
            // 使用时替换成真实的uid，这里方便演示使用时间戳
            var uid = Date.parse(new Date());
            $('#send_to_one').attr('href', 'http://'+document.domain+':2121/?type=publish&content=%E6%B6%88%E6%81%AF%E5%86%85%E5%AE%B9&to='+uid);
            $('#send_to_all').attr('href', 'http://'+document.domain+':2121/?type=publish&content=%E6%B6%88%E6%81%AF%E5%86%85%E5%AE%B9');
            $('.uid').html(uid);
            $('.domain').html(document.domain);

            // 连接服务端
            var socket = io('http://'+document.domain+':2120');
            // 连接后登录
            socket.on('connect', function(){
                socket.emit('login', uid);
            });
            // 后端推送来消息时
            socket.on('new_msg', function(msg){
                $('#content').html('收到消息：'+msg);
                $('.alert').show();
            });
            // 后端推送来在线数据时
            socket.on('update_online_count', function(online_stat){
                $('#online_box').html(online_stat);
            });
        });
    </script>
</body>
</html>