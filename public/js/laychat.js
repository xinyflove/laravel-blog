
layui.use(['layim'], function(){

    var layim = layui.layim;

    //基础配置
    layim.config({

        //获取主面板列表信息
        init: {
            url: '/web-sender/getList' //接口地址（返回的数据格式见下文）
            ,type: 'get' //默认get，一般可不填
            ,data: {} //额外参数
        }

        //获取群员接口
        ,members: {
            url: '/web-sender/getMembers' //接口地址（返回的数据格式见下文）
            ,type: 'get' //默认get，一般可不填
            ,data: {} //额外参数
        }

        //上传图片接口（返回的数据格式见下文）
        ,uploadImage: {
            url: '' //接口地址（返回的数据格式见下文）
            ,type: 'post' //默认post
        }

        //上传文件接口（返回的数据格式见下文）
        ,uploadFile: {
            url: '' //接口地址（返回的数据格式见下文）
            ,type: 'post' //默认post
        }

        //扩展工具栏，下文会做进一步介绍（如果无需扩展，剔除该项即可）
        ,tool: [{
            alias: 'code' //工具别名
            ,title: '代码' //工具名称
            ,icon: '&#xe64e;' //工具图标，参考图标文档
        }]

        //增加皮肤选择，如果不想增加，可以剔除该项
        ,skin: [
            'http://xxx.com/skin.jpg',
        ]

        ,brief: false //是否简约模式（默认false，如果只用到在线客服，且不想显示主面板，可以设置 true）
        ,title: '我的LayIM' //主面板最小化后显示的名称
        ,min: false //用于设定主面板是否在页面打开时，始终最小化展现。默认false，即记录上次展开状态。
        ,right: '0px' //默认0px，用于设定主面板右偏移量。该参数可避免遮盖你页面右下角已经的bar。
        ,minRight: '200px' //用户控制聊天面板最小化时、及新消息提示层的相对right的px坐标。
        ,maxLength: 3000 //最长发送的字符长度，默认3000
        ,isfriend: true //是否开启好友（默认true，即开启）
        ,isgroup: true //是否开启群组（默认true，即开启）
        ,chatLog: '/chat/log/' //聊天记录地址（如果未填则不显示）
        ,find: '/find/' //查找好友/群的地址（如果未填则不显示）
        ,copyright: false //是否授权，如果通过官网捐赠获得LayIM，此处可填true
        ,msgbox: layui.cache.dir + 'css/modules/layim/html/msgbox.html' //消息盒子页面地址，若不开启，剔除该项即可
        ,find: layui.cache.dir + 'css/modules/layim/html/find.html' //发现页面地址，若不开启，剔除该项即可
        ,chatLog: layui.cache.dir + 'css/modules/layim/html/chatlog.html' //聊天记录页面地址，若不开启，剔除该项即可

    });

    // 建立WebSocket通讯
    var socket = io('http://'+document.domain+':3120');
    var msgcount = '3';//获取未读信息条数
    // 连接成功时触发
    socket.on('connect', function(){
        socket.emit('login', user_id);
        console.log("websocket握手成功!");
    });

    // 监听在线状态的切换事件
    layim.on('online', function(data){
        console.log('用户线状态'+data);
    });

    // 监听签名修改
    layim.on('sign', function(value){
        //$.post('{:U("Pub/sign")}', {sign:value}, function(data){}, 'json');
        console.log('用户签名修改为'+value);
    });

    //监听聊天窗口的切换
    layim.on('chatChange', function(res){
        var type = res.data.type;
        console.log(res);
        if(type === 'friend'){
            //模拟标注好友状态
            if(res.data.status=='online')
                layim.setChatStatus('<span style="color:#FF5722;">在线</span>');
            else
                layim.setChatStatus('<span style="color:#ccc;">离线</span>');
        } else if(type === 'group'){
            //wu
        }
    });

    // layim建立就绪
    layim.on('ready', function(res){
        if(msgcount!=0){
            layim.msgbox(msgcount); //模拟消息盒子有新消息，实际使用时，一般是动态获得
        }
        //console.log(res);
    });

    // 监听发送信息
    layim.on('sendMessage', function(res){
        //console.log(res);
        var mine = res.mine;//包含我发送的消息及我的信息
        var to = res.to;//对方的信息

        if(to.type === 'friend'){
            layim.setChatStatus('<span style="color:#FF5722;">对方正在输入。。。</span>');
        }

        // 监听到上述消息后，就可以轻松地发送socket了
        $.post(
            'http://'+document.domain+':3121',
            {mine:mine,to:to},
            //res,
            function(re){},
            'JSON'
        );
    });

    //监听收到的消息
    socket.on('new_msg', function(res){
        res = JSON.parse(res);
        if(res.emit === 'chatMessage'){
            layim.getMessage(res.data); //res.data即你发送消息传递的数据
        }
        console.log(res);
    });
});