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
    <link href="{{ asset('js/layui/css/layui.css?v=v2.2.5') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css?v=1.0.0') }}" rel="stylesheet">
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
    <script src="{{ asset('js/layui/layui.js?v=v2.2.5') }}"></script>
    <script>
        var user_id = '{{$user_id}}';
    </script>
    <script src="{{ asset('js/laychat.js?v=v1.0.1') }}"></script>
    @yield('scripts')

</body>
</html>