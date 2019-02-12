<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="{{ config('blog.author') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>聊天记录</title>
    <link rel="shortcut icon" href="favicon.ico">

    {{-- Styles --}}
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/main.css?v=1.0.0') }}" rel="stylesheet">
    @yield('styles')
</head>
<body class="gray-bg">

    <div class="container wrapper-content">
        <div class="row">
            <div class="col-sm-12">
                <div id="chatlog">

                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        $(function(){
            $.getJSON("/web-sender/chatLogDetail", {'id':'{{$id}}','type':'{{$type}}'}, function(res){
                var _html = '';
                if(1 == res.code){
                    $.each(res.data, function(k, v){
                        _html += '<div class="chat-message"><div class="message"><a class="message-author" href="#"> '+ v.fromname +' </a>';
                        _html += '<span class="message-date"> '+ getLocalTime(v.timeline) +' </span>';
                        _html += '<span class="message-content">'+ parent.layui.layim.content(v.content) +'</span></div></div>';
                    });
                    $("#chatlog").html(_html);

                }else{

                }
            })
        });
        function getLocalTime(nS) {
            return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, "");
        }
    </script>
    @yield('scripts')

</body>
</html>