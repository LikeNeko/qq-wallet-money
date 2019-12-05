<?php
/**
 * Created by PhpStorm.
 * User: Neko
 * Date: 2019/12/5
 * Time: 4:40 PM
 */

include '../src/QQ/QQConfig.php';
include '../src/QQ/QQException.php';
include '../src/QQ/QQUtilFunc.php';
include '../src/QQ/QQPay.php';

$key  = __DIR__.'/cert/key.pem';
$cert = __DIR__.'/cert/cert.pem';

$obj = new \QQ\QQPay([
    'momo'           => '提现啦！',
    'appid'          => '小程序appid',
    'mch_id'         => '',
    'op_user_id'     => '',
    'op_user_passwd' => md5('')
]);
// 设置好商户的key
$obj->setKey('litemob123litemob123litemob32101');
// 设置key.pem证书路径
$obj->setKeyPath($key);
// 设置cert.pem证书路径
$obj->setCertPath($cert);

// 设置打款金额 单位元
$obj->price(1.00);
// 设置打款金额的另一种写法，和文档需要的数值同步
$obj->priceTo(100);

$obj->openid('123');

$out = 123;

// 设置成功时的回调
$obj->success(function ($info) use ($out) {
    // 打款成功时会走这里
    var_dump($info);
    // $info 是qq打款成功的返回结果
    // $out 是外部的参数，可以传进来
    var_dump($out);
});
$obj->error(function ($info) use ($out) {
    // 打款失败时会走这里
    var_dump($info);
    // $info 是qq打款失败的返回结果
    // $out 是外部的参数，可以传进来
    var_dump($out);
});

// 另一种写法
$success = function ($info) use ($out) {
    // 打款成功时会走这里
    var_dump($info);
    // $info 是qq打款成功的返回结果
    // $out 是外部的参数，可以传进来
    var_dump($out);
};
$error = function ($info) use ($out) {
    // 打款失败时会走这里
    var_dump($info);
    // $info 是qq打款失败的返回结果
    // $out 是外部的参数，可以传进来
    var_dump($out);
};

// 这样也是可以的
$obj->success($success);
$obj->error($error);

// 你还可以这样写
$status = $obj->send($success,$error);
// $status 返回 'ok'  或者 $status => 'no'

// 只监听成功的回调
$status = $obj->send(function ($info) use ($out) {
    // 打款成功时会走这里
    var_dump($info);
    // $info 是qq打款成功的返回结果
    // $out 是外部的参数，可以传进来
    var_dump($out);
});

// 每次send返回的所有信息
$obj->result;
// 也可以手动设置配置
$obj->config['openid'] = 123;



