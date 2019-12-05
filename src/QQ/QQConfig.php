<?php
/**
 * Created by PhpStorm.
 * User: Neko
 * Date: 2019/12/5
 * Time: 12:35 PM
 */

namespace QQ;

trait QQConfig
{
    private $pay_url = 'https://api.qpay.qq.com/cgi-bin/epay/qpay_epay_b2c.cgi';
    private $key = '';

    private $cert_path = '';
    private $key_path = '';

    /**
     * 元为单位 如1.30元
     *
     * @param $price
     *
     * @return $this
     */
    public function price($price = 0.00)
    {
        $price = sprintf('%2.f', $price);

        $this->config['total_fee'] = (string)($price * 100);
        return $this;
    }

    /**
     * 同文档
     *
     * @param int $price
     *
     * @return $this
     */
    public function priceTo($price = 0)
    {
        $this->config['total_fee'] = $price;
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