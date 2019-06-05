<?php
return [
    'name' => 'My Blog',
    'title' => 'My Blog',
    'subtitle' => 'http://laravelacademy.org',
    'description' => 'Laravel学院致力于提供优质Laravel中文学习资源',
    'author' => '学院君',
    'page_image' => 'home-bg.jpg',
    'posts_per_page' => 10,
    'uploads' => [
        'storage' => 'public',// 配置使用的文件系统
        'webpath' => '/storage',// 配置 Web 访问根目录
    ],
];