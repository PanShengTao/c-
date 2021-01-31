如果不使用模板，可以删除该目录

安装
composer create-project topthink/think tp

更新
composer update topthink/framework

安装thinkphp
composer create-project topthink/think=6.0.x-dev tp

修改端口
php think run -p 80

运行
php think run

View 模板
composer require topthink/think-view
验证码功能
composer require topthink/think-captcha
token校验
composer require firebase/php-jwt
添加中间件验证功能
php think make:middleware Check
