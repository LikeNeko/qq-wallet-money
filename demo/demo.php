<?php
/**
 * Created by PhpStorm.
 * User: Neko
 * Date: 2019/12/5
 * Time: 4:40 PM
 */
if (is_file(__DIR__ . '/../autoload.php')) {
    require_once __DIR__ . '/../autoload.php';
}
if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

$obj = new \QQ\QQPay();


