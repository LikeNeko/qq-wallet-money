<?php
/**
 * Created by PhpStorm.
 * User: Neko
 * Date: 2019/12/5
 * Time: 12:35 PM
 */

namespace utils\pay\qq;

use think\facade\App;

trait QQConfig
{
    private $pay_url = '';
    private $key = '';

    private $cert_path = '';
    private $key_path = '';

    /**
     * 分为单位
     *
     * @param $price
     *
     * @return $this
     */
    public function price($price = 0.00)
    {
        $price                     = floatTwo($price);
        $this->config['total_fee'] = (string)($price * 100);
        return $this;
    }

    public function openid($openid = '')
    {
        $this->config['openid'] = $openid;
        return $this;
    }


    /**
     * @return string
     */
    public function getKeyPath()
    {
        return $this->key_path;
    }

    /**
     * @return string
     */
    public function getCertPath()
    {
        return $this->cert_path;
    }

    /**
     * @param string $key_path
     */
    public function setKeyPath($key_path)
    {
        $this->key_path = $key_path;
    }

    /**
     * @param string $cert_path
     */
    public function setCertPath($cert_path)
    {
        $this->cert_path = $cert_path;
    }

    /**
     * @param string $pay_url
     */
    public function setPayUrl($pay_url)
    {
        $this->pay_url = $pay_url;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

}