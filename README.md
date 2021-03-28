# softdd/apiexception
api 异常的简单封装，返回jso
## Installation
```bash
composer require softdd/apiexception
```
## Usage
在所有需要抛出异常的地方
```php
$error  = [
    'code'=>110,
     'msg'=>'msg',
     'httpCode'=>400,
     'headers'=>[]
];
throw (new \SoftDD\ApiException\ApiException($error)); 
// 更详细的定义可以用 ($error, $msg='',$detail=[],$previous=null)
```
可以把$error，以常量的方式放入到一个配置类中.

异常的输出json：
```php
[
    'status'=>0,        //0 表示存在异常，正常返回1
    'data'=>[
        'code'=>'code',
        'msg'=>'message',
        'detail'=>[...] //错误的详细信息，存在时下发。
    ]
];
```
